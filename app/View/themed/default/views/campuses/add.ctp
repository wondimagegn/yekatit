<div class="campuses form">
<?php echo $this->Form->create('Campus');?>
		<table><tbody>
		<tr><td><div class="smallheading"><?php __('Add Campus'); ?></div></td></tr>
	<?php
		echo "<tr><td>";
		echo $this->Form->input('name', array('style' => 'width:300px'));
		echo "</td></tr>";
	        echo "<tr><td>";
		echo $this->Form->input('description');
		echo "</td></tr>";
	?>
	
<?php 
echo "<tr><td>";
echo $this->Form->end(__('Submit', true));
echo "</td></tr>";
?>
</tbody></table>
</div>

