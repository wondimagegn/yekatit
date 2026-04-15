<?php
// app/Model/Backup.php

App::uses('AppModel', 'Model');

class Backup extends AppModel
{
    public $displayField = 'name';

    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Backup name is required.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'Backup name must be 255 characters or less.'
            )
        ),
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
                'message' => 'Backup path is required.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 1024),
                'message' => 'Path must be 1024 characters or less.'
            )
        ),
        'type' => array(
            'valid' => array(
                'rule' => array('inList', array('full')),
                'message' => 'Invalid backup type.'
            )
        ),
        'status' => array(
            'valid' => array(
                'rule' => array('inList', array('created', 'restored', 'failed', 'deleted')),
                'message' => 'Invalid backup status.'
            )
        ),
        'size' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Size must be numeric.'
            )
        )
    );

    public $belongsTo = array(
        'CreatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'created_by',
        ),
        'RestoredBy' => array(
            'className' => 'User',
            'foreignKey' => 'restored_by',
        ),
    );

    public function beforeValidate($options = array())
    {
        if (!empty($this->data[$this->alias]['filename']) && empty($this->data[$this->alias]['name'])) {
            $this->data[$this->alias]['name'] = $this->data[$this->alias]['filename'];
        }

        if (isset($this->data[$this->alias]['size'])) {
            $this->data[$this->alias]['size'] = (int)$this->data[$this->alias]['size'];
        }

        return true;
    }

    public function markCreated($id, $userId = null)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'created',
            'created_by' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
        ), false);
    }

    public function markRestored($id, $userId = null)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'restored',
            'restored_by' => $userId,
            'restored_at' => date('Y-m-d H:i:s'),
        ), false);
    }

    public function markDeleted($id)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'deleted',
        ), false);
    }

    public function markFailed($id, $message = null)
    {
        return $this->save(array(
            'id' => $id,
            'status' => 'failed',
            'error_message' => $message,
        ), false);
    }

    public function createRecord($data)
    {
        $this->create();

        $defaults = array(
            'type' => 'full',
            'status' => 'created',
            'created_at' => date('Y-m-d H:i:s'),
        );

        $data = array_merge($defaults, $data);

        return $this->save(array($this->alias => $data));
    }
}