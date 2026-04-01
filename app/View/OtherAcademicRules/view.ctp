<div class="otherAcademicRules view">
<h2><?php echo __('Other Academic Rule'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Curriculum Id'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['curriculum_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Course Id'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['course_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Academic Statuse Id'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['academic_statuse_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Grade'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['grade']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number Courses'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['number_courses']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($otherAcademicRule['OtherAcademicRule']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Other Academic Rule'), array('action' => 'edit', $otherAcademicRule['OtherAcademicRule']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Other Academic Rule'), array('action' => 'delete', $otherAcademicRule['OtherAcademicRule']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $otherAcademicRule['OtherAcademicRule']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Other Academic Rules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Other Academic Rule'), array('action' => 'add')); ?> </li>
	</ul>
</div>
