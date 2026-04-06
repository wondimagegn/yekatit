<div class="programs form">
<?php echo $this->Form->create('Program');?>
<table><tbody>	
		<tr><td><div class="smallheading"><?php __('Edit Program'); ?></div> </td></tr>
	
	<?php
	    echo $this->Form->input('id');
		echo "<tr><td>".$this->Form->input('name')."</td></tr>";
		echo "<tr><td>".$this->Form->input('description')."</td></tr>";
		echo "<tr><td>".$this->Form->end(__('Update', true))."</td></tr>";
	?>
</tbody>
</table>
</div>

