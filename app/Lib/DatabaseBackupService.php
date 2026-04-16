<?php
App::uses('Folder', 'Utility');
App::uses('ConnectionManager', 'Model');

class DatabaseBackupService
{
    const EXTENSION = 'sql.gz';

    protected $_backupPath;

    public function __construct($config = array())
    {
        $this->_backupPath = !empty($config['backupPath'])
            ? $config['backupPath']
            : Configure::read('Backups.databasePath');

        if (empty($this->_backupPath)) {
            $this->_backupPath = APP . 'tmp' . DS . 'backups' . DS . 'database' . DS;
        }

        $this->_backupPath = rtrim($this->_backupPath, DS) . DS;
    }

    public function getBackupPath()
    {
        $this->_ensureDirectory($this->_backupPath);
        return $this->_backupPath;
    }

    public function listBackups()
    {
        $folder = new Folder($this->getBackupPath());
        $files = $folder->find('.*\.sql\.gz');

        $items = array();
        foreach ($files as $file) {
            $path = $this->_backupPath . $file;
            if (!is_file($path)) {
                continue;
            }

            $items[] = array(
                'name' => $file,
                'path' => $path,
                'size' => filesize($path),
                'modified' => date('Y-m-d H:i:s', filemtime($path)),
                'modified_ts' => filemtime($path),
            );
        }

        usort($items, array($this, 'sortDesc'));
        return $items;
    }

    public function createBackup()
    {
        $workingDir = TMP . 'db_backup_' . uniqid('', true) . DS;
        $defaultsFile = $workingDir . 'mysql.cnf';
        $timestamp = date('Ymd_His');
        $filename = 'db_' . $timestamp . '.sql.gz';
        $targetPath = $this->getBackupPath() . $filename;

        try {
            $this->_ensureDirectory($workingDir);
            $this->_exportDatabase($targetPath, $defaultsFile);

            return array(
                'filename' => $filename,
                'path' => $targetPath,
                'size' => is_file($targetPath) ? filesize($targetPath) : 0,
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function restoreBackup($filename)
    {
        $this->assertValidFilename($filename);

        $fullPath = $this->getBackupPath() . $filename;
        if (!is_file($fullPath)) {
            throw new NotFoundException('Database backup not found.');
        }

        $workingDir = TMP . 'db_restore_' . uniqid('', true) . DS;
        $defaultsFile = $workingDir . 'mysql.cnf';

        try {
            $this->_ensureDirectory($workingDir);
            $this->_importDatabase($fullPath, $defaultsFile);
            return true;
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function deleteBackup($filename)
    {
        $this->assertValidFilename($filename);
        $fullPath = $this->getBackupPath() . $filename;

        if (!is_file($fullPath)) {
            throw new NotFoundException('Database backup not found.');
        }

        if (!@unlink($fullPath)) {
            throw new RuntimeException('Could not delete database backup.');
        }

        return true;
    }

    public function assertValidFilename($filename)
    {
        if (!preg_match('/^[a-zA-Z0-9._-]+\.sql\.gz$/', $filename)) {
            throw new BadRequestException('Invalid database backup filename.');
        }
    }

    public function sortDesc($a, $b)
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
    /*

    protected function _exportDatabase($targetPath, $defaultsFile)
    {

        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $command = sprintf(
            'mysqldump --defaults-extra-file=%s --single-transaction --routines --triggers %s | gzip > %s 2>&1',
            escapeshellarg($defaultsFile),
            escapeshellarg($config['database']),
            escapeshellarg($targetPath)
        );

        $output = array();
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !is_file($targetPath) || filesize($targetPath) === 0) {
            throw new RuntimeException('Database export failed. ' . implode("\n", $output));
        }
    }
    */

    /*
    protected function _exportDatabase($targetPath, $defaultsFile)
    {
        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $mysqldump = '/usr/bin/mysqldump';
        if (!is_executable($mysqldump)) {
            $mysqldump = 'mysqldump';
        }

        $tmpSqlPath = preg_replace('/\.gz$/', '', $targetPath);

        if (!is_writable(dirname($targetPath))) {
            throw new RuntimeException('Backup directory is not writable: ' . dirname($targetPath));
        }

        $command = sprintf(
            '%s --defaults-extra-file=%s --single-transaction --routines --triggers --result-file=%s %s 2>&1',
            escapeshellarg($mysqldump),
            escapeshellarg($defaultsFile),
            escapeshellarg($tmpSqlPath),
            escapeshellarg($config['database'])
        );

        $output = array();
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !is_file($tmpSqlPath) || filesize($tmpSqlPath) === 0) {
            throw new RuntimeException(
                'Database export failed. Command: ' . $command . ' Output: ' . implode("\n", $output)
            );
        }

        $in = fopen($tmpSqlPath, 'rb');
        if ($in === false) {
            @unlink($tmpSqlPath);
            throw new RuntimeException('Could not open temporary SQL dump for reading.');
        }

        $out = gzopen($targetPath, 'wb9');
        if ($out === false) {
            fclose($in);
            @unlink($tmpSqlPath);
            throw new RuntimeException('Could not open gzip backup file for writing.');
        }

        while (!feof($in)) {
            $chunk = fread($in, 1024 * 1024);
            if ($chunk === false) {
                gzclose($out);
                fclose($in);
                @unlink($tmpSqlPath);
                @unlink($targetPath);
                throw new RuntimeException('Failed while reading temporary SQL dump.');
            }
            gzwrite($out, $chunk);
        }

        gzclose($out);
        fclose($in);
        @unlink($tmpSqlPath);

        if (!is_file($targetPath) || filesize($targetPath) === 0) {
            throw new RuntimeException('Compressed database backup was not created.');
        }
    }
    protected function _importDatabase($sourcePath, $defaultsFile)
    {
        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $command = sprintf(
            'gzip -dc %s | mysql --defaults-extra-file=%s %s 2>&1',
            escapeshellarg($sourcePath),
            escapeshellarg($defaultsFile),
            escapeshellarg($config['database'])
        );

        $output = array();
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new RuntimeException('Database restore failed. ' . implode("\n", $output));
        }
    }
    */

    protected function _exportDatabase($targetPath, $defaultsFile)
    {
        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $mysqldump = '/usr/bin/mysqldump';
        if (!is_executable($mysqldump)) {
            $mysqldump = 'mysqldump';
        }

        if (!is_writable(dirname($targetPath))) {
            throw new RuntimeException('Backup directory is not writable: ' . dirname($targetPath));
        }

        $command = array(
            $mysqldump,
            '--defaults-extra-file=' . $defaultsFile,
            '--single-transaction',
            '--routines',
            '--triggers',
            $config['database'],
        );

        $descriptors = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );

        $process = proc_open($command, $descriptors, $pipes);

        if (!is_resource($process)) {
            throw new RuntimeException('Could not start mysqldump process.');
        }

        fclose($pipes[0]);

        $gz = gzopen($targetPath, 'wb9');
        if ($gz === false) {
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
            throw new RuntimeException('Could not open backup file for writing: ' . $targetPath);
        }

        $stderr = '';
        try {
            while (!feof($pipes[1])) {
                $chunk = fread($pipes[1], 1024 * 1024);
                if ($chunk === false) {
                    throw new RuntimeException('Failed reading mysqldump output.');
                }
                if ($chunk !== '') {
                    gzwrite($gz, $chunk);
                }
            }

            while (!feof($pipes[2])) {
                $chunk = fread($pipes[2], 8192);
                if ($chunk === false) {
                    break;
                }
                $stderr .= $chunk;
            }
        } finally {
            gzclose($gz);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $returnCode = proc_close($process);
        }

        if ($returnCode !== 0 || !is_file($targetPath) || filesize($targetPath) === 0) {
            @unlink($targetPath);
            throw new RuntimeException(
                'Database export failed. Return code: ' . $returnCode . '. Error: ' . trim($stderr)
            );
        }
    }

    protected function _importDatabase($sourcePath, $defaultsFile)
    {
        $config = $this->_getDatasourceConfig();
        $this->_writeMysqlDefaultsFile($defaultsFile);

        $mysql = '/usr/bin/mysql';
        if (!is_executable($mysql)) {
            $mysql = 'mysql';
        }

        if (!is_file($sourcePath) || filesize($sourcePath) === 0) {
            throw new RuntimeException('Backup file not found or empty: ' . $sourcePath);
        }

        $command = array(
            $mysql,
            '--defaults-extra-file=' . $defaultsFile,
            $config['database'],
        );

        $descriptors = array(
            0 => array('pipe', 'w'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );

        $process = proc_open($command, $descriptors, $pipes);

        if (!is_resource($process)) {
            throw new RuntimeException('Could not start mysql restore process.');
        }

        $gz = gzopen($sourcePath, 'rb');
        if ($gz === false) {
            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
            throw new RuntimeException('Could not open compressed backup for reading.');
        }

        $stderr = '';
        try {
            while (!gzeof($gz)) {
                $chunk = gzread($gz, 1024 * 1024);
                if ($chunk === false) {
                    throw new RuntimeException('Failed reading compressed backup.');
                }
                if ($chunk !== '') {
                    fwrite($pipes[0], $chunk);
                }
            }
        } finally {
            gzclose($gz);
            fclose($pipes[0]);
        }

        while (!feof($pipes[2])) {
            $chunk = fread($pipes[2], 8192);
            if ($chunk === false) {
                break;
            }
            $stderr .= $chunk;
        }

        fclose($pipes[1]);
        fclose($pipes[2]);
        $returnCode = proc_close($process);

        if ($returnCode !== 0) {
            throw new RuntimeException(
                'Database restore failed. Return code: ' . $returnCode . '. Error: ' . trim($stderr)
            );
        }
    }
}