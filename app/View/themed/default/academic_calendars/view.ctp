<?php ?>
<div class="academicCalendars view" style="padding-top:20px">


	<dl style="float:left"><?php $i = 0; $class = ' class="altrow"';?>
	    <dt><div class="smallheading"><?php  __('Academic Calendar');?></div></dt>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicCalendar['AcademicCalendar']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicCalendar['AcademicCalendar']['semester']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($academicCalendar['Program']['name'], array('controller' => 'programs', 'action' => 'view', $academicCalendar['Program']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($academicCalendar['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $academicCalendar['ProgramType']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Registration Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['course_registration_start_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Registration End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['course_registration_end_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Add Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['course_add_start_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Add End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['course_add_end_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Drop Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['course_drop_start_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Drop End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['course_drop_end_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Submission Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['grade_submission_start_date']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Submission End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicCalendar['AcademicCalendar']['grade_submission_end_date']); ?>
			&nbsp;
		</dd>
		<dt> <div class="smallheading"> <?php __('Year Level'); ?></div></dt>
		<br/>
		<?php 
		echo "<ul>";
		foreach ($academicCalendar['AcademicCalendar']['year_level_id'] as $year_level_id=>$year_level_name) {
		?>
		 <li<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $year_level_name; ?>
			&nbsp;
		</li>
		<?php 
		}
		echo "</ul>";
		?>
		
	    
	</dl>
	<dl style="float:left;width:35%">
	
	   <dt><div class="smallheading"><?php  __('College and Department which has this calendar');?></div></dt>
	    <?php 
	  echo "<ul>";
	  foreach($colleges as $college_id=>$college_name){

  
         //check
          if (isset($this->data['AcademicCalendar']['college_id']) && !empty($this->data['AcademicCalendar']['college_id']) && in_array($college_id,$this->data['AcademicCalendar']['college_id'])) {
            echo '<li>'.$college_name.'<ul>';         
         
         } else {
              echo '<li>'.$college_name.'<ul>';  
         }

         if (!empty($college_department[$college_id])){
              foreach($college_department[$college_id] as $department_id=>$department_name){
             
               if (in_array($department_id,$academicCalendar['AcademicCalendar']['department_id'])) {
                 echo '<li>'.$department_name.'</li>';

                } else {
                   echo '<li>'.$department_name.'</li>';
                }
             }
         }
         echo "</ul></li>";
         
         }
         echo "</ul>";
         ?>
	</dl>
	<div style="clear:both"></div>
	
</div>
<!-- 
<div class="related">
	<h3><?php __('Related Course Registrations');?></h3>
	<?php if (!empty($academicCalendar['CourseRegistration'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th>S.N<u>o</u></th>
		<th><?php __('Year Level '); ?></th>
		<th><?php __('Academic Calendar'); ?></th>
		<th><?php __('Academic Year'); ?></th>
		<th><?php __('Student Id'); ?></th>
		<th><?php __('Course Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($academicCalendar['CourseRegistration'] as $courseRegistration):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $courseRegistration['id'];?></td>
			<td><?php echo $courseRegistration['year_level_id'];?></td>
			<td><?php echo $courseRegistration['academic_calendar_id'];?></td>
			<td><?php echo $courseRegistration['academic_year'];?></td>
			<td><?php echo $courseRegistration['student_id'];?></td>
			<td><?php echo $courseRegistration['course_id'];?></td>
			<td><?php echo $courseRegistration['created'];?></td>
			<td><?php echo $courseRegistration['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'course_registrations', 'action' => 'view', $courseRegistration['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'course_registrations', 'action' => 'edit', $courseRegistration['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'course_registrations', 'action' => 'delete', $courseRegistration['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseRegistration['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
-->
