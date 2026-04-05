<?php
App::uses('AppModel', 'Model');
/**
 * FeeType Model
 *
 * @property Currency $Currency
 * @property Category $Category
 */
class FeeType extends AppModel {

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

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
		

            'notBlank' => array('rule' => 'notBlank', 'message' => 'Name is required'),
            'unique' => array('rule' => 'isUnique', 'message' => 'Name must be unique')
		),
		'amount' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'currency_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'recurrence' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		
		'applicable_to' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PaymentCurrency' => array(
			'className' => 'PaymentCurrency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FeeCategory' => array(
			'className' => 'FeeCategory',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    /**
     * Find fee types based on filters and return as ID => 1 array
     *
     * @param array $conditions Optional additional conditions
     * @return array Format: [fee_type_id => 1, fee_type_id => 1, ...]
     */
    public function findActiveApplicableFeeTypes($namePatterns = array(), $recurrence = null, $applicableTo = null, $extraConditions = array()) {
        $conditions = array(
            'FeeType.active' => 1
        );

        // Name filter (LIKE matching any of the patterns)
        if (!empty($namePatterns)) {
            $nameConditions = array();
            foreach ((array)$namePatterns as $pattern) {
                $nameConditions[] = array('LOWER(FeeType.name)' => strtolower($pattern));
            }
            $conditions['OR'] = $nameConditions;
        }

        // Recurrence filter (exact match or array)
        if ($recurrence !== null) {
            $conditions['FeeType.recurrence'] = $recurrence;
        }

        // Applicable_to filter
        if ($applicableTo !== null) {
            // If applicable_to is stored as JSON or comma-separated, adjust accordingly
            // Simple exact match example:
            $conditions['FeeType.applicable_to'] = $applicableTo;

            // Alternative: if applicable_to is JSON array of IDs or categories
            // $conditions[] = array('JSON_CONTAINS(FeeType.applicable_to', json_encode($applicableTo)) // MySQL 5.7+
            // or custom LIKE logic for string/CSV
        }

        // Merge any extra conditions
        if (!empty($extraConditions)) {
            $conditions = array_merge($conditions, $extraConditions);
        }

        // Find matching fee types
        $feeTypes = $this->find('all', array(
            'conditions' => $conditions,
            'fields'     => array('id'), // only need ID
            'recursive'  => -1
        ));

        // Transform to [id => 1] format
        $result = array();
        foreach ($feeTypes as $row) {
            $id = $row['FeeType']['id'];
            $result[$id] = $id;
        }

        debug($result);

        return $result;
    }

    // Example usage aliases for common cases
    public function findActiveRegistrationFees($namePatterns = array('registration', 'enrollment')) {
        return $this->findActiveApplicableFeeTypes(
            $namePatterns,
            array('semesterly', 'yearly', 'one-time'),
            'all_students'
        );
    }

    public function findActiveAdmissionFees() {
        return $this->findActiveApplicableFeeTypes(
            array('admission'),
            'one-time',
            'all_applicants'
        );
    }

}
