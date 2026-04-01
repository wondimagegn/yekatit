<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="gradeScales view">
<h2><?php echo __('Grade Scale');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Grade Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($gradeType['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $gradeType['GradeType']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Program'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($gradeScale['Program']['name'], array('controller' => 'programs', 'action' => 'view', $gradeScale['Program']['id'])); ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['active']==1 ? 'Yes':'No'; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Target'); ?></dt>
		<?php if(isset($college)&&!empty($college)) { ?>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['model'].'('.$college['College']['name'].')'; ?>
			&nbsp;
		</dd>
		<?php 
		} else if (isset($department) && !empty($department)) {
		
		?>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScale['GradeScale']['model'].'('.$department['Department']['name'].')'; ?>
			&nbsp;
		</dd>

		<?php } ?>

		
	</dl>
</div>

<div class="related">
	<h3><?php echo __('Related Grade Scale Details');?></h3>
	<?php if (!empty($gradeScale['GradeScaleDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('S.No'); ?></th>
		<th><?php echo __('Minimum Result'); ?></th>
		<th><?php echo __('Maximum Result'); ?></th>
		<th><?php echo __('Grade '); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
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
	<h3><?php echo __('Related Published Courses');?></h3>
	<?php if (!empty($gradeScale['PublishedCourse'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Year Level Id'); ?></th>
		<th><?php echo __('Semester'); ?></th>
		<th><?php echo __('Course Id'); ?></th>
		<th><?php echo __('Program Type Id'); ?></th>
		<th><?php echo __('Program Id'); ?></th>
		<th><?php echo __('Department Id'); ?></th>
		<th><?php echo __('Section Id'); ?></th>
		<th><?php echo __('Academic Year'); ?></th>
		<th><?php echo __('Published'); ?></th>
		<th><?php echo __('Drop'); ?></th>
		<th><?php echo __('Add'); ?></th>
		<th><?php echo __('Published Up'); ?></th>
		<th><?php echo __('Published Down'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('College Id'); ?></th>
		<th><?php echo __('Grade Scale Id'); ?></th>
		<th><?php echo __('Number Of Session'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View'), array('controller' => 'published_courses', 'action' => 'view', $publishedCourse['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'published_courses', 'action' => 'edit', $publishedCourse['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'published_courses', 'action' => 'delete', $publishedCourse['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $publishedCourse['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<?php } ?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
