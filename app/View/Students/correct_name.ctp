<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title"> <?php echo __('Correct Name');?></h2>
     </div>
     <div class="box-body">
         <div class="row">
		    <div class="large-12 columns">

<div class="student form">
<?php echo $this->Form->create('Student');?>
<?php echo $this->Html->script('amharictyping'); ?> 

<p class="fs16">
           <strong> Important Note: </strong> 
           This tool will help you to correct student name. It is important when there is spell error. For legal change of name use change of name functionality. 
	
</p>
 <table>
  <tr>
	<td> 
	 <table> 
         <tr><td>First Name</td><td>
           <?php echo $this->Form->input('Student.first_name',array('label'=>false)); ?></td></tr>
           <tr><td>Middle Name</td><td> <?php echo $this->Form->input('Student.middle_name',array('label'=>false)); ?></td></tr>
           <tr><td>Last Name</td><td> <?php echo $this->Form->input('Student.last_name',array('label'=>false)); ?></td></tr>
	  </table>
      </td>
      <td>
         <table> 
         <tr><td>Amharic First Name</td><td>
           <?php echo $this->Form->input('Student.amharic_first_name',array('label'=>false)); ?></td></tr>
           <tr><td>Amharic Middle Name</td><td> <?php echo $this->Form->input('Student.amharic_middle_name',array('label'=>false)); ?></td></tr>
           <tr><td>Amharic Last Name</td><td> <?php echo $this->Form->input('Student.amharic_last_name',array('label'=>false)); 
echo $this->Form->input('id');

?></td></tr>
	  </table>
      </td>
    </tr>
</table>
<?php 

 echo $this->Form->submit('Update',array('name'=>'correctName','div'=>'false',
'class'=>'tiny radius button bg-blue'));
// echo $this->Form->end(__('Submit', true));
?>
</div>

</div>
</div>
</div>
</div>
