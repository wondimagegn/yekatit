<!---
<div class="disciplines form">
<?php echo $this->Form->create('Discipline');?>
	<fieldset>
		<legend><?php __('Add Discipline'); ?></legend>
	<?php
		echo $this->Form->input('student_id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Disciplines', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>
--->

<div class="disciplines form">
<?php echo $this->Form->create('Discipline');?>
<?php 
    if (!isset($studentIDs)) {

?>
<table cellpadding="0" cellspacing="0">
<?php 	
        echo '<tr><td class="smallheading">Add  Discipline Case </td></tr>';
      
		echo '<tr><td class="font">'.$this->Form->input('Search.studentID',array('label' => 'Student ID')).'</td></tr>';
       echo '<tr><td>'. $this->Form->Submit('Continue',array('name'=>'continue','div'=>false)).'</td></tr>';
?>
</table>
<?php 
}
?>
<?php 
        if (isset($studentIDs)) {
?>
	<div class="smallheading"><?php __('Add  Discipline Detail'); ?></div>
	<table>
	<tr>
	    <td colspan=2>
	     <?php  echo $this->element('student_basic'); ?>
	    </td>
	</tr>
	    <tr>
	     <td colspan="2">
	        <table>
	           <tr>
	               <td class="fs16">
	                 <?php 
	                    __('Provide the displine case for  the selected student.'); 
	                 ?>
	               </td>
	           </tr>
	            <?php
		            echo $this->Form->hidden('Discipline.student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
		            echo '<tr>';
		                echo '<td>'.$this->Form->input('Discipline.discipline_taken_date',array('label' =>'Discipline Date',  'minYear' => Configure::read('Calendar.applicationStartYear'), 'maxYear' => date('Y'), 'orderYear' => 'desc')).'</td>';
		               // echo '<td>'.$this->Form->input('taken_date',array('label' =>'Discipline Date')).'</td>';
		               
		            echo '</tr>'; 
		            echo '<tr>';
		                echo '<td>'.$this->Form->input('Discipline.title').'</td>';
		              
		
		               
		            echo '</tr>';
		            echo '<tr>';
		               echo '<td>'.$this->Form->input('Discipline.description').'</td>';
		              
		            echo '</tr>'; 
		          
		            
		            //
		         
	        ?>
	        </table>
	    
	    </td>
	 
	    </tr>
	 <tr><td> <?php echo $this->Form->Submit('Save',array('name'=>'saveDisplinceCase','div'=>false)); 
	 ?>
	 </td></tr>
	</table>
	
<?php 
}
?>
</div>
