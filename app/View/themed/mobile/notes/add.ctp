<div class="notes form">
<?php echo $this->Form->create('Note');?>
	<fieldset>
		<legend><?php __('Add Note'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('content',array('label'=>"Description"));
		echo $this->Form->input('college_id');
		echo "<br/>";
		$from = date('Y') - Configure::read('Calendar.yearsInPast');
        $to = date('Y') + Configure::read('Calendar.yearsAhead');
        $format = Configure::read('Calendar.dateFormat');
		echo $this->Form->input('department_id');
		echo "<br/>";
		echo $this->Form->input('published_date',array('dateFormat'=>$format,'minYear'=>$from,'maxYear'=>$to));
		echo "<br/>";
		echo $this->Form->input('start_date');
		echo "<br/>";
		echo $this->Form->input('end_date');
		echo "<br/>";
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Notes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Colleges', true), array('controller' => 'colleges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New College', true), array('controller' => 'colleges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
