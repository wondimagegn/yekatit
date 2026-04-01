<?php
App::uses('AppModel', 'Model');
/**
 * ColleagueEvalutionRate Model
 *
 * @property InstructorEvalutionQuestion $InstructorEvalutionQuestion
 * @property Staff $Staff
 */
class ColleagueEvalutionRate extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'instructor_evalution_question_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'staff_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dept_head' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'academic_year' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rating' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InstructorEvalutionQuestion' => array(
			'className' => 'InstructorEvalutionQuestion',
			'foreignKey' => 'instructor_evalution_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Staff' => array(
			'className' => 'Staff',
			'foreignKey' => 'staff_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Evaluator' => array(
			'className' => 'Staff',
			'foreignKey' => 'evaluator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    public function getNotEvaluatedColleaguesListForHead($data,$evaluator_user_id){

    	$evaluatorStaff=$this->Staff->find('first',
			array('conditions'=>array(
				'Staff.user_id'=>$evaluator_user_id),
                'recursive'=>-1
				));
		if(empty($evaluator_user_id)){
			return array();
		}

		$staffs = $this->Staff->find('all',
			array(
				'conditions' =>
				array(
					'Staff.first_name like' => $data['Search']['name'].'%',
					'Staff.active' => 1,
					'Staff.department_id'=>$evaluatorStaff['Staff']['department_id'],
					'Staff.id in (select staff_id from course_instructor_assignments where academic_year="'.$data['Search']['acadamic_year'].'" and semester="'.$data['Search']['semester'].'")',
					'Staff.id not in (select staff_id from colleague_evalution_rates where staff_id="'.$evaluator_user_id.'" and academic_year="'.$data['Search']['acadamic_year'].'" and semester="'.$data['Search']['semester'].'"  )',

				),
				'contain'=>array('ColleagueEvalutionRate','Position','Title','Department')
			)
		);
		$staffList=array();
		foreach ($staffs as $key => $value) {
			# code...
			$staffList[$value['Staff']['id']]=$value['Title']['title'].' '.$value['Staff']['full_name'].' '.$value['Position']['position'];
		}
		return $staffList;

    }
	public function getNotEvaluatedColleagues($data,$evaluator_user_id){
		$evaluatorStaff=$this->Staff->find('first',
			array('conditions'=>array('Staff.user_id'=>$evaluator_user_id),
                'recursive'=>-1
				));
		if(empty($evaluator_user_id)){
			return array();
		}
		debug($data);
		

		$staffs = $this->Staff->find('all',
			array(
				'conditions' =>
				array(
					'Staff.first_name like' => $data['Search']['name'].'%',
					'Staff.active' => 1,
					'Staff.department_id'=>$evaluatorStaff['Staff']['department_id'],
					'Staff.id in (select staff_id from course_instructor_assignments where academic_year="'.$data['Search']['acadamic_year'].'" and semester="'.$data['Search']['semester'].'")',
					'Staff.id not in (select staff_id from colleague_evalution_rates where evaluator_id="'.$evaluatorStaff['Staff']['id'].'" and academic_year="'.$data['Search']['acadamic_year'].'" and semester="'.
					$data['Search']['semester'].'"
					 )',

				),
				'contain'=>array('Position','Title','Department')
			)
		);
		$staffList=array();
		foreach ($staffs as $key => $value) {
			# code...
			$staffList[$value['Staff']['id']]=$value['Title']['title'].' '.$value['Staff']['full_name'].' '.$value['Position']['position'];
		}
		return $staffList;
	}
    
	public function getEvaluatedColleaguesListForHeadReport($data,$evaluator_user_id){

    	$evaluatorStaff=$this->Staff->find('first',
			array('conditions'=>array(
				'Staff.user_id'=>$evaluator_user_id,
				'Staff.active' => 1,
				),
                'recursive'=>-1
				));

		if(empty($evaluator_user_id)){
			return array();
		}
		debug($evaluator_user_id);

		$staffs = $this->Staff->find('all',
			array(
				'conditions' =>
				array(
					'Staff.first_name like' => $data['Search']['name'].'%',
					'Staff.active' => 1,
					'Staff.department_id'=>$evaluatorStaff['Staff']['department_id'],
/*
					'Staff.id  in (select staff_id from colleague_evalution_rates where  academic_year="'.$data['Search']['acadamic_year'].'" and semester="'.
					$data['Search']['semester'].'"
					 )',
					 */
					 'Staff.id  in (select staff_id from course_instructor_assignments where  academic_year="'.$data['Search']['acadamic_year'].'" and semester="'.
					$data['Search']['semester'].'"
					 )',

					
				),
				'contain'=>array('CourseInstructorAssignment'=>array('conditions'=>array('CourseInstructorAssignment.academic_year'=>$data['Search']['acadamic_year'])),'Position','ColleagueEvalutionRate','Title','Department')
			)
		);
	
		$staffList=array();
		foreach ($staffs as $key => $value) {
			# code...
			$staffList[$value['Staff']['id']]=$value['Title']['title'].' '.$value['Staff']['full_name'].' '.$value['Position']['position'];
		}
		return $staffList;

    }
   
	/*
    public function getInstructorEvaluationResult($data){
    	
        $courseInstructorAssignments=$this->Staff->CourseInstructorAssignment->find('all',
        	array('conditions'=>array(
        		'CourseInstructorAssignment.staff_id'=>$data['Search']['staff_id'],
        		'CourseInstructorAssignment.academic_year'=>$data['Search']['acadamic_year'],
        		'CourseInstructorAssignment.semester'=>$data['Search']['semester'],
        		),
               'contain'=>array('PublishedCourse'=>array('Course','Section','YearLevel'))
        	));
      
        $totalObjectiveStudentQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveStudentQuestion($data['Search']['acadamic_year'],$data['Search']['semester']);
       $totalObjectiveColleagueQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveColleagueQuestion($data['Search']['acadamic_year'],$data['Search']['semester']);
       $totalObjectiveHeadQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveHeadQuestion($data['Search']['acadamic_year'],$data['Search']['semester']);
      
        $maxRate=5;
        
        $readEvaluationSettings=ClassRegistry::init('InstructorEvalutionSetting')->find('first',
        	array('order'=>array(
        		'InstructorEvalutionSetting.academic_year DESC '
        		)));
      
        $evalutionResult=array();
        //debug($courseInstructorAssignments);
        foreach ($courseInstructorAssignments as 
        	$key => $value) {
        	$totalEvaluterStudents=ClassRegistry::init('StudentEvalutionRate')->find('count',
        		array('conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
        			'StudentEvalutionRate.rating !=0'
        			),
                  'group'=>array('StudentEvalutionRate.student_id')
        		));
            debug($totalEvaluterStudents);
            debug($totalObjectiveStudentQuestion);
            if($totalEvaluterStudents){
               $maximumSumPossibleForInstructor=$totalEvaluterStudents*$totalObjectiveStudentQuestion*5;
             
              debug($maximumSumPossibleForInstructor);
              $allStudentEvaluation=ClassRegistry::init('StudentEvalutionRate')->find('all',
        		array(
        			'conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
'StudentEvalutionRate.rating !=0'
        				),
        			//'contain'=>array('InstructorEvalutionQuestion'),
        			'limit'=>$totalEvaluterStudents*$totalObjectiveStudentQuestion,
        			'recursive'=>-1
        			)
        		);
        		//debug($allStudentEvaluation);
               //remove duplicate evaluation result for same question of student evaluation if exists 
               foreach ($allStudentEvaluation as $rd => $rv) {
              
		              	$allDuplicatedList=ClassRegistry::init('StudentEvalutionRate')->find('list',
		        		array(
		        			'conditions'=>array(
		        				'StudentEvalutionRate.published_course_id'
		        				=>$value['CourseInstructorAssignment']['published_course_id'],
		'StudentEvalutionRate.student_id'=>$rv['StudentEvalutionRate']['student_id'],
		'StudentEvalutionRate.instructor_evalution_question_id'=>$rv['StudentEvalutionRate']['instructor_evalution_question_id']
		        				),
		        				'fields'=>array('StudentEvalutionRate.id','StudentEvalutionRate.id')
		        		
		        			)
		        		);
		        		
		              	 if(count($allDuplicatedList)>1){

		                            // perform deletion except one instance 

							$firstInstance=ClassRegistry::init('StudentEvalutionRate')->find('first',
							array(
							'conditions'=>array(
								'StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
							'StudentEvalutionRate.student_id'=>$rv['StudentEvalutionRate']['student_id'],
							'StudentEvalutionRate.instructor_evalution_question_id'=>$rv['StudentEvalutionRate']['instructor_evalution_question_id']
								),
								'recursive'=>-1
							)
							);
							unset($allDuplicatedList[$firstInstance['StudentEvalutionRate']['id']]);
							if(count($allDuplicatedList)){
							ClassRegistry::init('StudentEvalutionRate')->deleteAll(
							array('StudentEvalutionRate.id' => $allDuplicatedList), false, false);
							}
		              	 	     
		              	 }

                }
		          $sum=ClassRegistry::init('StudentEvalutionRate')->find('all',
        		array(
        			'conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
'StudentEvalutionRate.rating !=0'
        				),
        			'fields'=>array('sum(StudentEvalutionRate.rating)'),
        			

        			)
        		);
		
             
	             if(!empty($value['PublishedCourse']['Course']['course_title'])){
	             	       $evalutionResult['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['studentTotalRate']=$sum[0][0]['sum(`StudentEvalutionRate`.`rating`)'];
	               $evalutionResult['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['totalEvaluterStudents']=$totalEvaluterStudents;
	             
	                $evalutionResult['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['averageRate']=
	                $sum[0][0]['sum(`StudentEvalutionRate`.`rating`)']/$totalEvaluterStudents;
					
	                 $evalutionResult['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['rateconverted5percent']=(5*$sum[0][0]['sum(`StudentEvalutionRate`.`rating`)'])/($totalObjectiveStudentQuestion*5*$totalEvaluterStudents);
	             }
             
            	

            }
        }
        
        $colleagueEvalution=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$data['Search']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>0
        				),
        			//'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        			'group'=>array('ColleagueEvalutionRate.evaluator_id')
        			
        			)
        );
        $totalStaffEvalutedInstructor=ClassRegistry::init('ColleagueEvalutionRate')->find('count',
        		array('conditions'=>array(
        			'ColleagueEvalutionRate.staff_id'=>$data['Search']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>0
        			),
                  'group'=>array('ColleagueEvalutionRate.evaluator_id')
        		));

        foreach ($colleagueEvalution as $key => $value) {
        
	        	$colleagueEvalutionSum=$this->find('all',
	        		array(
	        			'conditions'=>array(
	        				'ColleagueEvalutionRate.staff_id'=>$value['ColleagueEvalutionRate']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$value['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$value['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$value['ColleagueEvalutionRate']['semester'],
	        				'ColleagueEvalutionRate.dept_head'=>0
	        				),
	        			'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
	        			
	        			)
	        	);
	        	
	        	 $evalutionResult['Colleague']['colleagueTotalRate']+=$colleagueEvalutionSum[0][0]['sum(`ColleagueEvalutionRate`.`rating`)'];
	          
        }
      
      $evalutionResult['Colleague']['averageRate']=($evalutionResult['Colleague']['colleagueTotalRate']/$totalStaffEvalutedInstructor);
       $evalutionResult['Colleague']['rateconverted5percent']=(5*$evalutionResult['Colleague']['colleagueTotalRate'])/($totalObjectiveColleagueQuestion*5*$totalStaffEvalutedInstructor);

      
        $headSum=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$data['Search']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>1
        				),
        			'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        		
        			)
        );
        
        $evalutionResult['EvaluatedStaffDetail']=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$data['Search']['staff_id']),
        	'contain'=>array('Position','Title','Department','College')
        ));
        $evalutionResult['EvaluatedStaffDetail']['academic_year']=$data['Search']['acadamic_year'];
        $evalutionResult['EvaluatedStaffDetail']['semester']=$data['Search']['semester'];
        $evalutionResult['Head'][0]['headTotalRate']=$headSum[0][0]['sum(`ColleagueEvalutionRate`.`rating`)'];
        $evalutionResult['Head'][0]['rateconverted5percent']=(5*$headSum[0][0]['sum(`ColleagueEvalutionRate`.`rating`)'])/($totalObjectiveHeadQuestion*5);
        $evalutionResult['InstructorEvalutionSetting']=$readEvaluationSettings['InstructorEvalutionSetting'];
      
       return $evalutionResult;
    }
    */
    
     public function getInstructorEvaluationResult($data,$department_id){
        debug($department_id);
    	$department_ids='';
        if(is_array($department_id)){
        	$department_ids=join(',', $department_id);
        } else {
        	$department_ids=$department_id;
        }
       
        $staff_ids=array();
        foreach($data['Staff'] as $kk=>$vv){
           if($vv['gp']==1)
           		$staff_ids[$vv['id']]=$vv['id'];
        }
        $courseInstructorAssignments=$this->Staff->CourseInstructorAssignment->find('all',
        	array('conditions'=>array(
        		'CourseInstructorAssignment.staff_id'=>$staff_ids,
        		'CourseInstructorAssignment.academic_year'=>$data['Search']['acadamic_year'],
        		//'CourseInstructorAssignment.staff_id'=>$staff_ids,
        		'CourseInstructorAssignment.semester'=>$data['Search']['semester'],
        		'CourseInstructorAssignment.staff_id in (select id from staffs where department_id in ("'.$department_ids.'") )'
        		),
               'contain'=>array('Staff'=>array('Position','Title','Department','College'),'PublishedCourse'=>array('Course','Section','YearLevel'))
        	));
   
       
        $maxRate=5;
        
        $readEvaluationSettings=ClassRegistry::init('InstructorEvalutionSetting')->find('first',array('order'=>array('InstructorEvalutionSetting.academic_year DESC ')));
      
        $evalutionResult=array();
        
        foreach ($courseInstructorAssignments as 
        	$key => $value) {
        	 $totalObjectiveStudentQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveStudentQuestion($data['Search']['acadamic_year'],$data['Search']['semester']);
        	$totalEvaluterStudents=ClassRegistry::init('StudentEvalutionRate')->find('count',
        		array('conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
        			'StudentEvalutionRate.rating !=0'
        			),
                  'group'=>array('StudentEvalutionRate.student_id')
        	));
        
           //student evaluation
            if($totalEvaluterStudents){
               $maximumSumPossibleForInstructor=$totalEvaluterStudents*$totalObjectiveStudentQuestion*5;
             
           debug($maximumSumPossibleForInstructor);
           debug($totalObjectiveStudentQuestion);
           debug($totalEvaluterStudents);
          
              $allStudentEvaluation=ClassRegistry::init('StudentEvalutionRate')->find('all',
        		array(
        			'conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
'StudentEvalutionRate.rating !=0',
'StudentEvalutionRate.instructor_evalution_question_id is not null'),
        			'limit'=>$totalEvaluterStudents*$totalObjectiveStudentQuestion,
        			'recursive'=>-1
        			)
        		);
        		
                
               foreach ($allStudentEvaluation as 
               $rd => $rv) {
              
               //remove duplicate evaluation result for same question of student evaluation if exists
               $allDuplicatedList=ClassRegistry::init('StudentEvalutionRate')->find('list',array(
		        			'conditions'=>array(
		        			'StudentEvalutionRate.published_course_id'
		        				=>$value['CourseInstructorAssignment']['published_course_id'],
		'StudentEvalutionRate.student_id'=>$rv['StudentEvalutionRate']['student_id'],
		'StudentEvalutionRate.instructor_evalution_question_id'=>$rv['StudentEvalutionRate']['instructor_evalution_question_id']),'fields'=>array('StudentEvalutionRate.id','StudentEvalutionRate.id')));
		     		
		              	 if(count($allDuplicatedList)>1){

		                            // perform deletion except one instance 

							$firstInstance=ClassRegistry::init('StudentEvalutionRate')->find('first',
							array(
							'conditions'=>array(
								'StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
							'StudentEvalutionRate.student_id'=>$rv['StudentEvalutionRate']['student_id'],
							'StudentEvalutionRate.instructor_evalution_question_id'=>$rv['StudentEvalutionRate']['instructor_evalution_question_id']
								),
								'recursive'=>-1
							)
							);
							unset($allDuplicatedList[$firstInstance['StudentEvalutionRate']['id']]);
							if(count($allDuplicatedList)){
		debug($allDuplicatedList);					
							ClassRegistry::init('StudentEvalutionRate')->deleteAll(
							array('StudentEvalutionRate.id' => $allDuplicatedList), false, false);
							
							
					    }  
		           }

                }
        
		          $sum=ClassRegistry::init('StudentEvalutionRate')->find('all',
        		array(
        			'conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
'StudentEvalutionRate.rating !=0'
        				),
        			'fields'=>array('sum(StudentEvalutionRate.rating)'),
        			

        			)
        		);
        		debug($sum);
        		if(!empty($value['PublishedCourse']['Course']['course_title'])){
	               $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['studentTotalRate']=$sum[0][0]['sum(`StudentEvalutionRate`.`rating`)'];
	               $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['totalEvaluterStudents']=$totalEvaluterStudents;
	             
	                $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['averageRate']=
	                $sum[0][0]['sum(`StudentEvalutionRate`.`rating`)']/$totalEvaluterStudents;
					
	                 $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Student'][$value['PublishedCourse']['Course']['course_title'].'~'.$value['PublishedCourse']['Section']['name'].'~'.$value['PublishedCourse']['id']]['rateconverted5percent']=(5*$sum[0][0]['sum(`StudentEvalutionRate`.`rating`)'])/($totalObjectiveStudentQuestion*5*$totalEvaluterStudents);
	             }
            }
            
           $allcolleagueEvalution=$this->find('all',
			array(
			'conditions'=>array(
			'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
			'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
			'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
			'ColleagueEvalutionRate.dept_head'=>0
			),
			'contain'=>array('InstructorEvalutionQuestion')
			)
			);
			
		 $totalStaffEvalutedInstructor=ClassRegistry::init('ColleagueEvalutionRate')->find('count',
			array('conditions'=>array(
				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
					'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
					'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
					'ColleagueEvalutionRate.dept_head'=>0
				),
			  'group'=>array('ColleagueEvalutionRate.evaluator_id')
			));
			 
			//remove duplicate entry of evaluation of staffs
			/*
           foreach ($allcolleagueEvalution as 
		   $key => $value2) {
			
		       $allDuplicatedList=$this->find('list',
	        		array(
	        			'conditions'=>array(
	        				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$value2['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$value2['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$value2['ColleagueEvalutionRate']['semester'],
	       	'ColleagueEvalutionRate.instructor_evalution_question_id'
	       	=>$value2['ColleagueEvalutionRate']['instructor_evalution_question_id'], 				'ColleagueEvalutionRate.dept_head'=>0
	        				),
	        			'fields'=>array('ColleagueEvalutionRate.id','ColleagueEvalutionRate.id')
	        			
	        			)
	        	);
	        	
	        	if(count($allDuplicatedList)>1)
	        	{
	        	debug($allDuplicatedList);
				// perform deletion except one instance 
				// perform deletion except one instance 
				$firstInstance=$this->find('first',
							array(
							'conditions'=>array(
								'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$value2['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$value2['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$value2['ColleagueEvalutionRate']['semester'],
	       	'ColleagueEvalutionRate.instructor_evalution_question_id'
	       	=>$value2['ColleagueEvalutionRate']['instructor_evalution_question_id'], 				'ColleagueEvalutionRate.dept_head'=>0
								),
								'recursive'=>-1
							)
							);
						unset($allDuplicatedList[$firstInstance['ColleagueEvalutionRate']['id']]);
					    if(count($allDuplicatedList)){
							$this->deleteAll(
							array(
							'ColleagueEvalutionRate.id' => $allDuplicatedList), false, false);
					    } 
				}
	        	    		
		   }  
		   */
		   
		   //colleague evaluation 
            
			$colleagueEvalution=$this->find('all',
			array(
			'conditions'=>array(
			'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
			'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
			'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
			'ColleagueEvalutionRate.dept_head'=>0
			),
			
			//'group'=>array('ColleagueEvalutionRate.evaluator_id')
			'contain'=>array('InstructorEvalutionQuestion')
			)
			);
			
		   $sumColleagueEvaluation=0; 
		 			   $totalObjectiveColleagueQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveColleagueQuestion($data['Search']['acadamic_year'],$data['Search']['semester'],$value['CourseInstructorAssignment']['staff_id']);
					   $totalObjectiveHeadQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveHeadQuestion($data['Search']['acadamic_year'],$data['Search']['semester'],$value['CourseInstructorAssignment']['staff_id']);
		$totalObjectiveQuestionArr=array();			  
		$sumColleagueEvaluationActive=0;
		$sumColleagueEvaluationDeactivate=0;
		foreach ($colleagueEvalution as 
		   $key => $value2) {
        		/*
	        	$colleagueEvalutionSum=$this->find('all',
	        		array(
	        			'conditions'=>array(
	        				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$value2['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$value2['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$value2['ColleagueEvalutionRate']['semester'],
	        				'ColleagueEvalutionRate.dept_head'=>0
	        				),
	        		'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
	        			
	        			)
	        	);
	        	*/
	     	    if($value2['InstructorEvalutionQuestion']['active']==0){
	     	   
		
		$sumColleagueEvaluationDeactivate+=$value2['ColleagueEvalutionRate']['rating'];
		
	     	    } else if ($value2['InstructorEvalutionQuestion']['active']==1){
	     	       $sumColleagueEvaluationActive+=$value2['ColleagueEvalutionRate']['rating'];
	     	    }
	       		$sumColleagueEvaluation+=$value2['ColleagueEvalutionRate']['rating'];
	       		$totalObjectiveQuestionArr[$value2['InstructorEvalutionQuestion']['active']][$value2['ColleagueEvalutionRate']['instructor_evalution_question_id']]=$value2['ColleagueEvalutionRate']['instructor_evalution_question_id'];
        }
       
       if($sumColleagueEvaluationDeactivate>=$sumColleagueEvaluationActive){
 			 $totalObjectiveColleagueQuestion=count($totalObjectiveQuestionArr[0]);
 			 $sumColleagueEvaluation=$sumColleagueEvaluationDeactivate;
       } else if ($sumColleagueEvaluationActive>=$sumColleagueEvaluationDeactivate){
          $totalObjectiveColleagueQuestion=count($totalObjectiveQuestionArr[1]);
           $sumColleagueEvaluation=$sumColleagueEvaluationActive;
       }
       
         $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Colleague']['colleagueTotalRate']=$sumColleagueEvaluation;
	   
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Colleague']['averageRate']=
        ($evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Colleague']['colleagueTotalRate']/$totalStaffEvalutedInstructor);
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Colleague']['totalEvaluterStaff']=$totalStaffEvalutedInstructor;
        
       $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Colleague']['rateconverted5percent']=($sumColleagueEvaluation*5)/($totalObjectiveColleagueQuestion*$totalStaffEvalutedInstructor*5);
     
      /*
        $headSum=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>1
        				),
        			'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        		
        			)
        );
        */
       
        $headEv=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>1
        				),
        			//'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        		'contain'=>array('InstructorEvalutionQuestion')
        			)
        );
     	//remove duplicate entry of evaluation of staffs
		/*
       foreach ($headEv as 
	   $hs => $hv ) {
	   
	   		 $allDuplicatedList=$this->find('list',
	        		array(
	        			'conditions'=>array(
	        				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$hv['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$hv['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$hv['ColleagueEvalutionRate']['semester'],
	       	'ColleagueEvalutionRate.instructor_evalution_question_id'
	       	=>$hv['ColleagueEvalutionRate']['instructor_evalution_question_id'], 				'ColleagueEvalutionRate.dept_head'=>1
	        				),
	        			'fields'=>array('ColleagueEvalutionRate.id','ColleagueEvalutionRate.id')
	        			
	        			)
	        	);
	        	
	        	if(count($allDuplicatedList)>1)
	        	{
	        	   $firstInstance=$this->find('first',
							array(
							'conditions'=>array(
								'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$hv['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$hv['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$hv['ColleagueEvalutionRate']['semester'],
	       	'ColleagueEvalutionRate.instructor_evalution_question_id'
	       	=>$hv['ColleagueEvalutionRate']['instructor_evalution_question_id'], 				'ColleagueEvalutionRate.dept_head'=>1
								),
								'recursive'=>-1
							)
							);
						unset($allDuplicatedList[$firstInstance['ColleagueEvalutionRate']['id']]);
	        	    if(count($allDuplicatedList)){
	        		$this->deleteAll(
							array(
							'ColleagueEvalutionRate.id' => $allDuplicatedList), false, false);
	        		}
	        	}
	        
	   }
	   */
       $headEv=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$value['CourseInstructorAssignment']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>1
        				),
        			//'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        		'contain'=>array('InstructorEvalutionQuestion')
        			)
        );
        $totalObjectiveQuestionHeadArr=array();
        $headSum=0;
        $headSumDeactivate=0;
        $headSumActive=0;
          debug($headEv);
        foreach($headEv as $hs=>$hv){
        debug($hv);
          $headSum+=$hv['ColleagueEvalutionRate']['rating'];
           if($hv['InstructorEvalutionQuestion']['active']==0){
	     	   $headSumDeactivate+=$hv['ColleagueEvalutionRate']['rating'];
		
	     	    } else if ($hv['InstructorEvalutionQuestion']['active']==1){
	     	       $headSumActive+=$hv['ColleagueEvalutionRate']['rating'];
	     	    }
	       		
	       		$totalObjectiveQuestionHeadArr[$hv['InstructorEvalutionQuestion']['active']][$hv['ColleagueEvalutionRate']['instructor_evalution_question_id']]=$hv['ColleagueEvalutionRate']['instructor_evalution_question_id'];
	       	
        }
        debug($headSumDeactivate);
        debug($headSumActive);
        debug($totalObjectiveHeadQuestion);
        debug($totalObjectiveQuestionHeadArr);
       if($headSumDeactivate>=$headSumActive){
 			 $totalObjectiveHeadQuestion=count($totalObjectiveQuestionHeadArr[0]);
 			 $headSum=$headSumDeactivate;
       } else if ($headSumActive>=$headSumDeactivate){
          $totalObjectiveHeadQuestion=count($totalObjectiveQuestionHeadArr[1]);
           $headSum=$headSumActive;
       } else {
       	debug($totalObjectiveHeadQuestion);
       } 
      
       $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['EvaluatedStaffDetail']=$this->Staff->find('first',array('conditions'=>array(
        'Staff.id'=>$value['CourseInstructorAssignment']['staff_id']),
        	'contain'=>array('Position','Title','Department','College')
        ));
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['EvaluatedStaffDetail']['academic_year']=$data['Search']['acadamic_year'];
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['EvaluatedStaffDetail']['semester']=$data['Search']['semester'];
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Head'][0]['headTotalRate']=$headSum;
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['Head'][0]['rateconverted5percent']=(5*$headSum)/($totalObjectiveHeadQuestion*5);
        
        $evalutionResult[$value['CourseInstructorAssignment']['staff_id']]['InstructorEvalutionSetting']=$readEvaluationSettings['InstructorEvalutionSetting'];
        
            
        }
        
        return $evalutionResult;
        /*
        $colleagueEvalution=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$data['Search']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>0
        				),
        			//'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        			'group'=>array('ColleagueEvalutionRate.evaluator_id')
        			
        			)
        );
        $totalStaffEvalutedInstructor=ClassRegistry::init('ColleagueEvalutionRate')->find('count',
        		array('conditions'=>array(
        			'ColleagueEvalutionRate.staff_id'=>$data['Search']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>0
        			),
                  'group'=>array('ColleagueEvalutionRate.evaluator_id')
        		));

        foreach ($colleagueEvalution as $key => $value) {
        
	        	$colleagueEvalutionSum=$this->find('all',
	        		array(
	        			'conditions'=>array(
	        				'ColleagueEvalutionRate.staff_id'=>$value['ColleagueEvalutionRate']['staff_id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$value['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$value['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$value['ColleagueEvalutionRate']['semester'],
	        				'ColleagueEvalutionRate.dept_head'=>0
	        				),
	        			'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
	        			
	        			)
	        	);
	        	
	        	 $evalutionResult['Colleague']['colleagueTotalRate']+=$colleagueEvalutionSum[0][0]['sum(`ColleagueEvalutionRate`.`rating`)'];
	          
        }
      
      $evalutionResult['Colleague']['averageRate']=($evalutionResult['Colleague']['colleagueTotalRate']/$totalStaffEvalutedInstructor);
       $evalutionResult['Colleague']['rateconverted5percent']=(5*$evalutionResult['Colleague']['colleagueTotalRate'])/($totalObjectiveColleagueQuestion*5*$totalStaffEvalutedInstructor);

      
        $headSum=$this->find('all',
        		array(
        			'conditions'=>array(
        				'ColleagueEvalutionRate.staff_id'=>$data['Search']['staff_id'],
        				'ColleagueEvalutionRate.academic_year'=>$data['Search']['acadamic_year'],
        				'ColleagueEvalutionRate.semester'=>$data['Search']['semester'],
        				'ColleagueEvalutionRate.dept_head'=>1
        				),
        			'fields'=>array('sum(ColleagueEvalutionRate.rating)'),
        		
        			)
        );
        
        $evalutionResult['EvaluatedStaffDetail']=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$data['Search']['staff_id']),
        	'contain'=>array('Position','Title','Department','College')
        ));
        $evalutionResult['EvaluatedStaffDetail']['academic_year']=$data['Search']['acadamic_year'];
        $evalutionResult['EvaluatedStaffDetail']['semester']=$data['Search']['semester'];
        $evalutionResult['Head'][0]['headTotalRate']=$headSum[0][0]['sum(`ColleagueEvalutionRate`.`rating`)'];
        $evalutionResult['Head'][0]['rateconverted5percent']=(5*$headSum[0][0]['sum(`ColleagueEvalutionRate`.`rating`)'])/($totalObjectiveHeadQuestion*5);
        $evalutionResult['InstructorEvalutionSetting']=$readEvaluationSettings['InstructorEvalutionSetting'];
        */
      
       return $evalutionResult;
    }
    public function remove_duplicate_staff_evaluation($department_id="All",$academic_year,$semester){
       
       if(strcasecmp($department_id,"All")==0){
			$staffs=$this->Staff->find('all',array(
			'conditions'=>array('Staff.user_id in (select id from users where role_id=2)'),
			'recursive'=>-1)); 
       } else {
       		$staffs=$this->Staff->find('all',array(
			'conditions'=>array('Staff.user_id in (select id from users where role_id=2)',
			'Staff.department_id'=>$department_id
			),
			'recursive'=>-1)); 
      }
      
      foreach($staffs as $sk=>$sv){
      	$allcolleagueEvalution=$this->find('all',
			array(
			'conditions'=>array(
			'ColleagueEvalutionRate.staff_id'=>$sv['Staff']['id'],
			'ColleagueEvalutionRate.academic_year'=>$academic_year,
			'ColleagueEvalutionRate.semester'=>$semester,
			'ColleagueEvalutionRate.dept_head'=>0
			),
			'contain'=>array('InstructorEvalutionQuestion')
			)
			);
		$totalStaffEvalutedInstructor=ClassRegistry::init('ColleagueEvalutionRate')->find('count',
		array('conditions'=>array(
			'ColleagueEvalutionRate.staff_id'=>$sv['Staff']['id'],
				'ColleagueEvalutionRate.academic_year'=>$academic_year,
			'ColleagueEvalutionRate.semester'=>$semester,
				'ColleagueEvalutionRate.dept_head'=>0
			),
		  'group'=>array('ColleagueEvalutionRate.evaluator_id')
		)); 
	 //remove duplicate entry of evaluation of staffs 
     foreach ($allcolleagueEvalution as $key => $value2) {
		$allDuplicatedList=$this->find('list',array(
		'conditions'=>array(
		'ColleagueEvalutionRate.staff_id'=>$sv['Staff']['id'],
	       'ColleagueEvalutionRate.evaluator_id'=>$value2['ColleagueEvalutionRate']['evaluator_id'],
	       'ColleagueEvalutionRate.academic_year'=>$value2['ColleagueEvalutionRate']['academic_year'],
	       'ColleagueEvalutionRate.semester'=>$value2['ColleagueEvalutionRate']['semester'],
	'ColleagueEvalutionRate.instructor_evalution_question_id'
	       	=>$value2['ColleagueEvalutionRate']['instructor_evalution_question_id'], 				'ColleagueEvalutionRate.dept_head'=>0),'fields'=>array('ColleagueEvalutionRate.id','ColleagueEvalutionRate.id')));
	       if(count($allDuplicatedList)>1)
	       {
				// perform deletion except one instance 
				// perform deletion except one instance 
				$firstInstance=$this->find('first',
							array(
							'conditions'=>array(
'ColleagueEvalutionRate.staff_id'=>$sv['Staff']['id'],
	        				'ColleagueEvalutionRate.evaluator_id'=>$value2['ColleagueEvalutionRate']['evaluator_id'],
	        				'ColleagueEvalutionRate.academic_year'=>$value2['ColleagueEvalutionRate']['academic_year'],
	        				'ColleagueEvalutionRate.semester'=>$value2['ColleagueEvalutionRate']['semester'],
	       	'ColleagueEvalutionRate.instructor_evalution_question_id'
	       	=>$value2['ColleagueEvalutionRate']['instructor_evalution_question_id'], 				'ColleagueEvalutionRate.dept_head'=>0
								),
								'recursive'=>-1
							)
							);
						unset($allDuplicatedList[$firstInstance['ColleagueEvalutionRate']['id']]);
					    if(count($allDuplicatedList)){
							//debug($allDuplicatedList);
							//die;
							
							$this->deleteAll(
							array(
							'ColleagueEvalutionRate.id' => $allDuplicatedList), false, false);
							
					    } 
				}    		
		   } 
      }
     
    }
    public function remove_duplicate_student_evaluation($department_id="All",$academic_year,$semester)
    {
    	
       if(strcasecmp($department_id,"All")==0){
			 $courseInstructorAssignments=$this->Staff->CourseInstructorAssignment->find('all',array('conditions'=>array(
       'CourseInstructorAssignment.academic_year'=>$academic_year,
       'CourseInstructorAssignment.semester'=>$semester,
        'CourseInstructorAssignment.isprimary'=>1,
       ),'contain'=>array('Staff'=>array('Position','Title','Department','College'),'PublishedCourse'=>array('Course','Section','YearLevel'))));
       } else {
       		 $courseInstructorAssignments=$this->Staff->CourseInstructorAssignment->find('all',array('conditions'=>array(
       'CourseInstructorAssignment.academic_year'=>$academic_year,
       'CourseInstructorAssignment.semester'=>$semester,
       'CourseInstructorAssignment.isprimary'=>1,
       'CourseInstructorAssignment.staff_id in (select id from staffs where department_id in ("'.$department_id.'") )'),'contain'=>array('Staff'=>array('Position','Title','Department','College'),'PublishedCourse'=>array('Course','Section','YearLevel'))));
       }
     
     foreach ($courseInstructorAssignments as $key => $value) {
     	
       	$totalObjectiveStudentQuestion=ClassRegistry::init('InstructorEvalutionQuestion')->totalObjectiveStudentQuestion($academic_year,$semester);
		$totalEvaluterStudents=ClassRegistry::init('StudentEvalutionRate')->find('count',array('conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
		'StudentEvalutionRate.rating !=0'),
		'group'=>array('StudentEvalutionRate.student_id')));
		
    	//student evaluation
    	if($totalEvaluterStudents)
    	{
               $maximumSumPossibleForInstructor=$totalEvaluterStudents*$totalObjectiveStudentQuestion*5;
               $allStudentEvaluation=ClassRegistry::init('StudentEvalutionRate')->find('all',array(
               'conditions'=>array('StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
'StudentEvalutionRate.rating !=0'
        				),
        			'limit'=>$totalEvaluterStudents*$totalObjectiveStudentQuestion,
        			'recursive'=>-1
        			)
        		);
       	         
               //remove duplicate evaluation result for same question of student evaluation if exists 
               foreach ($allStudentEvaluation 
               as $rd => $rv) {
              	$allDuplicatedList=ClassRegistry::init('StudentEvalutionRate')->find('list',
		        		array(
		        			'conditions'=>array(
		        			'StudentEvalutionRate.published_course_id'
		        				=>$value['CourseInstructorAssignment']['published_course_id'],
		'StudentEvalutionRate.student_id'=>$rv['StudentEvalutionRate']['student_id'],
		'StudentEvalutionRate.instructor_evalution_question_id'=>$rv['StudentEvalutionRate']['instructor_evalution_question_id']),'fields'=>array('StudentEvalutionRate.id','StudentEvalutionRate.id')));
		       
		       if(count($allDuplicatedList)>1){
 // perform deletion except one instance 
 	$firstInstance=ClassRegistry::init('StudentEvalutionRate')->find('first',
							array(
							'conditions'=>array(
								'StudentEvalutionRate.published_course_id'=>$value['CourseInstructorAssignment']['published_course_id'],
							'StudentEvalutionRate.student_id'=>$rv['StudentEvalutionRate']['student_id'],
							'StudentEvalutionRate.instructor_evalution_question_id'=>$rv['StudentEvalutionRate']['instructor_evalution_question_id']
								),
								'recursive'=>-1
							)
							);
							
					  unset($allDuplicatedList[$firstInstance['StudentEvalutionRate']['id']]);
					  if(count($allDuplicatedList)){
						 ClassRegistry::init('StudentEvalutionRate')->deleteAll(array('StudentEvalutionRate.id' => $allDuplicatedList),false, false);			
					  }  
		           }
                }
            }
          }
    }

    
}
