<div class="gradeScales view">
<h2><?php  __('Grade Scale');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($gradeType['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $gradeType['GradeType']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($gradeScale['Program']['name'], array('controller' => 'programs', 'action' => 'view', $gradeScale['Program']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Own'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['own']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('One Time'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['one_time']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Related Grade Scale Details');?></h3>
	<?php if (!empty($gradeScale['GradeScaleDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('S.No'); ?></th>
		<th><?php __('Minimum Result'); ?></th>
		<th><?php __('Maximum Result'); ?></th>
		<th><?php __('Grade '); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
	</tr>
	<?php
		$i = 0;
		$counter=1;
		
		foreach ($gradeScale['GradeScaleDetail'] as $gradeScaleDetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
			// debug($gradeScaleDetail);
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $counter++;?></td>
			<td><?php echo $gradeScaleDetail['minimum_result'];?></td>
			<td><?php echo $gradeScaleDetail['maximum_result'];?></td>
			<td><?php echo $gradeScaleDetail['Grade']['grade'];?></td>
			<td><?php echo $gradeScaleDetail['created'];?></td>
			<td><?php echo $gradeScaleDetail['modified'];?></td>
			
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<?php 
    if ($role_id==ROLE_DEPARTMENT && !empty ($gradeScale['PublishedCourse']) ) {
?>
<div class="related">
	<h3><?php __('Related Published Courses');?></h3>
	<?php if (!empty($gradeScale['PublishedCourse'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Year Level Id'); ?></th>
		<th><?php __('Semester'); ?></th>
		<th><?php __('Course Id'); ?></th>
		<th><?php __('Program Type Id'); ?></th>
		<th><?php __('Program Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Section Id'); ?></th>
		<th><?php __('Academic Year'); ?></th>
		<th><?php __('Published'); ?></th>
		<th><?php __('Drop'); ?></th>
		<th><?php __('Add'); ?></th>
		<th><?php __('Published Up'); ?></th>
		<th><?php __('Published Down'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('College Id'); ?></th>
		<th><?php __('Grade Scale Id'); ?></th>
		<th><?php __('Number Of Session'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($gradeScale['PublishedCourse'] as $publishedCourse):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $publishedCourse['id'];?></td>
			<td><?php echo $publishedCourse['year_level_id'];?></td>
			<td><?php echo $publishedCourse['semester'];?></td>
			<td><?php echo $publishedCourse['course_id'];?></td>
			<td><?php echo $publishedCourse['program_type_id'];?></td>
			<td><?php echo $publishedCourse['program_id'];?></td>
			<td><?php echo $publishedCourse['department_id'];?></td>
			<td><?php echo $publishedCourse['section_id'];?></td>
			<td><?php echo $publishedCourse['academic_year'];?></td>
			<td><?php echo $publishedCourse['published'];?></td>
			<td><?php echo $publishedCourse['drop'];?></td>
			<td><?php echo $publishedCourse['add'];?></td>
			<td><?php echo $publishedCourse['published_up'];?></td>
			<td><?php echo $publishedCourse['published_down'];?></td>
			<td><?php echo $publishedCourse['created'];?></td>
			<td><?php echo $publishedCourse['modified'];?></td>
			<td><?php echo $publishedCourse['college_id'];?></td>
			<td><?php echo $publishedCourse['grade_scale_id'];?></td>
			<td><?php echo $publishedCourse['number_of_session'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'published_courses', 'action' => 'view', $publishedCourse['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'published_courses', 'action' => 'edit', $publishedCourse['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'published_courses', 'action' => 'delete', $publishedCourse['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $publishedCourse['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<?php } ?>
