<div class="makeupExams view">
<h2><?php  __('Makeup Exam');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $makeupExam['MakeupExam']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Minute Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $makeupExam['MakeupExam']['minute_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($makeupExam['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $makeupExam['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($makeupExam['Section']['name'], array('controller' => 'sections', 'action' => 'view', $makeupExam['Section']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($makeupExam['Student']['id'], array('controller' => 'students', 'action' => 'view', $makeupExam['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $makeupExam['MakeupExam']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $makeupExam['MakeupExam']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Makeup Exam', true), array('action' => 'edit', $makeupExam['MakeupExam']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Makeup Exam', true), array('action' => 'delete', $makeupExam['MakeupExam']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $makeupExam['MakeupExam']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Makeup Exams', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Makeup Exam', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Grades', true), array('controller' => 'exam_grades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Grade', true), array('controller' => 'exam_grades', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Exam Grades');?></h3>
	<?php if (!empty($makeupExam['ExamGrade'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Grade'); ?></th>
		<th><?php __('Course Registration Id'); ?></th>
		<th><?php __('Makeup Exam Id'); ?></th>
		<th><?php __('Department Approval'); ?></th>
		<th><?php __('Department Approval Date'); ?></th>
		<th><?php __('Department Approved By'); ?></th>
		<th><?php __('Registrar Approval'); ?></th>
		<th><?php __('Registrar Approval Date'); ?></th>
		<th><?php __('Registrar Approved By'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($makeupExam['ExamGrade'] as $examGrade):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $examGrade['id'];?></td>
			<td><?php echo $examGrade['grade'];?></td>
			<td><?php echo $examGrade['course_registration_id'];?></td>
			<td><?php echo $examGrade['makeup_exam_id'];?></td>
			<td><?php echo $examGrade['department_approval'];?></td>
			<td><?php echo $examGrade['department_approval_date'];?></td>
			<td><?php echo $examGrade['department_approved_by'];?></td>
			<td><?php echo $examGrade['registrar_approval'];?></td>
			<td><?php echo $examGrade['registrar_approval_date'];?></td>
			<td><?php echo $examGrade['registrar_approved_by'];?></td>
			<td><?php echo $examGrade['created'];?></td>
			<td><?php echo $examGrade['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'exam_grades', 'action' => 'view', $examGrade['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'exam_grades', 'action' => 'edit', $examGrade['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'exam_grades', 'action' => 'delete', $examGrade['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examGrade['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Exam Grade', true), array('controller' => 'exam_grades', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
