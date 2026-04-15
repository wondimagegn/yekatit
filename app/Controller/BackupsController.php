<?php
// app/Controller/BackupsController.php
App::uses('AppController', 'Controller');
App::uses('BackupService', 'Lib');

class BackupsController extends AppController
{


    var $name = "Backups";
    public $uses = array('Backup');

    var $menuOptions = array(
        'weight' => 500,
        'exclude' => array('create', 'download', 'restore', 'delete', 'prune'),
        'alias' => array(
            'index' => 'Take/View/Prune Backups',
        )
    );


    protected $_backupService = null;

    public function beforeFilter()
    {
        parent::beforeFilter();
        // Adjust as needed:
         $this->Auth->allow('index', 'create', 'download', 'restore', 'delete', 'prune');
    }

    protected function _getBackupService()
    {
        if ($this->_backupService === null) {
            $this->_backupService = new BackupService();
        }

        return $this->_backupService;
    }


    public function index()
    {
        $service = $this->_getBackupService();
        $filesystemBackups = $service->listBackups();
        $backupPath = $service->getBackupPath();
        $mediaPath = $service->getMediaPath();

        $dbBackups = $this->Backup->find('all', array(
            'fields' => array(
                'Backup.id',
                'Backup.name',
                'Backup.filename',
                'Backup.path',
                'Backup.type',
                'Backup.status',
                'Backup.size',
                'Backup.manifest_json',
                'Backup.notes',
                'Backup.error_message',
                'Backup.created_by',
                'Backup.restored_by',
                'Backup.created_at',
                'Backup.restored_at',
                'Backup.modified',

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
            'recursive' => 0,
            'order' => array(
                'Backup.created_at' => 'DESC',
                'Backup.id' => 'DESC'
            )
        ));

        $dbByFilename = array();
        foreach ($dbBackups as $row) {
            if (!empty($row['Backup']['filename']) && empty($dbByFilename[$row['Backup']['filename']])) {
                $dbByFilename[$row['Backup']['filename']] = $row;
            }
        }

        $backups = array();
        foreach ($filesystemBackups as $fileBackup) {
            $record = !empty($dbByFilename[$fileBackup['name']]) ? $dbByFilename[$fileBackup['name']] : null;

            $backups[] = array(
                'file' => $fileBackup,
                'record' => $record,
            );
        }

        $this->set(compact('backups', 'backupPath', 'mediaPath'));
    }
    public function create()
    {
        $this->request->onlyAllow('post');
        $userId=$this->Auth->user('id');
        try {
            $result = $this->_getBackupService()->createBackup($userId);

            $manifestJson = null;
            $zipPath = $result['path'];
            if (class_exists('ZipArchive') && is_file($zipPath)) {
                $zip = new ZipArchive();
                if ($zip->open($zipPath) === true) {
                    $manifestContent = $zip->getFromName('manifest.json');
                    if ($manifestContent !== false) {
                        $manifestJson = $manifestContent;
                    }
                    $zip->close();
                }
            }

            $this->Backup->create();
            $this->Backup->save(array(
                'Backup' => array(
                    'name' => $result['name'],
                    'filename' => $result['name'],
                    'path' => $result['path'],
                    'type' => 'full',
                    'status' => 'created',
                    'size' => is_file($result['path']) ? filesize($result['path']) : 0,
                    'manifest_json' => $manifestJson,
                    'created_by' => $userId,
                    'created_at' => date('Y-m-d H:i:s'),
                )
            ), false);

            $this->Session->setFlash(
                __('Backup created successfully: %s', $result['name']),
                'default',
                array(),
                'success'
            );
        } catch (Exception $e) {
            $this->log($e->getMessage(), LOG_ERR);
            $this->Session->setFlash(
                __('Backup failed: %s', $e->getMessage()),
                'default',
                array(),
                'error'
            );
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function download($filename = null)
    {
        $service = $this->_getBackupService();
        $service->assertValidBackupFilename($filename);

        $fullPath = $service->getBackupPath() . $filename;
        if (!is_file($fullPath)) {
            throw new NotFoundException(__('Backup file not found.'));
        }

        return $this->response->file($fullPath, array(
            'download' => true,
            'name' => $filename,
        ));
    }

    public function restore($filename = null)
    {
        $this->request->onlyAllow('post');

        $userId = isset($this->Auth) && method_exists($this->Auth, 'user') ? $this->Auth->user('id') : null;

        $backupRecord = $this->Backup->find('first', array(
            'conditions' => array('Backup.filename' => $filename),
            'recursive' => -1,
            'order' => array('Backup.id' => 'DESC')
        ));

        try {
            $result = $this->_getBackupService()->restoreBackup($filename);

            if (!empty($backupRecord)) {
                $this->Backup->save(array(
                    'Backup' => array(
                        'id' => $backupRecord['Backup']['id'],
                        'status' => 'restored',
                        'restored_by' => $userId,
                        'restored_at' => date('Y-m-d H:i:s'),
                        'error_message' => null,
                    )
                ), false);
            }

            $this->Session->setFlash(
                __('Restore completed successfully. Previous media moved to: %s', $result['previous_media_path']),
                'default',
                array(),
                'success'
            );
        } catch (Exception $e) {
            if (!empty($backupRecord)) {
                $this->Backup->save(array(
                    'Backup' => array(
                        'id' => $backupRecord['Backup']['id'],
                        'status' => 'failed',
                        'error_message' => $e->getMessage(),
                    )
                ), false);
            }

            $this->log($e->getMessage(), LOG_ERR);
            $this->Session->setFlash(
                __('Restore failed: %s', $e->getMessage()),
                'default',
                array(),
                'error'
            );
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function delete($filename = null)
    {
        $this->request->onlyAllow('post');

        $backupRecord = $this->Backup->find('first', array(
            'conditions' => array('Backup.filename' => $filename),
            'recursive' => -1,
            'order' => array('Backup.id' => 'DESC')
        ));

        try {
            $this->_getBackupService()->deleteBackup($filename);

            if (!empty($backupRecord)) {
                $this->Backup->save(array(
                    'Backup' => array(
                        'id' => $backupRecord['Backup']['id'],
                        'status' => 'deleted',
                        'error_message' => null,
                    )
                ), false);
            }

            $this->Session->setFlash(__('Backup deleted successfully.'), 'default', array(), 'success');
        } catch (Exception $e) {
            if (!empty($backupRecord)) {
                $this->Backup->save(array(
                    'Backup' => array(
                        'id' => $backupRecord['Backup']['id'],
                        'status' => 'failed',
                        'error_message' => $e->getMessage(),
                    )
                ), false);
            }

            $this->log($e->getMessage(), LOG_ERR);
            $this->Session->setFlash(
                __('Delete failed: %s', $e->getMessage()),
                'default',
                array(),
                'error'
            );
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function prune($days = null)
    {
        $this->request->onlyAllow('post');

        $days = $days !== null ? (int)$days : (int)$this->request->data('Backup.prune_days');
        if ($days < 1) {
            $days = 30;
        }

        try {
            $service = $this->_getBackupService();
            $existingBackups = $service->listBackups();
            $cutoff = strtotime('-' . $days . ' days');

            $deletedFilenames = array();
            foreach ($existingBackups as $backup) {
                if ($backup['modified_ts'] < $cutoff) {
                    $deletedFilenames[] = $backup['name'];
                }
            }

            $deleted = $service->pruneBackups($days);

            if (!empty($deletedFilenames)) {
                $this->Backup->updateAll(
                    array('Backup.status' => "'deleted'"),
                    array('Backup.filename' => $deletedFilenames)
                );
            }

            $this->Session->setFlash(
                __('Deleted %d old backup(s).', $deleted),
                'default',
                array(),
                'success'
            );
        } catch (Exception $e) {
            $this->log($e->getMessage(), LOG_ERR);
            $this->Session->setFlash(
                __('Prune failed: %s', $e->getMessage()),
                'default',
                array(),
                'error'
            );
        }

        return $this->redirect(array('action' => 'index'));
    }
}