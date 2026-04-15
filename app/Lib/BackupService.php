<?php
// app/Lib/BackupService.php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('ConnectionManager', 'Model');
class BackupService
{
    const BACKUP_EXTENSION = 'zip';
    protected $_backupPath;
    protected $_mediaPath;
    public function __construct($config = array())
    {
        $this->_backupPath = !empty($config['backupPath'])
            ? $config['backupPath']
            : (Configure::read('Backups.path') ?: APP . 'tmp' . DS . 'backups' . DS);

        $this->_mediaPath = !empty($config['mediaPath'])
            ? $config['mediaPath']
            : (Configure::read('Backups.mediaPath') ?: WWW_ROOT . 'media' . DS);

        $this->_backupPath = rtrim($this->_backupPath, DS) . DS;
        $this->_mediaPath = rtrim($this->_mediaPath, DS) . DS;
    }

    public function getBackupPath()
    {
        $this->_ensureDirectory($this->_backupPath);
        return $this->_backupPath;
    }

    public function getMediaPath()
    {
        return $this->_mediaPath;
    }

    public function listBackups()
    {
        $backupPath = $this->getBackupPath();
        $folder = new Folder($backupPath);
        $files = $folder->find('.*\.' . self::BACKUP_EXTENSION);

        $items = array();
        foreach ($files as $fileName) {
            $fullPath = $backupPath . $fileName;
            if (!is_file($fullPath)) {
                continue;
            }

            $items[] = array(
                'name' => $fileName,
                'path' => $fullPath,
                'size' => filesize($fullPath),
                'modified' => date('Y-m-d H:i:s', filemtime($fullPath)),
                'modified_ts' => filemtime($fullPath),
            );
        }

        usort($items, array($this, 'sortBackupsDesc'));
        return $items;
    }

    public function createBackup($userId = null)
    {
        $backupPath = $this->getBackupPath();
        $mediaPath = $this->getMediaPath();

        $timestamp = date('Ymd_His');
        $backupName = sprintf('backup_%s.%s', $timestamp, self::BACKUP_EXTENSION);
        $backupFile = $backupPath . $backupName;

        $workingDir = TMP . 'backup_' . uniqid('', true) . DS;
        $sqlFile = $workingDir . 'database.sql';
        $manifestFile = $workingDir . 'manifest.json';
        $mediaCopyPath = $workingDir . 'media' . DS;
        $defaultsFile = $workingDir . 'mysql.cnf';

        try {
            $this->_ensureDirectory($workingDir);

            $this->_exportDatabase($sqlFile, $defaultsFile);

            if (is_dir($mediaPath)) {
                $this->_copyDirectory($mediaPath, $mediaCopyPath);
            } else {
                $this->_ensureDirectory($mediaCopyPath);
            }

            $manifest = array(
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $userId,
                'app' => Configure::read('Site.name') ? Configure::read('Site.name') : 'SIS',
                'contents' => array('database.sql', 'media/'),
                'media_source' => $mediaPath,
                'db_config' => $this->_getDatabaseSummary(),
            );

            file_put_contents($manifestFile, json_encode($manifest, JSON_PRETTY_PRINT));
            $this->_zipDirectory($workingDir, $backupFile);

            return array(
                'name' => $backupName,
                'path' => $backupFile,
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function restoreBackup($filename)
    {
        $this->assertValidBackupFilename($filename);

        $backupFile = $this->getBackupPath() . $filename;
        if (!is_file($backupFile)) {
            throw new NotFoundException('Backup file not found.');
        }

        $workingDir = TMP . 'restore_' . uniqid('', true) . DS;
        $defaultsFile = $workingDir . 'mysql.cnf';
        $sqlFile = $workingDir . 'database.sql';
        $extractedMediaPath = $workingDir . 'media' . DS;
        $liveMediaPath = $this->getMediaPath();
        $previousMediaPath = rtrim($liveMediaPath, DS) . '_before_restore_' . date('Ymd_His') . DS;

        try {
            $this->_ensureDirectory($workingDir);
            $this->_extractZip($backupFile, $workingDir);

            if (!is_file($sqlFile)) {
                throw new RuntimeException('database.sql not found in backup archive.');
            }

            if (!is_dir($extractedMediaPath)) {
                throw new RuntimeException('media directory not found in backup archive.');
            }

            $this->_importDatabase($sqlFile, $defaultsFile);

            if (is_dir($liveMediaPath)) {
                if (!@rename($liveMediaPath, $previousMediaPath)) {
                    throw new RuntimeException('Could not move existing media directory before restore.');
                }
            }

            $this->_copyDirectory($extractedMediaPath, $liveMediaPath);

            return array(
                'previous_media_path' => $previousMediaPath,
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function deleteBackup($filename)
    {
        $this->assertValidBackupFilename($filename);

        $fullPath = $this->getBackupPath() . $filename;
        if (!is_file($fullPath)) {
            throw new NotFoundException('Backup file not found.');
        }

        if (!@unlink($fullPath)) {
            throw new RuntimeException('Could not delete backup file.');
        }

        return true;
    }

    public function pruneBackups($days = 30)
    {
        $days = (int)$days;
        if ($days < 1) {
            $days = 30;
        }

        $cutoff = strtotime('-' . $days . ' days');
        $deleted = 0;

        foreach ($this->listBackups() as $backup) {
            if ($backup['modified_ts'] < $cutoff && is_file($backup['path'])) {
                if (@unlink($backup['path'])) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }

    public function assertValidBackupFilename($filename)
    {
        $pattern = '/^[a-zA-Z0-9._-]+\.' . preg_quote(self::BACKUP_EXTENSION, '/') . '$/';
        if (!preg_match($pattern, $filename)) {
            throw new BadRequestException('Invalid backup filename.');
        }
    }

    public function sortBackupsDesc($a, $b)
    {
        if ($a['modified_ts'] === $b['modified_ts']) {
            return 0;
        }
        return ($a['modified_ts'] > $b['modified_ts']) ? -1 : 1;
    }

    protected function _ensureDirectory($path)
    {
        $folder = new Folder();
        if (!is_dir($path) && !$folder->create($path, 0755)) {
            throw new RuntimeException('Could not create directory: ' . $path);
        }
    }

    protected function _removeDirectory($path)
    {
        if (!is_dir($path)) {
            return;
        }

        $folder = new Folder($path);
        $folder->delete($path);
    }

    protected function _getDatasourceConfig()
    {
        $dataSource = ConnectionManager::getDataSource('default');

        if (empty($dataSource->config['database'])) {
            throw new RuntimeException('Default datasource is not configured properly.');
        }

        return $dataSource->config;
    }

    protected function _getDatabaseSummary()
    {
        $config = $this->_getDatasourceConfig();

        return array(
            'datasource' => isset($config['datasource']) ? $config['datasource'] : null,
            'host' => isset($config['host']) ? $config['host'] : 'localhost',
            'port' => isset($config['port']) ? $config['port'] : '3306',
            'database' => $config['database'],
        );
    }

    protected function _writeMysqlDefaultsFile($filePath)
    {
        $config = $this->_getDatasourceConfig();

        $contents = "[client]\n";
        $contents .= 'user=' . (isset($config['login']) ? $config['login'] : '') . "\n";
        $contents .= 'password=' . (isset($config['password']) ? $config['password'] : '') . "\n";
        $contents .= 'host=' . (isset($config['host']) ? $config['host'] : '127.0.0.1') . "\n";

        if (!empty($config['port'])) {
            $contents .= 'port=' . $config['port'] . "\n";
        }

        file_put_contents($filePath, $contents);
        @chmod($filePath, 0600);
    }

    protected function _exportDatabase($sqlFile, $defaultsFile)
    {
        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $command = sprintf(
            'mysqldump --defaults-extra-file=%s --single-transaction --routines --triggers %s > %s 2>&1',
            escapeshellarg($defaultsFile),
            escapeshellarg($config['database']),
            escapeshellarg($sqlFile)
        );

        $output = array();
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !is_file($sqlFile) || filesize($sqlFile) === 0) {
            throw new RuntimeException('Database export failed. ' . implode("\n", $output));
        }
    }

    protected function _importDatabase($sqlFile, $defaultsFile)
    {
        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $command = sprintf(
            'mysql --defaults-extra-file=%s %s < %s 2>&1',
            escapeshellarg($defaultsFile),
            escapeshellarg($config['database']),
            escapeshellarg($sqlFile)
        );

        $output = array();
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new RuntimeException('Database import failed. ' . implode("\n", $output));
        }
    }

    protected function _zipDirectory($sourceDir, $zipFile)
    {
        if (!class_exists('ZipArchive')) {
            throw new RuntimeException('ZipArchive extension is required.');
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Could not create zip file: ' . $zipFile);
        }

        $sourceDir = rtrim($sourceDir, DS) . DS;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $fullPath = $item->getPathname();
            $localPath = substr($fullPath, strlen($sourceDir));
            $localPath = str_replace(DS, '/', $localPath);

            if ($item->isDir()) {
                $zip->addEmptyDir($localPath);
            } else {
                $zip->addFile($fullPath, $localPath);
            }
        }

        $zip->close();
    }

    protected function _extractZip($zipFile, $targetDir)
    {
        if (!class_exists('ZipArchive')) {
            throw new RuntimeException('ZipArchive extension is required.');
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFile) !== true) {
            throw new RuntimeException('Could not open zip file: ' . $zipFile);
        }

        if (!$zip->extractTo($targetDir)) {
            $zip->close();
            throw new RuntimeException('Could not extract zip file.');
        }

        $zip->close();
    }

    protected function _copyDirectory($source, $destination)
    {
        $source = rtrim($source, DS) . DS;
        $destination = rtrim($destination, DS) . DS;

        if (!is_dir($source)) {
            throw new RuntimeException('Source directory does not exist: ' . $source);
        }

        $this->_ensureDirectory($destination);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $targetPath = $destination . substr($item->getPathname(), strlen($source));

            if ($item->isDir()) {
                $this->_ensureDirectory($targetPath);
            } else {
                $parentDir = dirname($targetPath);
                $this->_ensureDirectory($parentDir);

                if (!copy($item->getPathname(), $targetPath)) {
                    throw new RuntimeException('Could not copy file: ' . $item->getPathname());
                }
            }
        }
    }
}