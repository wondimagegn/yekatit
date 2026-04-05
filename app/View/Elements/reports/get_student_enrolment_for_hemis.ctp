<?php
if (isset($studentEnrolmentHEMIS) && !empty($studentEnrolmentHEMIS)) { 
	foreach ($studentEnrolmentHEMIS as $programD => $list) {
		$headerExplode = explode('~', $programD); ?>
		<div style="overflow-x:auto;">
			<table cellpadding="0" cellspacing="0" class="table">
				<thead>
					<tr>
						<th class="center">#</th>
						<th class="center">Graduated</th>
						<th class="vcenter">Department</th>
						<th class="vcenter">Section</th>
						<th class="vcenter">Full Name</th>
						<th class="center">Sex</th>
						<th class="center">Region</th>
						<th class="center">student_institution_id</td>
						<th class="center">institution_code</td>
						<th class="center">student_national_id</th>
						<th class="center">academic_year</th>
						<th class="center">academic_period</th>
						<th class="center">academic_term</th>
						<th class="center">campus_code</th>
						<th class="center">program</th>
						<th class="center">program_modality</th>
						<th class="center">target_qualification</th>
						<th class="center">year_level</th>
						<th class="center">enrollment_type</th>
						<th class="center">foreign_program</th>
						<th class="center">economically_supported</th>
						<th class="center">required_academic_periods</th>
						<th class="center">required_credits</th>
						<th class="center">current_registred_credits</th>
						<th class="center">cumulative_registred_credits</th>
						<th class="center">cumulative_completed_credits</th>
						<th class="center">cumulative_gpa</th>
						<th class="center">outgoing_exchange</th>
						<th class="center">incoming_exchange</th>
						<th class="center">exchange_country</th>
						<th class="center">exchange_institution</th>
						<th class="center">exchange_institution_lng</th>
						<th class="center">sponsorship</th>
						<th class="center">student_economical_status</th>
						<th class="center">student_disability</th>
						<th class="center">specially_gifted</th>
						<th class="center">food_service_type</th>
						<th class="center">dormitory_service_type</th>
						<th class="center">cost_sharing_loan</th>
						<th class="center">current_cost_sharing</th>
						<th class="center">accumulated_cost_sharing</th>
						<th class="center">settelment_type</th>
						<th class="center">settelment_date</th>
						<!-- <th class="center">total_academic_periods </td> -->
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 0;
					//debug($list[0]); 
					foreach ($list as $ko => $val) {
						$rowColorStyle = (isset($val['rowColor']) && !empty($val['rowColor']) ? 'style="color:' . $val['rowColor'] . ';"' : ''); 
						//$studentTakenCreditsSemesters = ClassRegistry::init('StudentExamStatus')->getStudentTotalAccumulatedCreditsAndSemesterCount($val['id'], $this->request->data['Report']['acadamic_year'], $this->request->data['Report']['semester']); ?>
						<tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?= (isset($val['student_id']) ? $val['student_id'] : (isset($val['stud_id']) ? $val['stud_id'] : 0)); ?>">
							<td class="center" <?= $rowColorStyle; ?>><?= ++$count; ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= ($val['graduated'] == 1 ? 'Yes' : 'No'); ?></td>
							<td class="vcenter" <?= $rowColorStyle; ?>><?= (isset($val['Department']) && isset($val['Department']['name']) ? $val['Department']['name'] : (isset($val['College']) && isset($val['College']['name']) ? $val['College']['name']: '---')); ?></td>
							<td class="vcenter" <?= $rowColorStyle; ?>><?= (isset($val['Section']) ? $val['Section'] : '---'); ?></td>
							<td class="vcenter" <?= $rowColorStyle; ?>><?= $val['first_name'] . ' ' . $val['middle_name'] . ' ' . $val['last_name']; ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= ((strcasecmp(trim($val['gender']), 'male') == 0) ? 'M' : ((strcasecmp(trim($val['gender']), 'female') == 0) ? 'F' : trim($val['gender']))); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['Region']) && !empty($val['Region']) ? $val['Region'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= $val['studentnumber']; ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['Department']) && isset($val['Department']['institution_code']) ? $val['Department']['institution_code'] :( isset($val['College']) && isset($val['College']['institution_code']) ? $val['College']['institution_code']: '---')); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['student_national_id']) ? $val['student_national_id'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (str_replace('/', '', $val['academic_year'])); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= ((strcasecmp($val['semester'], 'I') == 0) ? 'S1':(strcasecmp($val['semester'], 'II') == 0 ? 'S2' : 'SS')); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= ((strcasecmp($val['semester'], 'III') == 0) ? 'T1':(strcasecmp($val['semester'], 'I') == 0 ? 'T3' : 'T4')); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['College']['Campus']) && isset($val['College']['Campus']['campus_code']) ? $val['College']['Campus']['campus_code']: '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- program --><?= (isset($val['StudyProgram']) ? $val['StudyProgram'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['ProgramModality']) ? $val['ProgramModality'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['TargetQualification']) ? $val['TargetQualification'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['YearLevel']) ? $val['YearLevel'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['EnrollmentType']) ? $val['EnrollmentType'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['ForeignProgram']) ? $val['ForeignProgram'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- economically_supported -->N</td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['RequiredAcademicPeriods']) ? $val['RequiredAcademicPeriods'] : '---'); ?></td></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['RequiredCredit']) ? $val['RequiredCredit'] : '<span style="color:red;"><b>N/A</b></span>'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['CurrentRegistredCredit']) ? $val['CurrentRegistredCredit'] : '0'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['CumulativeRegistredCredit']) ? $val['CumulativeRegistredCredit'] : '0'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['studentTakenCreditsSemesters'][0][0]['totalAccumulatedCredits']) ? (int) $val['studentTakenCreditsSemesters'][0][0]['totalAccumulatedCredits'] : '---'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><?= (isset($val['CumulativeGPA']) ? $val['CumulativeGPA'] : '0'); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- outgoing_exchange -->N</td>
							<td class="center" <?= $rowColorStyle; ?>><!-- incoming_exchange -->N</td>
							<td class="center" <?= $rowColorStyle; ?>><!-- exchange_country --></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- exchange_institution --></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- exchange_institution_lng --></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- sponsorship --><?= (isset($val['Sponsorship']) ? $val['Sponsorship'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- student_economical_status --></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- student_disability --></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- specially_gifted -->N</td>
							<td class="center" <?= $rowColorStyle; ?>><!-- food_service_type --><?= (isset($val['FoodServiceType']) ? $val['FoodServiceType'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- dormitory_service_type --><?= (isset($val['DormitoryServiceType']) ? $val['DormitoryServiceType'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- cost_sharing_loan --><?= (isset($val['CostSharingLoan']) ? $val['CostSharingLoan'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- current_cost_sharing --><?= (isset($val['CurrentCostSharing']) && $val['CostSharingLoan'] == 'Y' ? $val['CurrentCostSharing'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- accumulated_cost_sharing --><?= (isset($val['AccumulatedCostSharing']) && $val['CostSharingLoan'] == 'Y' ? $val['AccumulatedCostSharing'] : ''); ?></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- settelment_type --></td>
							<td class="center" <?= $rowColorStyle; ?>><!-- settelment_date --></td>
							<!-- <td class="center"><?php //echo ((isset($val['studentTakenCreditsSemesters'][0][0]['totalSemesters'])) ? $val['studentTakenCreditsSemesters'][0][0]['totalSemesters'] : '---'); ?></td> -->
						</tr>
						<?php
					} ?>
				</tbody>
			</table>
		</div>
		<br>
		<?php
	}
} ?>