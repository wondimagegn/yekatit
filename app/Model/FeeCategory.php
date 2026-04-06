<?php
App::uses('AppModel', 'Model');
/**
 * FeeCategory Model
 *
 */
class FeeCategory extends AppModel {

    var $actsAs = array(
		'Containable',
		'Tools.Logable' => array(
			'change' => 'full',
			//'change' => 'list',
			'description_ids' => 'true',
			'displayField' => 'username',
			'foreignKey' => 'foreign_key',
			//'skip' => array('search', 'view'), // functions to skip logging
			'ignore' => array('created', 'modified') // fields to ignore in log
		)
	);

    public $hasMany = array(
        'FeeType' => array(
            'className' => 'FeeType',
            'foreignKey' => 'category_id',
            'dependent' => true // Enable cascading deletes
        )
    );


    /**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
		
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'Name is required'),
            'unique' => array('rule' => 'isUnique', 'message' => 'Name must be unique')
		),
	);
}
