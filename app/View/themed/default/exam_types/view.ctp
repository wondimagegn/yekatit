<div class="examTypes view">
<h2><?php  __('Exam Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examType['ExamType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Exam Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examType['ExamType']['exam_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Percent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examType['ExamType']['percent']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examType['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $examType['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examType['Section']['name'], array('controller' => 'sections', 'action' => 'view', $examType['Section']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examType['ExamType']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examType['ExamType']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Exam Type', true), array('action' => 'edit', $examType['ExamType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Exam Type', true), array('action' => 'delete', $examType['ExamType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examType['ExamType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Type', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Results', true), array('controller' => 'exam_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Result', true), array('controller' => 'exam_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Exam Results');?></h3>
	<?php if (!empty($examType['ExamResult'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Grade'); ?></th>
		<th><?php __('Grade Submission Date'); ?></th>
		<th><?php __('Exam Type Id'); ?></th>
		<th><?php __('Course Registration Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($examType['ExamResult'] as $examResult):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $examResult['id'];?></td>
			<td><?php echo $examResult['grade'];?></td>
			<td><?php echo $examResult['grade_submission_date'];?></td>
			<td><?php echo $examResult['exam_type_id'];?></td>
			<td><?php echo $examResult['course_registration_id'];?></td>
			<td><?php echo $examResult['created'];?></td>
			<td><?php echo $examResult['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'exam_results', 'action' => 'view', $examResult['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'exam_results', 'action' => 'edit', $examResult['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'exam_results', 'action' => 'delete', $examResult['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examResult['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Exam Result', true), array('controller' => 'exam_results', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
