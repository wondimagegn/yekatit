<?php
class Grade extends AppModel {
	var $name = 'Grade';
	var $validate = array(
		'grade' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can\'t be left blank',
				'allowEmpty' => false,
				'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			/*'checkUnique' => array (
                                    'rule' => array('checkUnique'),
                                    'message' => 'Duplicate grade.'
                            )
		    */
		),
		
		'point_value' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Numeric value required.',
				'allowEmpty' => false,
				'required' => true,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'comparison' => array(
				    'rule' => array('comparison','>=',0),
				    'message' => 'Point value must be greater than or equal zero.',
				    'allowEmpty' => false,
				    'required' => false,
				    'last' => true, // Stop validation after this rule
				    //'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			/*'unique' => array (
                  'rule' => array('checkUnique', 'point_value'),
                  'message' => 'Duplicate point value.'
             )
             */
		),
		
	);
	
	   /**
	 * Method to check given type is unique 
	 * 
	 * @param $data, $fieldName
	 * @return boolean
	 */
   function checkUnique($data, $fieldName) {
          //  return true;
            $data_grade_type=$this->GradeType->grade_type_data();
            debug($this->data);
            //debug($data_grade_type);
            //debug($data);
            //return true;
           /* $valid = false;
            if(isset($fieldName) && $this->hasField($fieldName)) {
              
                $valid = $this->isUnique(array($fieldName => $data));
                return $valid;
                 if (!isset($data['id'])) {
                    $check=$this->find('count',array('conditions'=>array(
                    'Grade.grade'=>$this->data['Grade']['grade'],
                    'Grade.point_value'=>$this->data['Grade']['point_value'],
                    'GradeType.type'=>$data['type'])));
                    } else {
                        $check=$this->find('count',array('conditions'=>array(
                    'Grade.grade'=>$this->data['Grade']['grade'],
                    'Grade.point_value'=>$this->data['Grade']['point_value'],
                    'Grade.grade_type_id'=>$data['grade_type_id'])));
                    
                    }
                    if ($check>0) {
                        return false;
                    } else {
                        return true;
                    }
                 
                $valid = $this->isUnique(array($fieldName => $data));
                return $valid;
                if(!$valid){
                    if (!isset($data['id'])) {
                    $check=$this->find('count',array('conditions'=>array(
                    'Grade.grade'=>$this->data['Grade']['grade'],
                    'Grade.point_value'=>$this->data['Grade']['point_value'],
                    'GradeType.type'=>$data['type'])));
                    } else {
                        $check=$this->find('count',array('conditions'=>array(
                    'Grade.grade'=>$this->data['Grade']['grade'],
                    'Grade.point_value'=>$this->data['Grade']['point_value'],
                    'Grade.grade_type_id'=>$data['grade_type_id'])));
                    
                    }
                  
                    if ($check==0) {
                    
                        return true;
                    }
                }
               
            }
            */
           // return $valid;
    }
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'GradeType' => array(
			'className' => 'GradeType',
			'foreignKey' => 'grade_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'GradeScaleDetail' => array(
			'className' => 'GradeScaleDetail',
			'foreignKey' => 'grade_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
   	function allowDelete($grade_id = null) {
		if($this->GradeScaleDetail->find('count', array('conditions' => array('GradeScaleDetail.grade_id' =>$grade_id))) > 0)
			return false;
		else
			return true;
	  }
	   
	/**
	*
	*/
    function checkGradeIsUnique ($data=null) {
         if (!empty($data)) {
          
            $already_defined=null;
           
            $frequencey_count=array();
            /*
            *Count the frequency of grade repeation and display invalidation message
            *if grade is duplicated
            */
            
            if(!empty($data['Grade'])) {
                    foreach($data['Grade'] as $grade_id=>$grade_value){
                              $frequencey_count[]=$grade_value['grade'];
                    }
                    debug($frequencey_count);
                    $how_many_times=array_count_values($frequencey_count);
                      
                   if (count($how_many_times)>0) {
                       foreach($how_many_times as $grade_id=>$frequency){
                            if ($frequency>1) {
                                    $this->invalidate('checkGradeIsUnique', 
                                    'Grade '.$grade_id.' 
                                    is duplicated '.$frequency.' times.Please change the grade.');
                                            return false;
                            }   
                      }
                     // return true;
                    
                    } 
                    //check point value duplication 
                    /*
                       $frequencey_count_point=array();
                         foreach($data['Grade'] as $grade_id=>$grade_value){
                              $frequencey_count_point[]=$grade_value['point_value'];
                         }
                         $how_many_times=array_count_values($frequencey_count_point);
                        
                         if (count($how_many_times)>0) {
                                foreach($how_many_times as $grade_id=>$frequency){
                                    if ($frequency>1) {
                                            $this->invalidate('checkGradeIsUnique', 
                                            'Point value  '.$grade_id.' 
                                            is duplicated '.$frequency.' times.Please change the point value .');
                                                    return false;
                                    }   
                                }
                                return true;
                         }
                      */
                 
                return true;
            }
            
         }
         return false;
    }
}
