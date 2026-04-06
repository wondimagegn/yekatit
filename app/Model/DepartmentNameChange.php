<?php
class DepartmentNameChange extends AppModel
{
	var $name = 'DepartmentNameChange';

	var $belongsTo = array(
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
			'conditions' => '',
			//'conditions' => array('is_name_Changed' => '1'),
			'dependent' => false,
			'fields' => '',
			'order' => ''
		),
	);

	function canItBeDeleted($department_name_change_id = null)
	{
		// check there are students graduated in the department before department_name_changes end_date

		// allow non exists
	}

	function getDepartmentNameChangeIfExists($department_id = null, $end_date_to_check = null, $academic_year_to_check = null) 
	{
		if (!empty($department_id)) {

			$departmentNameChangeCheck = $this->Department->find('first', array(
				'conditions' => array(
					'Department.id' => $department_id,
				),
				'contain' => array(
					'DepartmentNameChange' => array(
						'order' => array('DepartmentNameChange.end_date' => 'ASC', 'DepartmentNameChange.end_academic_year' => 'ASC')
					)
				),
				'recursive' => -1,
			));

			//debug($departmentNameChangeCheck);

			$oldDepartmentName = array();

			if (!empty($departmentNameChangeCheck) && isset($departmentNameChangeCheck['Department']['is_name_Changed']) && $departmentNameChangeCheck['Department']['is_name_Changed']) {
				
				if (isset($departmentNameChangeCheck['DepartmentNameChange']) && !empty($departmentNameChangeCheck['DepartmentNameChange'])) {

					foreach ($departmentNameChangeCheck['DepartmentNameChange'] as $key => $nameChange) {
						
						if (!empty($end_date_to_check) && !empty($nameChange['end_date'])) {

							$dateInput = $end_date_to_check;
							$compareDate = $nameChange['end_date'];

							if (strtotime($dateInput) !== false && strtotime($compareDate) !== false) {
								
								$date1 = new DateTime($dateInput);
								$date2 = new DateTime($compareDate);

								if (($date1 < $date2) || ($date1 == $date2)) { //earlear or the same date
									unset($nameChange['id']);
									unset($nameChange['created']);

									$oldDepartmentName['Department'] =  array_merge($departmentNameChangeCheck['Department'], $nameChange);
								}
							}

							//debug($oldDepartmentName);

						} else if (!empty($academic_year_to_check) && !empty($nameChange['end_academic_year'])) {

							$yearFromAcademicYear = explode('/' , $academic_year_to_check);
							$yearFromEndAcademicYear = explode('/' , $nameChange['end_academic_year']);

							if (empty($yearFromAcademicYear)) {
								$yearFromAcademicYear = explode('-' , $academic_year_to_check);
							}

							if (isset($yearFromAcademicYear[0]) && isset($yearFromEndAcademicYear[0]) && $yearFromAcademicYear[0] < $yearFromEndAcademicYear[0]) {
								// unset DepartmentNameChange.id so that it will not interfare with Department.id 
								unset($nameChange['id']);
								unset($nameChange['created']);

								// merge the two arrays so that the old department name overiddes the new department
								$oldDepartmentName['Department'] = array_merge($departmentNameChangeCheck['Department'], $nameChange);
							}

							//debug($oldDepartmentName);

						}
					}

					if (!empty($oldDepartmentName)) {
						return $oldDepartmentName;
					}

				}
			}
		}

		return 0;
	}
}
