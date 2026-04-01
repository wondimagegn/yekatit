<div class="mealHalls form">
<?php echo $this->Form->create('MealHall');?>
		<div class="smallheading"><?php __('Edit Meal Hall'); ?></div>
	<table>
	<?php
		echo $this->Form->input('id');
		echo "<tr><td>".$this->Form->input('campus_id', array('disabled'=>true))."</td>";
		echo "<td>".$this->Form->input('name')."</td></tr>";
		echo "<tr><td colspan='2'>".$this->Form->end(__('Submit', true))."</td></tr>"; 
	?>
	</table>
</div>
