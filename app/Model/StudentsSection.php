<?php
class StudentsSection extends AppModel {
	var $name = 'StudentsSection';
    
	public function getMostRecentSectionPublishedCourseNotRegistered($student_id,$semester=null) {
		
		$section = $this->find('first',
array('conditions'=>array('StudentsSection.student_id'=>$student_id,'StudentsSection.archive'=>0),'order'=>'StudentsSection.created DESC'));
		
		if(isset($section['StudentsSection']) && !empty($section['StudentsSection']['section_id'])) {
		  if(isset($semester) && !empty($semester)){
		  	 $publishedCourseNotRegistered=ClassRegistry::init('PublishedCourse')->find('all',array('conditions'=>array('PublishedCourse.section_id'=>$section['StudentsSection']['section_id'],
		  	 'PublishedCourse.semester'=>$semester,
		  	 'PublishedCourse.id not in (select id from course_registrations where student_id='.$student_id.' and section_id='.$section['StudentsSection']['section_id'].')'),
'contain'=>array('Course'=>array(
	            'Prerequisite'=>array('id','prerequisite_course_id','co_requisite'),'fields'=>array('Course.id','Course.course_code','Course.course_title','Course.lecture_hours',
'Course.tutorial_hours','Course.credit'))),
'order'=>'PublishedCourse.created DESC'));

		  } else{
		  $publishedCourseNotRegistered=ClassRegistry::init('PublishedCourse')->find('all',array('conditions'=>array('PublishedCourse.section_id'=>$section['StudentsSection']['section_id'],'PublishedCourse.id not in (select id from course_registrations where student_id='.$student_id.' and section_id='.$section['StudentsSection']['section_id'].')'),
'contain'=>array('Course'=>array(
	            'Prerequisite'=>array('id','prerequisite_course_id','co_requisite'),'fields'=>array('Course.id','Course.course_code','Course.course_title','Course.lecture_hours',
'Course.tutorial_hours','Course.credit'))),
'order'=>'PublishedCourse.created DESC'));
		  }
           	   return $publishedCourseNotRegistered;
		}		
		return array();  
		
	}
    
	public function getStudentsListInSection($section_id,$name=null) 
   {
        $list=array();
		$listStudents=$this->find('list',
array('conditions'=>array('StudentsSection.section_id'=>$section_id),'fields'=>array('StudentsSection.student_id',
'StudentsSection.student_id')));
		debug($listStudents);
         
		if(!empty($listStudents)) {
              if(!empty($name)) {
               $list = ClassRegistry::init('Student')->find("all", array("conditions"=>array(
				    'Student.id'=>$listStudents,
					'Student.first_name LIKE'=>$name.'%'
				 ),
				 'contain'=>array('StudentsSection')
		      ));
             } else {
               $list = ClassRegistry::init('Student')->find("all", array("conditions"=>array(
				    'Student.id'=>$listStudents,
				 ),
				 'contain'=>array('StudentsSection')
		      ));
			 }
              
			return $list;
		}

		return $list;
		
	}
	
	public function getStudentsIdsInSection($section_id) 
   {
        
		$listStudents=$this->find('list',
array('conditions'=>array('StudentsSection.section_id'=>$section_id),'fields'=>array('StudentsSection.student_id',
'StudentsSection.student_id')));
		

		return $listStudents;
		
	}
	public function isSectionGraduated($section_id){
		$studentIds=$this->getStudentsIdsInSection($section_id);
		if(empty($studentIds)){
			return false;
		}
		
		$gradutingStudent=ClassRegistry::init('GraduateList')->find('count',array('conditions'=>array('GraduateList.student_id'=>$studentIds)));
		debug($gradutingStudent);
		if($gradutingStudent>count($studentIds)/3){
			return true;
		}
		else{ 
			return false;
		}
	}
	 
}
?>
