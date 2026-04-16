<?php
App::uses('AppController', 'Controller');
App::uses('DatabaseBackupService', 'Lib');
App::uses('MediaBackupService', 'Lib');

class BackupsController extends AppController
{
    public $uses = array('Backup');
    public $menuOptions = array(
        'exclude' => array(
            'create_database_backup', 'create_media_full_backup', 'create_media_incremental_backup',
            'download_database', 'download_media_full', 'download_media_incremental', 'restore_database', 'restore_media_full',
            'restore_media_incremental_chain', 'delete_database', 'delete_media_full', 'delete_media_incremental'
        ),
        'alias' => array(
            'index' => 'View and Take Backups',
        )
    );


    protected $_databaseBackupService = null;
    protected $_mediaBackupService = null;

    public function beforeFilter()
    {
        parent::beforeFilter();

        /*
        $this->Auth->allow('index', 'create_database_backup', 'create_media_full_backup', 'create_media_incremental_backup',
            'download_database', 'download_media_full', 'download_media_incremental', 'restore_database', 'restore_media_full',
            'restore_media_incremental_chain', 'delete_database', 'delete_media_full', 'delete_media_incremental');
        */

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

    protected function _getCurrentUserId()
    {
        return $this->Auth->user('id');
    }

    public function index()
    {
        $databaseFiles = $this->_getDatabaseBackupService()->listBackups();
        $mediaFullFiles = $this->_getMediaBackupService()->listFullBackups();
        $mediaIncrementalFiles = $this->_getMediaBackupService()->listIncrementalBackups();

        $dbRows = $this->Backup->find('all', array(
            'fields' => array(
                'Backup.id',
                'Backup.name',
                'Backup.filename',
                'Backup.path',
                'Backup.backup_category',
                'Backup.status',
                'Backup.size',
                'Backup.manifest_json',
                'Backup.manifest_path',
                'Backup.base_filename',
                'Backup.is_incremental',
                'Backup.error_message',
                'Backup.created_by',
                'Backup.restored_by',
                'Backup.created_at',
                'Backup.restored_at',
                'CreatedBy.id',
                'CreatedBy.username',
                'CreatedBy.first_name',
                'CreatedBy.middle_name',
                'CreatedBy.last_name',
                'RestoredBy.id',
                'RestoredBy.username',
                'RestoredBy.first_name',
                'RestoredBy.middle_name',
                'RestoredBy.last_name',
            ),
            'order' => array('Backup.created_at' => 'DESC', 'Backup.id' => 'DESC'),
            'recursive' => 0,
        ));

        $recordsByFilename = array();
        foreach ($dbRows as $row) {
            if (!empty($row['Backup']['filename']) && empty($recordsByFilename[$row['Backup']['filename']])) {
                $recordsByFilename[$row['Backup']['filename']] = $row;
            }
        }

        $databaseBackups = $this->_mergeFileBackupsWithRecords($databaseFiles, $recordsByFilename);
        $mediaFullBackups = $this->_mergeFileBackupsWithRecords($mediaFullFiles, $recordsByFilename);
        $mediaIncrementalBackups = $this->_mergeFileBackupsWithRecords($mediaIncrementalFiles, $recordsByFilename);

        $databasePath = $this->_getDatabaseBackupService()->getBackupPath();
        $mediaPath = $this->_getMediaBackupService()->getMediaPath();
        $mediaFullPath = $this->_getMediaBackupService()->getFullBackupPath();
        $mediaIncrementalPath = $this->_getMediaBackupService()->getIncrementalBackupPath();

        $this->set(compact(
            'databaseBackups',
            'mediaFullBackups',
            'mediaIncrementalBackups',
            'databasePath',
            'mediaPath',
            'mediaFullPath',
            'mediaIncrementalPath'
        ));
    }

    public function create_database_backup()
    {
        $this->request->onlyAllow('post');

        $userId = $this->_getCurrentUserId();

        try {
            $result = $this->_getDatabaseBackupService()->createBackup();

            $this->Backup->createBackupRecord(array(
                'name' => $result['filename'],
                'filename' => $result['filename'],
                'path' => $result['path'],
                'backup_category' => 'database',
                'size' => $result['size'],
                'created_by' => $userId,
            ));

            $this->Flash->success(__('Database backup created: %s', $result['filename']));


        } catch (Exception $e) {
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Database backup failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function create_media_full_backup()
    {
        $this->request->onlyAllow('post');

        $userId = $this->_getCurrentUserId();

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
                'created_by' => $userId,
            ));

            $this->Flash->success(__('Media full backup created: %s', $result['filename']));


        } catch (Exception $e) {
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Media full backup failed: %s', $e->getMessage()));

        }

        return $this->redirect(array('action' => 'index'));
    }

    public function create_media_incremental_backup()
    {
        $this->request->onlyAllow('post');

        $userId = $this->_getCurrentUserId();

        try {
            $result = $this->_getMediaBackupService()->createIncrementalBackup();

            $parentRecord = $this->Backup->find('first', array(
                'conditions' => array('Backup.filename' => $result['base_filename']),
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
                'created_by' => $userId,
            ));


            $this->Flash->success(
                __('Media incremental backup created: %s (%d changed, %d deleted)', $result['filename'],
                    $result['changed_count'], $result['deleted_count']));

        } catch (Exception $e) {
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Media incremental backup failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function download_database($filename = null)
    {
        $this->autoRender = false;

        $this->_getDatabaseBackupService()->assertValidFilename($filename);
        $fullPath = $this->_getDatabaseBackupService()->getBackupPath() . $filename;

        if (!is_file($fullPath)) {
            throw new NotFoundException(__('Database backup not found.'));
        }

        return $this->response->file($fullPath, array(
            'download' => true,
            'name' => $filename
        ));

    }

    public function download_media_full($filename = null)
    {

        $this->autoRender = false;

        $fullPath = $this->_getMediaBackupService()->getFullBackupPath() . $filename;

        if (!is_file($fullPath)) {
            throw new NotFoundException(__('Media full backup not found.'));
        }

        return $this->response->file($fullPath, array(
            'download' => true,
            'name' => $filename
        ));

    }

    public function download_media_incremental($filename = null)
    {

        $this->autoRender = false;

        $fullPath = $this->_getMediaBackupService()->getIncrementalBackupPath() . $filename;

        if (!is_file($fullPath)) {
            throw new NotFoundException(__('Media incremental backup not found.'));
        }

        return $this->response->file($fullPath, array(
            'download' => true,
            'name' => $filename
        ));
    }

    public function restore_database($filename = null)
    {
        $this->request->onlyAllow('post');

        $userId = $this->_getCurrentUserId();
        $record = $this->_findBackupRecordByFilename($filename);

        try {
            $this->_getDatabaseBackupService()->restoreBackup($filename);

            if (!empty($record['Backup']['id'])) {
                $this->Backup->markRestored($record['Backup']['id'], $userId);
            }

            $this->Flash->success(__('Database restored successfully.'));

        } catch (Exception $e) {
            if (!empty($record['Backup']['id'])) {
                $this->Backup->markFailed($record['Backup']['id'], $e->getMessage());
            }
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Database restore failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function restore_media_full($filename = null)
    {
        $this->request->onlyAllow('post');

        $userId = $this->_getCurrentUserId();
        $record = $this->_findBackupRecordByFilename($filename);

        try {
            $result = $this->_getMediaBackupService()->restoreFullBackup($filename);

            if (!empty($record['Backup']['id'])) {
                $this->Backup->markRestored($record['Backup']['id'], $userId);
            }

            $this->Flash->success( __('Media full restore completed. Previous media moved to: %s', $result['previous_media_path']));

        } catch (Exception $e) {
            if (!empty($record['Backup']['id'])) {
                $this->Backup->markFailed($record['Backup']['id'], $e->getMessage());
            }
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Media full restore failed: %s', $e->getMessage()));

        }

        return $this->redirect(array('action' => 'index'));
    }

    public function restore_media_incremental_chain($filename = null)
    {
        $this->request->onlyAllow('post');

        $userId = $this->_getCurrentUserId();
        $record = $this->_findBackupRecordByFilename($filename);

        try {
            $result = $this->_getMediaBackupService()->restoreIncrementalChain($filename);

            if (!empty($record['Backup']['id'])) {
                $this->Backup->markRestored($record['Backup']['id'], $userId);
            }

            $this->Flash->success(__('Media incremental chain restored. Base full: %s. Previous media moved to: %s', $result['base_full'],
                $result['previous_media_path']));


        } catch (Exception $e) {
            if (!empty($record['Backup']['id'])) {
                $this->Backup->markFailed($record['Backup']['id'], $e->getMessage());
            }
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Media incremental chain restore failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function delete_database($filename = null)
    {
        $this->request->onlyAllow('post');

        $record = $this->_findBackupRecordByFilename($filename);

        try {
            $this->_getDatabaseBackupService()->deleteBackup($filename);

            if (!empty($record['Backup']['id'])) {
                $this->Backup->markDeleted($record['Backup']['id']);
            }
            $this->Flash->success(__('Database backup deleted.'));

        } catch (Exception $e) {
            if (!empty($record['Backup']['id'])) {
                $this->Backup->markFailed($record['Backup']['id'], $e->getMessage());
            }
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Delete failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function delete_media_full($filename = null)
    {
        $this->request->onlyAllow('post');

        $record = $this->_findBackupRecordByFilename($filename);

        try {
            $this->_getMediaBackupService()->deleteFullBackup($filename);

            if (!empty($record['Backup']['id'])) {
                $this->Backup->markDeleted($record['Backup']['id']);
            }
            $this->Flash->success(__('Media full backup deleted.'));

        } catch (Exception $e) {
            if (!empty($record['Backup']['id'])) {
                $this->Backup->markFailed($record['Backup']['id'], $e->getMessage());
            }
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->success(__('Delete failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function delete_media_incremental($filename = null)
    {
        $this->request->onlyAllow('post');

        $record = $this->_findBackupRecordByFilename($filename);

        try {
            $this->_getMediaBackupService()->deleteIncrementalBackup($filename);

            if (!empty($record['Backup']['id'])) {
                $this->Backup->markDeleted($record['Backup']['id']);
            }

            $this->Flash->success(__('Media incremental backup deleted.'));
        } catch (Exception $e) {
            if (!empty($record['Backup']['id'])) {
                $this->Backup->markFailed($record['Backup']['id'], $e->getMessage());
            }
            $this->log($e->getMessage(), LOG_ERR);
            $this->Flash->error(__('Delete failed: %s', $e->getMessage()));
        }

        return $this->redirect(array('action' => 'index'));
    }

    protected function _findBackupRecordByFilename($filename)
    {
        return $this->Backup->find('first', array(
            'conditions' => array('Backup.filename' => $filename),
            'recursive' => -1,
            'order' => array('Backup.id' => 'DESC')
        ));
    }

    protected function _mergeFileBackupsWithRecords($files, $recordsByFilename)
    {
        $result = array();

        foreach ($files as $file) {
            $result[] = array(
                'file' => $file,
                'record' => !empty($recordsByFilename[$file['name']]) ? $recordsByFilename[$file['name']] : null,
            );
        }

        return $result;
    }
}