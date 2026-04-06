<div class="examGrades view">
<h2><?php  __('Exam Grade');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['grade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Registration'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examGrade['CourseRegistration']['id'], array('controller' => 'course_registrations', 'action' => 'view', $examGrade['CourseRegistration']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Makeup Exam'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examGrade['MakeupExam']['id'], array('controller' => 'makeup_exams', 'action' => 'view', $examGrade['MakeupExam']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department Approval'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['department_approval']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department Approval Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['department_approval_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department Approved By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['department_approved_by']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registrar Approval'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['registrar_approval']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registrar Approval Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['registrar_approval_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registrar Approved By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['registrar_approved_by']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examGrade['ExamGrade']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Exam Grade', true), array('action' => 'edit', $examGrade['ExamGrade']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Exam Grade', true), array('action' => 'delete', $examGrade['ExamGrade']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examGrade['ExamGrade']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Grades', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Grade', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Registrations', true), array('controller' => 'course_registrations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Registration', true), array('controller' => 'course_registrations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Makeup Exams', true), array('controller' => 'makeup_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Makeup Exam', true), array('controller' => 'makeup_exams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Grade Changes', true), array('controller' => 'exam_grade_changes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Grade Change', true), array('controller' => 'exam_grade_changes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Exam Grade Changes');?></h3>
	<?php if (!empty($examGrade['ExamGradeChange'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Exam Grade Id'); ?></th>
		<th><?php __('Grade'); ?></th>
		<th><?php __('Reason'); ?></th>
		<th><?php __('Minute Number'); ?></th>
		<th><?php __('Initiated By Department'); ?></th>
		<th><?php __('Department Approval'); ?></th>
		<th><?php __('Department Approval Date'); ?></th>
		<th><?php __('Department Approved By'); ?></th>
		<th><?php __('Registrar Approval'); ?></th>
		<th><?php __('Registrar Approval Date'); ?></th>
		<th><?php __('Registrar Approved By'); ?></th>
		<th><?php __('College Approval'); ?></th>
		<th><?php __('College Approval Date'); ?></th>
		<th><?php __('College Approved By'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($examGrade['ExamGradeChange'] as $examGradeChange):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $examGradeChange['id'];?></td>
			<td><?php echo $examGradeChange['exam_grade_id'];?></td>
			<td><?php echo $examGradeChange['grade'];?></td>
			<td><?php echo $examGradeChange['reason'];?></td>
			<td><?php echo $examGradeChange['minute_number'];?></td>
			<td><?php echo $examGradeChange['initiated_by_department'];?></td>
			<td><?php echo $examGradeChange['department_approval'];?></td>
			<td><?php echo $examGradeChange['department_approval_date'];?></td>
			<td><?php echo $examGradeChange['department_approved_by'];?></td>
			<td><?php echo $examGradeChange['registrar_approval'];?></td>
			<td><?php echo $examGradeChange['registrar_approval_date'];?></td>
			<td><?php echo $examGradeChange['registrar_approved_by'];?></td>
			<td><?php echo $examGradeChange['college_approval'];?></td>
			<td><?php echo $examGradeChange['college_approval_date'];?></td>
			<td><?php echo $examGradeChange['college_approved_by'];?></td>
			<td><?php echo $examGradeChange['created'];?></td>
			<td><?php echo $examGradeChange['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'exam_grade_changes', 'action' => 'view', $examGradeChange['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'exam_grade_changes', 'action' => 'edit', $examGradeChange['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'exam_grade_changes', 'action' => 'delete', $examGradeChange['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examGradeChange['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Exam Grade Change', true), array('controller' => 'exam_grade_changes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
