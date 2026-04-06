<?php 
  echo $this->Form->Create('Page'); 
?>
<div class="large-12 columns">
	 <h2 class="box-title">
	<?php echo __('Academic Calendar ');?>
	  </h2>
	</div>
	<div class="large-12 columns">
		<div class="row">
			<div class="large-3 columns">
		<?php 
	
			echo $this->Form->input('Search.academic_year',array('id'=>'academicyear',
	'label' =>'Academic Year','type'=>'select','options'=>$acyear_array_data,
	'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:''))
	?>
			</div>
			<div class="large-3 columns">
			<?php 
			 echo $this->Form->input('Search.semester',array('options'=>array('I'=>'I','II'=>'II',
	'III'=>'III'),'empty'=>'--select semester--'));
	?>
			</div>
			<div class="large-3 columns">
			<?php 
			echo $this->Form->input('Search.program_id');
	?>
			</div>
			<div class="large-3 columns">
			<?php 
			echo $this->Form->input('Search.program_type_id');
	?>
			</div>		
		</div>
		<div class="row">
			 <div class="large-3 columns">
		  <?php 
			  	 echo $this->Form->submit(__('View Academic Calendar'), array('name' => 'viewAcademicCalendar','class'=>'tiny radius button bg-blue', 'id' => 'viewAcademicCalendar', 'div' => false));
		  ?>
		  	</div>
		</div>
		<?php if(isset($academicCalendars) && !empty($academicCalendars)) { ?>
			<div class="row">
			   <div class="large-12 columns">
			   		<table style="width:100%" class="display" cellpadding="0" cellspacing="0">
			   			<thead>
			   				<th>Date</th>
			   				<th>Activity</th>
			   				<th>Year</th>
			   				<th>Department</th>
			   			</thead>
			   			<tbody>
			   				<?php foreach($academicCalendars as $k=>$v){ ?>
			   				<tr>
			   					<td>
			   					<?php 
			   					echo 'From '.$this->Format->humanize_date($v['AcademicCalendar']['course_registration_start_date']).' To '.$this->Format->humanize_date($v['AcademicCalendar']['course_registration_end_date']); 
			   					?>
			   					</td>
			   					<td>
			   					Course Registration Start & End Date
			   					</td>
			   					
			   					<td>
			   					<?php echo $v['AcademicCalendar']['year_name'];?>
			   					</td>
			   					<td>
			   					<?php echo $v['AcademicCalendar']['department_name'];?>
			   					</td>
			   				</tr>
			   				<tr>
			   					<td>
			   					<?php 
			   					echo 'From '.$this->Format->humanize_date($v['AcademicCalendar']['course_add_start_date']).' To '.$this->Format->humanize_date($v['AcademicCalendar']['course_add_end_date']); 
			   					?>
			   					</td>
			   					<td>
			   					Course Add Start & End Date
			   					</td>
			   					
			   					<td>
			   					<?php echo $v['AcademicCalendar']['year_name'];?>
			   					</td>
			   					<td>
			   					<?php echo $v['AcademicCalendar']['department_name'];?>
			   					</td>
			   				</tr>
			   				
			   				<tr>
			   					<td>
			   					<?php 
			   					echo 'From '.$this->Format->humanize_date($v['AcademicCalendar']['course_drop_start_date']).' To '.$this->Format->humanize_date($v['AcademicCalendar']['course_drop_end_date']); 
			   					?>
			   					</td>
			   					<td>
			   					Course Drop Start & End Date
			   					</td>
			   					
			   					<td>
			   					<?php echo $v['AcademicCalendar']['year_name'];?>
			   					</td>
			   					<td>
			   					<?php echo $v['AcademicCalendar']['department_name'];?>
			   					</td>
			   				</tr>
			   				
			   				<tr>
			   					<td>
			   					<?php 
			   					echo 'From '.$this->Format->humanize_date($v['AcademicCalendar']['grade_submission_start_date']).' To '.$this->Format->humanize_date($v['AcademicCalendar']['grade_submission_end_date']); 
			   					?>
			   					</td>
			   					<td>
			   					Grade Submission Start & End Date
			   					</td>
			   					
			   					<td>
			   					<?php echo $v['AcademicCalendar']['year_name'];?>
			   					</td>
			   					<td>
			   					<?php echo $v['AcademicCalendar']['department_name'];?>
			   					</td>
			   				</tr>
			   				<?php } ?>
			   			</tbody>
			   		</table>
			   </div>
			</div>
		<?php } ?>
</div>

