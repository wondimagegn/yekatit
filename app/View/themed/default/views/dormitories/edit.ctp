<div class="dormitories form">
<?php echo $this->Form->create('Dormitory');?>
	<div class='smallheading'><?php __('Edit Dormitory'); ?></div>
	<table>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->hidden('dormitory_block_id');
		echo "<tr><td>".$this->Form->input('dorm_number')."</td>";
		echo "<td>".$this->Form->input('floor',array('type'=>'select','options'=>$floor_data))."</td></tr>";
		echo "<tr><td>".$this->Form->input('capacity')."</td>";
		echo "<td>".$this->Form->input('available')."</td></tr>";
		echo "<tr><td colspan='2'>".$this->Form->end(__('Submit', true))."</td></tr>";
	?>
	</table>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Dormitory Blocks', true), array('controller' => 'dormitory_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dormitory Block', true), array('controller' => 'dormitory_blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
