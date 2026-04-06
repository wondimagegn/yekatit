<div class="mealTypes form">
<?php echo $this->Form->create('MealType');?>
<div class="smallheading"><?php __('Add Meal Type'); ?></div>
	<?php
		echo $this->Form->input('meal_name');
	?>

<?php echo $this->Form->end(__('Submit', true));?>
</div>
