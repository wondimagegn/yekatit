<div class="countries form">
<?php echo $this->Form->create('Country');?>
	<div class="smallheading"> <?php __('Add Country'); ?> </div>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code',array('after'=>'E.g ET,NL,DE'));
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
