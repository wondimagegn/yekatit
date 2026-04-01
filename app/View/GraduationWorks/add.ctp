<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php echo $this->Form->create('GraduationWork');?>
<?php 
$graduation_work = Configure::read('Graduation.graduation_work');
?>

<?php 
if (!isset($studentIDs)) {

?>
<table cellpadding="0" cellspacing="0">
<?php 	
        echo '<tr><td class="smallheading">Maintain Graduation Work of Student </td></tr>';
        
		echo '<tr><td class="font">'.$this->Form->input('Search.studentID',array('label' => 'Student ID/Number')).'</td></tr>';
       echo '<tr><td>'. $this->Form->Submit('Continue',array('name'=>'continue','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>';
?>
</table>
<?php 
}
if (isset($studentIDs)) {
        $from = date('Y') - 5;
        $to = date('Y') + 1;
        echo '<table>';
        echo '<tr>';
        echo '<td>';
             echo $this->element('student_basic');
          
        echo '</td>';
        echo '<td>';
                echo '<table >';
               
                echo "<tr>";
                
                if (!empty($this->request->data['GraduationWork']['id'])) {
                    echo $this->Form->hidden('GraduationWork.id');
                }
                 
                echo $this->Form->hidden('GraduationWork.student_id',
                 array('value'=> $student_section_exam_status['StudentBasicInfo']['id']));
               
                echo '<td>Course</td>';
                echo '<td>'.$this->Form->input('GraduationWork.course_id',array('style'=>'width:200px','label'=>false,'options' => $courses)).'</td>';
		        echo '</tr>';
                echo "<tr>";
                echo '<td>Type</td>';
                 echo '<td>'.$this->Form->input('GraduationWork.type',array('label'=>false,
                      'options'=>$graduation_work,'type'=>'select')).'</td>';
           
		        echo '</tr>';
		        
		        echo '<td>Title</td>';
		        
                    echo '<td>'.$this->Form->input('GraduationWork.title',array('label'=>false)).'</td>';
		       
		        echo '</tr>';
		      echo '</table>';
		        ?>
	            <?php 
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		
		echo "<tr><td>".$this->Form->Submit('Save',array('name'=>'saveGraduationWork','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>';
		echo '</table>';
}
echo $this->Form->end();
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
