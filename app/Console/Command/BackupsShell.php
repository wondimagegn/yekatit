<?php
App::uses('AppShell', 'Console/Command');
App::uses('ClassRegistry', 'Utility');
App::uses('DatabaseBackupService', 'Lib');
App::uses('MediaBackupService', 'Lib');

class BackupsShell extends AppShell
{
    public $uses = array('Backup');

    protected $_databaseBackupService = null;
    protected $_mediaBackupService = null;

    public function startup()
    {
        parent::startup();

        if (empty($this->Backup)) {
            $this->Backup = ClassRegistry::init('Backup');
        }
    }

    public function main()
    {
        $this->out('Usage:');
        $this->out('  Console/cake backups database');
        $this->out('  Console/cake backups media_full');
        $this->out('  Console/cake backups media_incremental');
        $this->out('  Console/cake backups all');
        $this->out('  Console/cake backups prune_database 30');
        $this->out('  Console/cake backups prune_media_full 30');
        $this->out('  Console/cake backups prune_media_incremental 14');
    }

    protected function _getDatabaseBackupService()
    {
        if ($this->_databaseBackupService === null) {
            $this->_databaseBackupService = new DatabaseBackupService();
        }

        return $this->_databaseBackupService;
    }

    protected function _getMediaBackupService()
    {
        if ($this->_mediaBackupService === null) {
            $this->_mediaBackupService = new MediaBackupService();
        }

        return $this->_mediaBackupService;
    }

    public function database()
    {
        try {
            $result = $this->_getDatabaseBackupService()->createBackup();

            $this->Backup->createBackupRecord(array(
                'name' => $result['filename'],
                'filename' => $result['filename'],
                'path' => $result['path'],
                'backup_category' => 'database',
                'size' => $result['size'],
                'created_by' => null,
                'notes' => 'Created by shell/cron',
            ));

            $this->out('Database backup created: ' . $result['filename']);
        } catch (Exception $e) {
            $this->err('Database backup failed: ' . $e->getMessage());
            CakeLog::write('error', 'Database backup failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }
    /*

    public function media_full()
    {
        try {
            $result = $this->_getMediaBackupService()->createFullBackup();

            $this->Backup->createBackupRecord(array(
                'name' => $result['filename'],
                'filename' => $result['filename'],
                'path' => $result['path'],
                'backup_category' => 'media_full',
                'size' => $result['size'],
                'manifest_json' => $result['manifest_json'],
                'manifest_path' => $result['manifest_path'],
                'base_filename' => $result['base_filename'],
                'is_incremental' => 0,
                'created_by' => null,
                'notes' => 'Created by shell/cron',
            ));

            $this->out('Media full backup created: ' . $result['filename']);
        } catch (Exception $e) {
            $this->err('Media full backup failed: ' . $e->getMessage());
            CakeLog::write('error', 'Media full backup failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }
    */

    public function media_full()
    {
        try {
            $this->out('Starting media full backup...');
            $this->out('Instantiating service...');
            $service = $this->_getMediaBackupService();

            $this->out('Creating media full backup...');
            $result = $service->createFullBackup();

            $this->out('Backup archive created: ' . $result['filename']);
            $this->out('Saving database record...');

            $this->Backup->createBackupRecord(array(
                'name' => $result['filename'],
                'filename' => $result['filename'],
                'path' => $result['path'],
                'backup_category' => 'media_full',
                'size' => $result['size'],
                'manifest_json' => $result['manifest_json'],
                'manifest_path' => $result['manifest_path'],
                'base_filename' => $result['base_filename'],
                'is_incremental' => 0,
                'created_by' => null,
                'notes' => 'Created by shell/cron',
            ));

            $this->out('Media full backup created: ' . $result['filename']);
        } catch (Exception $e) {
            $this->err('Media full backup failed: ' . $e->getMessage());
            CakeLog::write('error', 'Media full backup failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }

    public function media_incremental()
    {
        try {
            $result = $this->_getMediaBackupService()->createIncrementalBackup();

            $parentRecord = $this->Backup->find('first', array(
                'conditions' => array('Backup.filename' => $result['base_filename']),
                'fields' => array('Backup.id'),
                'recursive' => -1,
                'order' => array('Backup.id' => 'DESC')
            ));

            $this->Backup->createBackupRecord(array(
                'name' => $result['filename'],
                'filename' => $result['filename'],
                'path' => $result['path'],
                'backup_category' => 'media_incremental',
                'size' => $result['size'],
                'manifest_json' => $result['manifest_json'],
                'manifest_path' => $result['manifest_path'],
                'base_filename' => $result['base_filename'],
                'is_incremental' => 1,
                'parent_backup_id' => !empty($parentRecord['Backup']['id']) ? $parentRecord['Backup']['id'] : null,
                'created_by' => null,
                'notes' => sprintf(
                    'Created by shell/cron (%d changed, %d deleted)',
                    isset($result['changed_count']) ? (int)$result['changed_count'] : 0,
                    isset($result['deleted_count']) ? (int)$result['deleted_count'] : 0
                ),
            ));

            $this->out(sprintf(
                'Media incremental backup created: %s (%d changed, %d deleted)',
                $result['filename'],
                isset($result['changed_count']) ? (int)$result['changed_count'] : 0,
                isset($result['deleted_count']) ? (int)$result['deleted_count'] : 0
            ));
        } catch (Exception $e) {
            $this->err('Media incremental backup failed: ' . $e->getMessage());
            CakeLog::write('error', 'Media incremental backup failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }

    public function all()
    {
        $this->database();

        $hasFullBackup = $this->Backup->find('count', array(
            'conditions' => array(
                'Backup.backup_category' => 'media_full',
                'Backup.status !=' => 'deleted'
            ),
            'recursive' => -1
        ));

        if ((int)$hasFullBackup === 0) {
            $this->out('No media full backup found. Creating media full backup.');
            $this->media_full();
            return;
        }

        $this->media_incremental();
    }

    public function prune_database()
    {
        $days = !empty($this->args[0]) ? (int)$this->args[0] : 30;
        if ($days < 1) {
            $days = 30;
        }

        try {
            $deletedFilenames = $this->_getDatabaseBackupService()->pruneBackups($days);

            if (!empty($deletedFilenames)) {
                $this->Backup->updateAll(
                    array(
                        'Backup.status' => "'deleted'",
                        'Backup.error_message' => 'NULL'
                    ),
                    array(
                        'Backup.filename' => $deletedFilenames,
                        'Backup.backup_category' => 'database'
                    )
                );
            }

            $this->out(sprintf('Deleted %d database backup(s).', count($deletedFilenames)));
        } catch (Exception $e) {
            $this->err('Prune database failed: ' . $e->getMessage());
            CakeLog::write('error', 'Prune database failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }

    public function prune_media_full()
    {
        $days = !empty($this->args[0]) ? (int)$this->args[0] : 30;
        if ($days < 1) {
            $days = 30;
        }

        try {
            $result = $this->_getMediaBackupService()->pruneFullBackups($days, true);

            if (!empty($result['deleted'])) {
                $this->Backup->updateAll(
                    array(
                        'Backup.status' => "'deleted'",
                        'Backup.error_message' => 'NULL'
                    ),
                    array(
                        'Backup.filename' => $result['deleted'],
                        'Backup.backup_category' => 'media_full'
                    )
                );
            }

            $this->out(sprintf(
                'Deleted %d media full backup(s). Skipped %d referenced full backup(s).',
                count($result['deleted']),
                count($result['skipped'])
            ));
        } catch (Exception $e) {
            $this->err('Prune media full failed: ' . $e->getMessage());
            CakeLog::write('error', 'Prune media full failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }

    public function prune_media_incremental()
    {
        $days = !empty($this->args[0]) ? (int)$this->args[0] : 14;
        if ($days < 1) {
            $days = 14;
        }

        try {
            $deletedFilenames = $this->_getMediaBackupService()->pruneIncrementalBackups($days);

            if (!empty($deletedFilenames)) {
                $this->Backup->updateAll(
                    array(
                        'Backup.status' => "'deleted'",
                        'Backup.error_message' => 'NULL'
                    ),
                    array(
                        'Backup.filename' => $deletedFilenames,
                        'Backup.backup_category' => 'media_incremental'
                    )
                );
            }

            $this->out(sprintf('Deleted %d media incremental backup(s).', count($deletedFilenames)));
        } catch (Exception $e) {
            $this->err('Prune media incremental failed: ' . $e->getMessage());
            CakeLog::write('error', 'Prune media incremental failed: ' . $e->getMessage());
            return $this->_stop(1);
        }
    }
}