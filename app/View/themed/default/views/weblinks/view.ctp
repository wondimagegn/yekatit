<div class="weblinks view">
<h2><?php  __('Weblink');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $weblink['Weblink']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $weblink['Weblink']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $weblink['Weblink']['url_address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $weblink['Weblink']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $weblink['Weblink']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Weblink', true), array('action' => 'edit', $weblink['Weblink']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Weblink', true), array('action' => 'delete', $weblink['Weblink']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $weblink['Weblink']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Weblinks', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Weblink', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Courses');?></h3>
	<?php if (!empty($weblink['Course'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Course Title'); ?></th>
		<th><?php __('Course Code'); ?></th>
		<th><?php __('Ectc Credit'); ?></th>
		<th><?php __('Credit Hour'); ?></th>
		<th><?php __('Lecture Hours'); ?></th>
		<th><?php __('Tutorial Hours'); ?></th>
		<th><?php __('Course Status'); ?></th>
		<th><?php __('Course Description'); ?></th>
		<th><?php __('Course Objective'); ?></th>
		<th><?php __('Curriculum Id'); ?></th>
		<th><?php __('Laboratory Hours'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Lecture Attendance Requirement'); ?></th>
		<th><?php __('Lab Attendance Requirement'); ?></th>
		<th><?php __('Grade Type Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($weblink['Course'] as $course):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $course['id'];?></td>
			<td><?php echo $course['course_title'];?></td>
			<td><?php echo $course['course_code'];?></td>
			<td><?php echo $course['ectc_credit'];?></td>
			<td><?php echo $course['credit_hour'];?></td>
			<td><?php echo $course['lecture_hours'];?></td>
			<td><?php echo $course['tutorial_hours'];?></td>
			<td><?php echo $course['course_status'];?></td>
			<td><?php echo $course['course_description'];?></td>
			<td><?php echo $course['course_objective'];?></td>
			<td><?php echo $course['curriculum_id'];?></td>
			<td><?php echo $course['laboratory_hours'];?></td>
			<td><?php echo $course['department_id'];?></td>
			<td><?php echo $course['lecture_attendance_requirement'];?></td>
			<td><?php echo $course['lab_attendance_requirement'];?></td>
			<td><?php echo $course['grade_type_id'];?></td>
			<td><?php echo $course['created'];?></td>
			<td><?php echo $course['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'courses', 'action' => 'view', $course['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'courses', 'action' => 'edit', $course['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'courses', 'action' => 'delete', $course['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $course['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
