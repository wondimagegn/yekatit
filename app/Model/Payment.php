<?php
class Payment extends AppModel {
	var $name = 'Payment';
	var $validate = array(
		
		'semester' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Select semester ',
				'allowEmpty' => false,
				'required' => false,
				
			),
		),
		'academic_year' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Select academic year ',
				'allowEmpty' => false,
				'required' => false,
				
			),
		),
		'reference_number' => array(
			'rule' => array('checkReferenceValue', 'reference_number'),
	                'message' => 'Provide reference number of payment ',
	                'on' => 'create',
             	     
		),
		'fee_amount' => array(
			'rule' => array('checkFeeValue', 'fee_amount'),
	                'message' => 'Provide fee amount',
	                'on' => 'create',
             	     
		),
		 /*
		'reference_number' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
				'message' => 'Provide reference number of payment',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		*/
		/*
		'fee_amount'=>array(
		    'numeric' => array(
				    'rule' => array('numeric'),
				    'message' => 'Fee amount should be numeric',
				    'allowEmpty' => false,
				    'required' => false,
				    'last' => true, // Stop validation after this rule
				    //'on' => 'create', // Limit validation to 'create' or 'update' operations
			  ),
			 'comparison' => array(
			        'rule' => array('comparison','>=',0),
			        'message' => 'Fee amount should be greather than or equal to zero.',
		       )
		  )
		  	*/
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasMany = array(
	  'Attachment' => array( 
            'className' => 'Media.Attachment', 
            'foreignKey' => 'foreign_key', 
            'conditions'    => array('model' => 'Payment'),
            'dependent' => true, 
        ),
	);
	//checkReferenceValue

	 function checkReferenceValue($data, $fieldName) {
            $valid = false;
            debug($data);
            debug($this->data);
            if(isset($fieldName) && $this->hasField($fieldName)) {
                if(isset($data) && !empty($data) && $this->data['Payment']['sponsor_type']=="Self"){
                	if(isset($data['reference_number']) && !empty($data['reference_number'])){
                		$valid=true;
                	}
                } else if(isset($data) && !empty($data) && $this->data['Payment']['sponsor_type']=="Government"){
                	$valid=true;
                }
               
            }
            return $valid;
        }
        
         function checkFeeValue($data, $fieldName) {
         	debug($data);
            $valid = false;
            if(isset($fieldName) && $this->hasField($fieldName)) {
                if(isset($data) && !empty($data) && $this->data['Payment']['sponsor_type']=="Self"){
                	
                	if(isset($data['fee_amount']) && !empty($data['fee_amount']) && is_numeric($data['fee_amount'])){
                		$valid=true;
                	}
                } else if(isset($data) && !empty($data) && $this->data['Payment']['sponsor_type']=="Government"){
                	$valid=true;
                }
               
            }
            return $valid;
        }
    
	
	 function duplication ($data=null) {
            if (empty($data['Payment']['semester']) || empty($data['Payment']['academic_year']) 
            || empty($data['Payment']['reference_number']) || empty($data['Payment']['fee_amount']) ) {
                    return 0;
            }
            //fee_amount
            
            $count=$this->find('count',array('conditions'=>
              array('Payment.student_id'=>$data['Payment']['student_id'],
              'Payment.semester'=>$data['Payment']['semester'],
              'Payment.academic_year'=>$data['Payment']['academic_year'])));
           
            return $count;
     }
     public function paidPayment($student_id,$latestAcSemester){
     	 $allow=ClassRegistry::init('GeneralSetting')->allowRegistrationWithoutPayment($student_id);
     	 if($allow==1){
     	 	 return 1;
     	 } else {
     	 	 $pcount=$this->find('count',array('conditions'=>
              array('Payment.student_id'=>$student_id,
              'Payment.semester'=>$latestAcSemester['semester'],
	       'Payment.approval_status'=>1,
              'Payment.academic_year'=>$latestAcSemester['academic_year'])));
     	 	 if($pcount>0){
     	 	 	return 1;
     	 	 }
     	 	
     	 }
     	 return 0;
     }

    function preparedAttachment($data = null)
    {

		foreach ($data['Attachment'] as $in =>  &$dv) {

			if (
				empty($dv['file']['name']) && empty($dv['file']['type'])
				&& empty($dv['tmp_name'])
			) {
				unset($data['Attachment'][$in]);
			}  else if ($in == 0) {
				$dv['model'] = 'Payment';
				$dv['group'] = 'PaymentSlips';
			}
		}
		return $data;
   }
	
}
