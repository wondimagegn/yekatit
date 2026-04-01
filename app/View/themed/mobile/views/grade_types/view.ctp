<div class="gradeTypes view">
<div class="smallheading"><?php  __('Grade Type');?></div>
<table class="fs13">
	<tr>
		<td style="width:15%">Type:</td>
		<td style="width:85%"><?php echo $gradeType['GradeType']['type']; ?></td>
	</tr>
	<tr>
		<td>Date Created:</td>
		<td><?php echo $this->Format->humanize_date($gradeType['GradeType']['created']); ?></td>
	</tr>
	<tr>
		<td>Date Modified:</td>
		<td><?php echo $this->Format->humanize_date($gradeType['GradeType']['modified']); ?></td>
	</tr>
</table>
</div>
<div class="related">
<div class="fs15"><?php __('List of Grades for '.$gradeType['GradeType']['type'].' grade type');?></div>
	<?php if (!empty($gradeType['Grade'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
	    <th><?php __('S.No'); ?></th>
		<th><?php __('Grade'); ?></th>
		<th><?php __('Point Value'); ?></th>
		
		<th><?php __('Pass Grade'); ?></th>
		
		<th class="actions" style="text-align:center"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($gradeType['Grade'] as $grade):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $count++;?></td>
			<td><?php echo $grade['grade'];?></td>
			<td><?php echo $grade['point_value'];?></td>
			<td><?php echo ($grade['pass_grade'] == 1 ? 'Yes' : 'No');?></td>
			
			<td class="actions">
				
				<?php echo $this->Html->link(__('Edit', true), array( 'action' => 'edit', $gradeType['GradeType']['id'])); 
				$action_controller_id='view~gradeTypes~'.$grade['grade_type_id'];
				?>
				
				<?php echo $this->Html->link(__('Delete', true), array('controller'=>'grades','action' => 'delete', $grade['id'],$action_controller_id), null, sprintf(__('Are you sure you want to delete # %s?', true), $grade['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<!--- 
<div class="related">
	<h3><?php __('Related Courses');?></h3>
	<?php if (!empty($gradeType['Course'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Course Title'); ?></th>
		<th><?php __('Course Code'); ?></th>
		
		<th><?php __('Credit'); ?></th>
		<th width="5%"><?php __('L T L');?></th>
		<th><?php __('Curriculum'); ?></th>
		<th><?php __('Course Category'); ?></th>
		<th><?php __('Department'); ?></th>
		
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($gradeType['Course'] as $course):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $course['id'];?></td>
			<td><?php echo $course['course_title'];?></td>
			<td><?php echo $course['course_code'];?></td>
			
			<td><?php echo $course['credit'];?></td>
			<td><?php echo $course['course_detail_hours'];?></td>
			
			<td><?php echo $course['Curriculum']['name'];?></td>
			<td><?php echo $course['CourseCategory']['name'];?></td>
			<td><?php echo $course['Curriculum']['Department']['name'];?></td>
			
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'courses', 'action' => 'view', $course['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'courses', 'action' => 'edit', $course['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'courses', 'action' => 'delete', $course['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $course['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
--->
