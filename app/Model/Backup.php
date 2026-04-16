<?php

App::uses('AppModel', 'Model');

class Backup extends AppModel
{
    public $displayField = 'filename';

    public $validate = array(
        'filename' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Filename is required.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Filename must be 255 characters or less.'
            )
        ),
        'path' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Path is required.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 1024),
                'message' => 'Path must be 1024 characters or less.'
            )
        ),
        'backup_category' => array(
            'valid' => array(
                'rule' => array('inList', array('database', 'media_full', 'media_incremental')),
                'message' => 'Invalid backup category.'
            )
        ),
        'status' => array(
            'valid' => array(
                'rule' => array('inList', array('created', 'restored', 'failed', 'deleted')),
                'message' => 'Invalid status.'
            )
        ),
        'size' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Size must be numeric.'
            )
        ),
        'is_incremental' => array(
            'boolean' => array(
                'rule' => array('boolean'),
                'message' => 'Invalid incremental flag.'
            )
        )
    );

    public $belongsTo = array(
        'CreatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'created_by'
        ),
        'RestoredBy' => array(
            'className' => 'User',
            'foreignKey' => 'restored_by'
        ),
        'ParentBackup' => array(
            'className' => 'Backup',
            'foreignKey' => 'parent_backup_id'
        )
    );

    public $hasMany = array(
        'ChildBackup' => array(
            'className' => 'Backup',
            'foreignKey' => 'parent_backup_id',
            'dependent' => false
        )
    );

    public function beforeValidate($options = array())
    {
        if (!empty($this->data[$this->alias]['filename']) && empty($this->data[$this->alias]['name'])) {
            $this->data[$this->alias]['name'] = $this->data[$this->alias]['filename'];
        }

        if (isset($this->data[$this->alias]['size'])) {
            $this->data[$this->alias]['size'] = (int)$this->data[$this->alias]['size'];
        }

        if (!isset($this->data[$this->alias]['is_incremental'])) {
            $this->data[$this->alias]['is_incremental'] = 0;
        }

        return true;
    }

    public function createBackupRecord($data)
    {
        $this->create();

        $defaults = array(
            'status' => 'created',
            'size' => 0,
            'is_incremental' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        );

        return $this->save(array($this->alias => array_merge($defaults, $data)), false);
    }

    public function markRestored($id, $userId = null)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'restored',
            'restored_by' => $userId,
            'restored_at' => date('Y-m-d H:i:s'),
            'error_message' => null,
        ), false);
    }

    public function markDeleted($id)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'deleted',
            'error_message' => null,
        ), false);
    }

    public function markFailed($id, $message)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'failed',
            'error_message' => $message,
        ), false);
    }

    function getLatestBackups($limit = 3) {
        $backups = $this->find('all',
            array(
                'order' =>
                    array(
                        'Backup.created DESC'
                    ),
                'limit' => $limit
            )
        );
        foreach($backups as &$backup) {
            if(file_exists($backup['Backup']['path']))
                $backup['Backup']['file_exists'] = true;
            else
                $backup['Backup']['file_exists'] = false;
        }
        return $backups;
    }

}