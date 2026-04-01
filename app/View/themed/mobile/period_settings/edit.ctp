<div class="periodSettings form">
<?php echo $this->Form->create('PeriodSetting');?>
<div class="smallheading"><?php __('Edit Period Setting'); ?></div>

	<?php
		echo "<div class='font'>".$college_name."</div>";
		echo $this->Form->input('id');
		//echo $this->Form->input('college_id');
		echo $this->Form->input('period',array('readonly'=>true));
		echo $this->Form->input('hour');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
