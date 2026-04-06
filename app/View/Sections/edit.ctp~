<?php ?>
<div class="box">
  <div class="box-body">
	<div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Downgrade year level of section');?>
		      </h2>
		</div>
		<div class="large-12 columns">
<?php echo $this->Form->create('Section');?>
	<fieldset>
 	<legend><?php echo __('Edit Section'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('program_id');
		echo $this->Form->input('program_type_id');
		if(isset($this->request->data['Section']['department_id']) && !empty($this->request->data['Section']['department_id'])){
			echo $this->Form->input('department_id');
		} else if(isset($this->request->data['Section']['college_id']) && !empty($this->request->data['Section']['college_id'])){
			echo $this->Form->input('department_id');
		}
		echo $this->Form->hidden('year_level_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
		</div>
	 </div>
    </div>
</div>
