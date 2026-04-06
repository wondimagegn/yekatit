<div class="onlineApplicants form">
<?php echo $this->Form->create('OnlineApplicant'); ?>
	<fieldset>
		<legend><?php echo __('Add Online Applicant'); ?></legend>
	<?php
		echo $this->Form->input('applicationnumber');
		echo $this->Form->input('college_id');
		echo $this->Form->input('department_id');
		echo $this->Form->input('program_id');
		echo $this->Form->input('program_type_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('undergraduate_university_name');
		echo $this->Form->input('undergraduate_university_cgpa');
		echo $this->Form->input('undergraduate_university_field_of_study');
		echo $this->Form->input('postgraduate_university_name');
		echo $this->Form->input('postgraduate_university_cgpa');
		echo $this->Form->input('postgraduate_university_field_of_study');
		echo $this->Form->input('financial_support');
		echo $this->Form->input('name_of_sponsor');
		echo $this->Form->input('disability');
		echo $this->Form->input('first_name');
		echo $this->Form->input('father_name');
		echo $this->Form->input('grand_father_name');
		echo $this->Form->input('date_of_birth');
		echo $this->Form->input('gender');
		echo $this->Form->input('mobile_phone');
		echo $this->Form->input('email');
		echo $this->Form->input('application_status');
		echo $this->Form->input('approved_by');
		echo $this->Form->input('document_submitted');
		echo $this->Form->input('entrance_result');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Online Applicants'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Colleges'), array('controller' => 'colleges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New College'), array('controller' => 'colleges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Departments'), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department'), array('controller' => 'departments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Programs'), array('controller' => 'programs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program'), array('controller' => 'programs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types'), array('controller' => 'program_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type'), array('controller' => 'program_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
