<?php ?>
<script type='text/javascript'>
function toggleViewFullId(id) {
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}
//Sub cat combo
</script>

<div class="student form">
<?php echo $this->Form->create('Student');?>
<?php echo $this->Html->script('amharictyping'); ?> 


<p class="fs16">
           <strong> Important Note: </strong> 
           This tool will help you to change  student name. It is important when there is legal change of name. 
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (isset($this->data['StudentNameHistory']) && 
	!empty($this->data['StudentNameHistory'])) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (isset($this->data['StudentNameHistory']) ? 'none' : 'display'); ?>">
<table cellpadding="0" cellspacing="0">
            <tr> 
	        <?php 
            
                 echo '<tr><td>'. $this->Form->input('Student.studentnumber',array('label'=>'Student ID')).'</td>'; 
           
            ?>
	        </tr>
	        
	        <tr>
	            <td colspan=2>
	                <?php 
	                    echo $this->Form->submit('Continue',
	                    array('name'=>'searchStudentName','div'=>'false')); ?> 
	             </td>	
            </tr>
</table>

</div>

<div>
<?php 

if (!empty($this->data['StudentNameHistory'])) {
?>
 <table>
    <tr>
    <td>
    <table>
           <tr><td colspan=2 class="fs16">From</td></tr>
           <tr><td>First Name</td><td>
           <?php echo $this->Form->input('StudentNameHistory.from_first_name',array('label'=>false)); ?></td></tr>
           <tr><td>Middle Name</td><td> <?php echo $this->Form->input('StudentNameHistory.from_middle_name',array('label'=>false)); ?></td></tr>
           <tr><td>Last Name</td><td> <?php echo $this->Form->input('StudentNameHistory.from_last_name',array('label'=>false)); ?></td></tr>
           <tr><td>Amharic First Name</td><td><?php echo $this->Form->input('StudentNameHistory.from_amharic_first_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td>Amharic Middle Name</td><td><?php echo $this->Form->input('StudentNameHistory.from_amharic_middle_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td>Amharic Last Name</td><td><?php echo $this->Form->input('StudentNameHistory.from_amharic_last_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
	</table>
	</td>
	<td>
	  <table>
           <tr><td colspan=2 class="fs16">To</td></tr>
           <tr><td>First Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_first_name',array('label'=>false)); ?></td></tr>
           <tr><td>Middle Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_middle_name',array('label'=>false)); ?></td></tr>
           <tr><td>Last Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_last_name',array('label'=>false)); ?></td></tr>
           <tr><td> Amharic First Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_amharic_first_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td> Amharic Middle Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_amharic_middle_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td> Amharic Last Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_amharic_last_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
            <tr><td>Minute Number</td><td>
            <?php 
              echo $this->Form->input('StudentNameHistory.minute_number',array('label'=>false)); 
              echo $this->Form->hidden('StudentNameHistory.student_id',array('label'=>false)); 
            ?>
            
            </td></tr>
	</table>
	</td>
	</tr>
	</table>
<?php 
 echo $this->Form->submit('Change Name',array('name'=>'changeName',
                              'div'=>'false'));
// echo $this->Form->end(__('Submit', true));
}
?>

</div>
</div>
