<div class="classRooms form">
<?php echo $this->Form->create('ClassRoom');?>
	<fieldset>
 		<legend><?php __('Add Class Room'); ?></legend>
	<?php
		echo $this->Form->input('class_room_block_id');
		echo $this->Form->input('room_code');
		echo $this->Form->input('available_for_lecture');
		echo $this->Form->input('available_for_exam');
		echo $this->Form->input('lecture_capacity');
		echo $this->Form->input('exam_capacity');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
