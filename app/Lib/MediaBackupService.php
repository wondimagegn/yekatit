<?php
App::uses('Folder', 'Utility');
App::uses('ConnectionManager', 'Model');
class MediaBackupService
{
    protected $_mediaPath;
    protected $_fullBackupPath;
    protected $_incrementalBackupPath;

    public function __construct($config = array())
    {
        $this->_mediaPath = !empty($config['mediaPath'])
            ? $config['mediaPath']
            : Configure::read('Backups.mediaPath');

        $this->_fullBackupPath = !empty($config['fullBackupPath'])
            ? $config['fullBackupPath']
            : Configure::read('Backups.mediaFullPath');

        $this->_incrementalBackupPath = !empty($config['incrementalBackupPath'])
            ? $config['incrementalBackupPath']
            : Configure::read('Backups.mediaIncrementalPath');

        if (empty($this->_mediaPath)) {
            $this->_mediaPath = WWW_ROOT . 'media' . DS;
        }

        if (empty($this->_fullBackupPath)) {
            $this->_fullBackupPath = APP . 'tmp' . DS . 'backups' . DS . 'media' . DS . 'full' . DS;
        }

        if (empty($this->_incrementalBackupPath)) {
            $this->_incrementalBackupPath = APP . 'tmp' . DS . 'backups' . DS . 'media' . DS . 'incremental' . DS;
        }

        $this->_mediaPath = rtrim($this->_mediaPath, DS) . DS;
        $this->_fullBackupPath = rtrim($this->_fullBackupPath, DS) . DS;
        $this->_incrementalBackupPath = rtrim($this->_incrementalBackupPath, DS) . DS;
    }

    public function getMediaPath()
    {
        return $this->_mediaPath;
    }

    public function getFullBackupPath()
    {
        $this->_ensureDirectory($this->_fullBackupPath);
        return $this->_fullBackupPath;
    }

    public function getIncrementalBackupPath()
    {
        $this->_ensureDirectory($this->_incrementalBackupPath);
        return $this->_incrementalBackupPath;
    }

    public function listFullBackups()
    {
        return $this->_listArchives($this->getFullBackupPath(), 'media_full_');
    }

    public function listIncrementalBackups()
    {
        return $this->_listArchives($this->getIncrementalBackupPath(), 'media_inc_');
    }

    public function createFullBackup()
    {
        $timestamp = date('Ymd_His');
        $filename = 'media_full_' . $timestamp . '.zip';
        $manifestFilename = 'media_full_' . $timestamp . '.manifest.json';
        $zipPath = $this->getFullBackupPath() . $filename;
        $manifestPath = $this->getFullBackupPath() . $manifestFilename;
        $workingDir = TMP . 'media_full_' . uniqid('', true) . DS;
        $stagingMediaPath = $workingDir . 'media' . DS;

        try {
            $this->_ensureDirectory($workingDir);

            if (is_dir($this->_mediaPath)) {
                $this->_copyDirectory($this->_mediaPath, $stagingMediaPath);
            } else {
                $this->_ensureDirectory($stagingMediaPath);
            }

            $manifest = array(
                'type' => 'media_full',
                'created_at' => date('Y-m-d H:i:s'),
                'media_path' => $this->_mediaPath,
                'files' => $this->_scanDirectoryManifest($this->_mediaPath),
                'deleted' => array(),
                'base_full' => $filename,
                'previous_manifest' => null,
            );

            file_put_contents($workingDir . 'manifest.json', json_encode($manifest, JSON_PRETTY_PRINT));
            file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
            $this->_zipDirectory($workingDir, $zipPath);

            return array(
                'filename' => $filename,
                'path' => $zipPath,
                'size' => is_file($zipPath) ? filesize($zipPath) : 0,
                'manifest_path' => $manifestPath,
                'manifest_json' => json_encode($manifest, JSON_PRETTY_PRINT),
                'base_filename' => $filename,
                'is_incremental' => 0,
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function createIncrementalBackup($previousManifestPath = null)
    {
        if ($previousManifestPath === null) {
            $previousManifestPath = $this->getLatestManifestPath();
        }

        if (empty($previousManifestPath) || !is_file($previousManifestPath)) {
            throw new RuntimeException('No previous media manifest found. Create a full media backup first.');
        }

        $previousManifest = json_decode(file_get_contents($previousManifestPath), true);
        if (empty($previousManifest) || empty($previousManifest['files'])) {
            throw new RuntimeException('Previous media manifest is invalid.');
        }

        $currentFiles = $this->_scanDirectoryManifest($this->_mediaPath);
        $previousFiles = $previousManifest['files'];

        $changed = array();
        $deleted = array();

        foreach ($currentFiles as $relativePath => $meta) {
            if (empty($previousFiles[$relativePath])) {
                $changed[$relativePath] = $meta;
                continue;
            }

            $old = $previousFiles[$relativePath];
            if (
                $old['size'] != $meta['size'] ||
                $old['mtime'] != $meta['mtime'] ||
                $old['sha1'] !== $meta['sha1']
            ) {
                $changed[$relativePath] = $meta;
            }
        }

        foreach ($previousFiles as $relativePath => $meta) {
            if (!isset($currentFiles[$relativePath])) {
                $deleted[] = $relativePath;
            }
        }

        $timestamp = date('Ymd_His');
        $filename = 'media_inc_' . $timestamp . '.zip';
        $manifestFilename = 'media_inc_' . $timestamp . '.manifest.json';
        $zipPath = $this->getIncrementalBackupPath() . $filename;
        $manifestPath = $this->getIncrementalBackupPath() . $manifestFilename;
        $workingDir = TMP . 'media_inc_' . uniqid('', true) . DS;
        $stagingMediaPath = $workingDir . 'media' . DS;

        try {
            $this->_ensureDirectory($workingDir);
            $this->_ensureDirectory($stagingMediaPath);

            foreach ($changed as $relativePath => $meta) {
                $sourcePath = $this->_mediaPath . str_replace('/', DS, $relativePath);
                $targetPath = $stagingMediaPath . str_replace('/', DS, $relativePath);

                $this->_ensureDirectory(dirname($targetPath));
                if (!copy($sourcePath, $targetPath)) {
                    throw new RuntimeException('Could not copy changed media file: ' . $sourcePath);
                }
            }

            $manifest = array(
                'type' => 'media_incremental',
                'created_at' => date('Y-m-d H:i:s'),
                'media_path' => $this->_mediaPath,
                'files' => $currentFiles,
                'changed' => array_keys($changed),
                'changed_count' => count($changed),
                'deleted' => array_values($deleted),
                'deleted_count' => count($deleted),
                'base_full' => !empty($previousManifest['base_full']) ? $previousManifest['base_full'] : null,
                'previous_manifest' => basename($previousManifestPath),
            );

            file_put_contents($workingDir . 'manifest.json', json_encode($manifest, JSON_PRETTY_PRINT));
            file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT));
            $this->_zipDirectory($workingDir, $zipPath);

            return array(
                'filename' => $filename,
                'path' => $zipPath,
                'size' => is_file($zipPath) ? filesize($zipPath) : 0,
                'manifest_path' => $manifestPath,
                'manifest_json' => json_encode($manifest, JSON_PRETTY_PRINT),
                'base_filename' => !empty($manifest['base_full']) ? $manifest['base_full'] : null,
                'is_incremental' => 1,
                'changed_count' => count($changed),
                'deleted_count' => count($deleted),
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function restoreFullBackup($filename)
    {
        $this->_assertValidFullFilename($filename);

        $zipPath = $this->getFullBackupPath() . $filename;
        if (!is_file($zipPath)) {
            throw new NotFoundException('Media full backup not found.');
        }

        return $this->_restoreSingleZipToMedia($zipPath);
    }

    public function restoreIncrementalChain($targetIncrementalFilename)
    {
        $this->_assertValidIncrementalFilename($targetIncrementalFilename);

        $incrementalZipPath = $this->getIncrementalBackupPath() . $targetIncrementalFilename;
        if (!is_file($incrementalZipPath)) {
            throw new NotFoundException('Media incremental backup not found.');
        }

        $targetManifestPath = $this->getIncrementalBackupPath() . str_replace('.zip', '.manifest.json', $targetIncrementalFilename);
        if (!is_file($targetManifestPath)) {
            throw new RuntimeException('Target incremental manifest not found.');
        }

        $targetManifest = json_decode(file_get_contents($targetManifestPath), true);
        if (empty($targetManifest['base_full'])) {
            throw new RuntimeException('Incremental backup does not reference a base full backup.');
        }

        $baseFullFilename = $targetManifest['base_full'];
        $baseFullZipPath = $this->getFullBackupPath() . $baseFullFilename;
        if (!is_file($baseFullZipPath)) {
            throw new RuntimeException('Base full media backup not found: ' . $baseFullFilename);
        }

        $liveMediaPath = $this->getMediaPath();
        $previousMediaPath = rtrim($liveMediaPath, DS) . '_before_restore_' . date('Ymd_His') . DS;
        $workingDir = TMP . 'media_chain_restore_' . uniqid('', true) . DS;

        try {
            $this->_ensureDirectory($workingDir);

            if (is_dir($liveMediaPath)) {
                if (!@rename($liveMediaPath, $previousMediaPath)) {
                    throw new RuntimeException('Could not move current media before restore.');
                }
            }

            $this->_extractZipInto($baseFullZipPath, $workingDir);
            $this->_copyExtractedMediaToLive($workingDir . 'media' . DS, $liveMediaPath);

            $incrementals = $this->_getIncrementalChainForBaseUntilTarget($baseFullFilename, $targetIncrementalFilename);

            foreach ($incrementals as $incremental) {
                $this->_removeDirectory($workingDir);
                $this->_ensureDirectory($workingDir);

                $incZipPath = $this->getIncrementalBackupPath() . $incremental['filename'];
                $incManifestPath = $incremental['manifest_path'];

                $this->_extractZipInto($incZipPath, $workingDir);

                if (is_dir($workingDir . 'media' . DS)) {
                    $this->_copyDirectory($workingDir . 'media' . DS, $liveMediaPath);
                }

                $manifest = json_decode(file_get_contents($incManifestPath), true);
                if (!empty($manifest['deleted'])) {
                    foreach ($manifest['deleted'] as $relativePath) {
                        $fullDeletePath = $liveMediaPath . str_replace('/', DS, $relativePath);
                        if (is_file($fullDeletePath)) {
                            @unlink($fullDeletePath);
                        }
                    }
                }
            }

            return array(
                'previous_media_path' => $previousMediaPath,
                'base_full' => $baseFullFilename,
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    public function deleteFullBackup($filename)
    {
        $this->_assertValidFullFilename($filename);
        $path = $this->getFullBackupPath() . $filename;
        $manifestPath = $this->getFullBackupPath() . str_replace('.zip', '.manifest.json', $filename);

        if (!is_file($path)) {
            throw new NotFoundException('Media full backup not found.');
        }

        if (!@unlink($path)) {
            throw new RuntimeException('Could not delete media full backup.');
        }

        if (is_file($manifestPath)) {
            @unlink($manifestPath);
        }

        return true;
    }

    public function deleteIncrementalBackup($filename)
    {
        $this->_assertValidIncrementalFilename($filename);
        $path = $this->getIncrementalBackupPath() . $filename;
        $manifestPath = $this->getIncrementalBackupPath() . str_replace('.zip', '.manifest.json', $filename);

        if (!is_file($path)) {
            throw new NotFoundException('Media incremental backup not found.');
        }

        if (!@unlink($path)) {
            throw new RuntimeException('Could not delete media incremental backup.');
        }

        if (is_file($manifestPath)) {
            @unlink($manifestPath);
        }

        return true;
    }

    public function getLatestManifestPath()
    {
        $incremental = $this->listIncrementalBackups();
        if (!empty($incremental)) {
            return $this->getIncrementalBackupPath() . str_replace('.zip', '.manifest.json', $incremental[0]['name']);
        }

        $full = $this->listFullBackups();
        if (!empty($full)) {
            return $this->getFullBackupPath() . str_replace('.zip', '.manifest.json', $full[0]['name']);
        }

        return null;
    }

    protected function _listArchives($path, $prefix)
    {
        $folder = new Folder($path);
        $files = $folder->find('^' . preg_quote($prefix, '/') . '.*\.zip$');

        $items = array();
        foreach ($files as $file) {
            $fullPath = $path . $file;
            if (!is_file($fullPath)) {
                continue;
            }

            $manifestPath = $path . str_replace('.zip', '.manifest.json', $file);
            $manifest = is_file($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : array();

            $items[] = array(
                'name' => $file,
                'filename' => $file,
                'path' => $fullPath,
                'manifest_path' => $manifestPath,
                'size' => filesize($fullPath),
                'modified' => date('Y-m-d H:i:s', filemtime($fullPath)),
                'modified_ts' => filemtime($fullPath),
                'base_full' => !empty($manifest['base_full']) ? $manifest['base_full'] : null,
                'changed_count' => !empty($manifest['changed_count']) ? $manifest['changed_count'] : 0,
                'deleted_count' => !empty($manifest['deleted_count']) ? $manifest['deleted_count'] : 0,
            );
        }

        usort($items, array($this, 'sortDesc'));
        return $items;
    }

    protected function _scanDirectoryManifest($sourceDir)
    {
        $sourceDir = rtrim($sourceDir, DS) . DS;
        $result = array();

        if (!is_dir($sourceDir)) {
            return $result;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile()) {
                continue;
            }

            $fullPath = $fileInfo->getPathname();
            $relativePath = substr($fullPath, strlen($sourceDir));
            $relativePath = str_replace(DS, '/', $relativePath);

            $result[$relativePath] = array(
                'size' => $fileInfo->getSize(),
                'mtime' => $fileInfo->getMTime(),
                'sha1' => sha1_file($fullPath),
            );
        }

        ksort($result);
        return $result;
    }

    protected function _restoreSingleZipToMedia($zipPath)
    {
        $workingDir = TMP . 'media_full_restore_' . uniqid('', true) . DS;
        $liveMediaPath = $this->getMediaPath();
        $previousMediaPath = rtrim($liveMediaPath, DS) . '_before_restore_' . date('Ymd_His') . DS;

        try {
            $this->_ensureDirectory($workingDir);

            if (is_dir($liveMediaPath)) {
                if (!@rename($liveMediaPath, $previousMediaPath)) {
                    throw new RuntimeException('Could not move current media before restore.');
                }
            }

            $this->_extractZipInto($zipPath, $workingDir);
            $this->_copyExtractedMediaToLive($workingDir . 'media' . DS, $liveMediaPath);

            return array(
                'previous_media_path' => $previousMediaPath,
            );
        } finally {
            $this->_removeDirectory($workingDir);
        }
    }

    protected function _copyExtractedMediaToLive($extractedMediaPath, $liveMediaPath)
    {
        if (!is_dir($extractedMediaPath)) {
            throw new RuntimeException('Extracted media directory not found in backup.');
        }

        $this->_copyDirectory($extractedMediaPath, $liveMediaPath);
    }

    protected function _getIncrementalChainForBaseUntilTarget($baseFullFilename, $targetIncrementalFilename)
    {
        $incrementals = $this->listIncrementalBackups();
        $selected = array();

        foreach ($incrementals as $item) {
            if ($item['base_full'] !== $baseFullFilename) {
                continue;
            }
            $selected[] = array(
                'filename' => $item['filename'],
                'manifest_path' => $item['manifest_path'],
                'modified_ts' => $item['modified_ts'],
            );
        }

        usort($selected, array($this, 'sortAsc'));

        $result = array();
        foreach ($selected as $item) {
            $result[] = $item;
            if ($item['filename'] === $targetIncrementalFilename) {
                break;
            }
        }

        $found = false;
        foreach ($result as $item) {
            if ($item['filename'] === $targetIncrementalFilename) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new RuntimeException('Target incremental backup not found in restore chain.');
        }

        return $result;
    }

    protected function _extractZipInto($zipPath, $targetDir)
    {
        if (!class_exists('ZipArchive')) {
            throw new RuntimeException('ZipArchive extension is required.');
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            throw new RuntimeException('Could not open zip file: ' . $zipPath);
        }

        if (!$zip->extractTo($targetDir)) {
            $zip->close();
            throw new RuntimeException('Could not extract zip file.');
        }

        $zip->close();
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
                $this->_ensureDirectory(dirname($targetPath));
                if (!copy($item->getPathname(), $targetPath)) {
                    throw new RuntimeException('Could not copy file: ' . $item->getPathname());
                }
            }
        }
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

    protected function _assertValidFullFilename($filename)
    {
        if (!preg_match('/^[a-zA-Z0-9._-]+\.zip$/', $filename) || strpos($filename, 'media_full_') !== 0) {
            throw new BadRequestException('Invalid media full backup filename.');
        }
    }

    protected function _assertValidIncrementalFilename($filename)
    {
        if (!preg_match('/^[a-zA-Z0-9._-]+\.zip$/', $filename) || strpos($filename, 'media_inc_') !== 0) {
            throw new BadRequestException('Invalid media incremental backup filename.');
        }
    }

    public function sortDesc($a, $b)
    {
        if ($a['modified_ts'] === $b['modified_ts']) {
            return 0;
        }
        return ($a['modified_ts'] > $b['modified_ts']) ? -1 : 1;
    }

    public function sortAsc($a, $b)
    {
        if ($a['modified_ts'] === $b['modified_ts']) {
            return 0;
        }
        return ($a['modified_ts'] < $b['modified_ts']) ? -1 : 1;
    }
}