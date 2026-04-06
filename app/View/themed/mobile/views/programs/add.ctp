<div class="programs form">
<?php echo $this->Form->create('Program');?>
<table><tbody>	
		<tr><td><div class="smallheading"><?php __('Add Program'); ?></div> </td></tr>
	
	<?php
		echo "<tr><td>".$this->Form->input('name')."</td></tr>";
		echo "<tr><td>".$this->Form->input('description')."</td></tr>";
		echo "<tr><td>".$this->Form->end(__('Add', true))."</td></tr>";
	?>
</tbody>
</table>
</div>

