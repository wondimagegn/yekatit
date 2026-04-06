<?php
class ProgramTypeTransfer extends AppModel
{
	var $name = 'ProgramTypeTransfer';

	var $actsAs = array(
		'Containable',
		'Tools.Logable' => array(
			'change' => 'full',
			//'change' => 'list',
			'description_ids' => 'true',
			'displayField' => 'username',
			'foreignKey' => 'foreign_key',
			'skip' => array('index', 'view', 'notify_program_transfer_to_department'), // functions to skip logging
			'ignore' => array('created', 'modified') // fields to ignore in log
		)
	);

	var $validate = array(
		'academic_year' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please provide academic year',
			),
		),
		'semester' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please provide semester',
			),
		),

	);

	var $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProgramType' => array(
			'className' => 'ProgramType',
			'foreignKey' => 'program_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function getProgramTransferDate($data = null)
	{
		$ordered_item = $this->find('first', array(
			'conditions' => array(
				'ProgramTypeTransfer.student_id' => $data['ProgramTypeTransfer']['student_id']
			),
			'contain' => array(),
			'order' => array('ProgramTypeTransfer.transfer_date' => 'DESC')
		));

		$check1 = $ordered_item['ProgramTypeTransfer']['transfer_date'];
		$check2 = $data['ProgramTypeTransfer']['transfer_date']['year'] . '-' . $data['ProgramTypeTransfer']['transfer_date']['month'] . '-' . $data['ProgramTypeTransfer']['transfer_date']['day'];

		if ($check2 < $check1) {
			$this->invalidate('error', 'The transfer date for ' . $data['ProgramTypeTransfer']['program_type_id'] . ' should greater than the earlier transfer date which is ' . $check1 . ' ');
			return false;
		}

		return true;
	}

	function getStudentProgramType($student_id = null, $acadamic_year = null, $semester = null)
	{
		
		$student_pt_transfers = $this->find('all', array(
			'conditions' => array('ProgramTypeTransfer.student_id' => $student_id),
			'order' => array('ProgramTypeTransfer.transfer_date' => 'ASC'),
			'contain' => array(),
			'recursive' => -1
		));

		$student_detail = $this->Student->find('first', array('conditions' => array('Student.id' => $student_id), 'contain' => array('AcceptedStudent.academicyear')));
		
		if (empty($student_pt_transfers)) {
			return $student_detail['Student']['program_type_id'];
		} else {

			########################################################  Optimization: ########################################################
			// exception handling for infinite loop in do .. while block, and set academic year and semester to current academic year and semester if not passed or if it is empty, Neway
			
			App::import('Component', 'AcademicYear');
			$AcademicYear = new AcademicYearComponent(new ComponentCollection);
			$current_acy_and_semester = $AcademicYear->current_acy_and_semester();

			if (empty($acadamic_year)) {
				$acadamic_year = $current_acy_and_semester['academic_year'];
			}

			if (empty($semester)) {
				$semester = $current_acy_and_semester['semester'];
			}

			$four_digit_ac_year = explode('/', $current_acy_and_semester['academic_year'])[0];
			$two_digit_year_ac_year = substr($four_digit_ac_year, -2);
			$years_ahead = 2; // 2 academic years a head from current academmic year
			$while_loop_end_acy = ($four_digit_ac_year + $years_ahead) . '/' . ($two_digit_year_ac_year + $years_ahead + 1);

			########################################################  END Optimization: ########################################################


			$program_type_id = $student_detail['Student']['program_type_id'];
			$sys_acadamic_year = $student_detail['AcceptedStudent']['academicyear'];
			$sys_semester = 'I';

			do {
				foreach ($student_pt_transfers as $key => $program_type_transfer) {
					if ($sys_acadamic_year == $program_type_transfer['ProgramTypeTransfer']['academic_year'] && $sys_semester == $program_type_transfer['ProgramTypeTransfer']['semester']) {
						$program_type_id = $program_type_transfer['ProgramTypeTransfer']['program_type_id'];
					}
				}

				if (!(strcasecmp($acadamic_year, $sys_acadamic_year) == 0 && strcasecmp($semester, $sys_semester) == 0)) {
					if (strcasecmp($sys_semester, 'I') == 0) {
						$sys_semester = 'II';
					} else if (strcasecmp($sys_semester, 'II') == 0) {
						$sys_semester = 'III';
					} else {
						$sys_semester = 'I';
						$sys_acadamic_year = (substr($sys_acadamic_year, 0, 4) + 1) . '/' . substr((substr($sys_acadamic_year, 0, 4) + 2), 2, 2);
					}
				} else {
					return $program_type_id;
				}
			} while ($sys_acadamic_year != $while_loop_end_acy /* '3000/01' */); // replace '3000/01' by $while_loop_end_acy which is 2 academic years a head from current academmic year

			return $program_type_id;
		}
	}

	function noDuplicateEntry($data = null)
	{
		$countEntries = $this->find('count', array(
			'conditions' => array(
				'ProgramTypeTransfer.student_id' => $data['ProgramTypeTransfer']['student_id'],
				'ProgramTypeTransfer.academic_year' => $data['ProgramTypeTransfer']['academic_year']
			)
		));

		if (!empty($countEntries)) {
			$this->invalidate('error', 'The student have existing program transfer for ' . $data['ProgramTypeTransfer']['academic_year'] . ' academic year.');
			return false;
		}

		$countEntries = $this->find('first', array(
			'conditions' => array(
				'ProgramTypeTransfer.student_id' => $data['ProgramTypeTransfer']['student_id'],
			),
			'contain' => array(),
		));

		if (!empty($countEntries)) {
			$this->invalidate('error', 'The student have existing program transfer for ' . $countEntries['ProgramTypeTransfer']['academic_year'] . ' academic year. A student can have only one program transfer up to graduation.');
			return false;
		}

		return true;
	}
}
