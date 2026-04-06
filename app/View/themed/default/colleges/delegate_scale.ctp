<div class="colleges form">
<?php echo $this->Form->create('College');
if (!empty($this->data)) {
?>
<div style='padding-top:10px' class="smallheading">
    <?php 
		__('Delegate scale setting for all departments of your college.'); 
		
    ?>
</div>
<div style='padding-top:10px;padding-bottom:10px;font-size:15px'>
<strong>Campus:<?php echo $this->data['Campus']['name']?></strong><br/>
<strong>College:<?php echo $this->data['College']['name']?></strong><br/>
<strong>
<?php 
		echo __('Delegatation of scale setting will apply for the department listed below.',true); 
?>
</strong>
</div>

<table>
<tr><td>
<table>
        
	<?php
	    echo $this->Form->hidden('id',array('value'=>$this->data['College']['id']));
	    if(!empty($this->data)) {
	        foreach ($this->data['Department'] as $department_id=>$department_name) {
	          echo "<tr><td>".$department_name['name']."</td></tr>";
	        }
	    }
		/*
		echo "<tr><td>".$this->Form->input('deligate_scale',array('after'=>'Delegate.Check if you want to delegate scale setting to the department for undergraduate study. Uncheck if you want all departments listed above to be abide by the scale set by college.','class'=>'fs16'))."</td></tr>";
	 	*/
	?>	

</table>
</td>
<td style='vertical-align:top;'>
 <?php
        echo '<table>'; 
   	 	echo "<tr><td>".$this->Form->input('deligate_scale',array('after'=>'Delegate undergraduate grade scale.','class'=>'fs16','label'=>false))."</td></tr>";
	 	
	 	echo "<tr><td>".$this->Form->input('deligate_for_graduate_study',array('after'=>'Delegate post graduate grade scale.','class'=>'fs16','label'=>false))."</td></tr>";
		echo "<tr><td>".$this->Form->end(__('Update', true))."</td></tr>";
		echo '</table>';

 ?>
</td>
</tr>
</table>
<?php 
}
?>
</div>
