<?php
	echo $this->Form->create('Section');  
    echo "<div class='font'>".$collegename."</div>";
   //Display department name if user role is not college
    if(ROLE_COLLEGE != $role_id ){
        echo "<div class='font'>"."Department of ".$departmentname."</div>";
    }
?>
<table cellpadding="0" cellspacing="0">
	<?php 
       
        echo '<tr><td width="250PX">'. $this->Form->input('Section.program_id',array('empty'=>"--Select Program--")).'</td>'; 
        echo '<td width="400PX">'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--")).'</td>'; 
        if(ROLE_COLLEGE != $role_id ) {  
            echo '<td width="250PX">'. $this->Form->input('Section.year_level_id',array('empty'=>'All')).'</td>'; 
        }
		echo '</tr>';
        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','div'=>false)).'</td></tr>'; 
	?> 
</table>
<?php 
	if(!empty($sections)){
?>
<table><tr>
    <?php
    foreach($studentsections as $k=>$studentsection){ 
    $students_per_section=count($studentsection['Student']);
        echo '<table style="border: #CCC solid 1px"><tr><td></td>';
        echo '<td colspan="2" style="text-align: center;font-size:16px;font-weight:bold;vertical-align:middle;">'.
            "Section: ".$studentsection['Section']['name'].'</td>';
        echo '<td style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        $this->Html->link($this->Html->image("/img/xls-icon.gif",array("alt"=>"Export TO Excel")), 
        array('action' => 'export',$studentsection['Section']['id']),array('escape'=>false))."Export";
        echo $this->Html->link($this->Html->image("/img/pdf_icon.gif",array("alt"=>"Print To Pdf")), 
        array('action' => 'view_pdf', $studentsection['Section']['id']),array('escape'=>false))."Print".'</td></tr>';
        echo '<tr><td colspan="2" class="font">'. "Currently hosted: " .$current_sections_occupation[$k]." students" .'</td>';
		echo '<td colspan="2" class="font">'. "Section of Students Curriculum: " .$sections_curriculum_name[$k].'</td></tr>';
        echo '<tr><th style="border-right: #CCC solid 1px">'. "No ".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "Students Identification ".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "Students Name ".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "Action ".'</th></tr>';
        $counter=1;
        for($i=0;$i<$students_per_section;$i++) {
			if($studentsection['Student'][$i]['StudentsSection']['archive'] == 0) {
            echo '<tr><td style="border-right: #CCC solid 1px">'.$counter++.'</td>';
            echo '<td style="border-right: #CCC solid 1px">'.
            $this->Html->link( $studentsection['Student'][$i]['studentnumber'], array('controller' => 'students', 'action' => 'student_academic_profile',  $studentsection['Student'][$i]['id']))
           .'</td>';
            
            
            echo '<td style="border-right: #CCC solid 1px">'.
            
             $this->Html->link($studentsection['Student'][$i]['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile',  $studentsection['Student'][$i]['id']))
            .'</td>';
			echo '<td id="ajax_student_'.$i.'_'.$k.'">'.$this->Js->link(__('Move', true),'/sections/move/'.str_replace('/','-',$studentsection['Student']
			[$i]['studentnumber']).'/'.$studentsection['Section']['id']
			, array('update'=>'#ajax_student_'.$i.'_'.$k,'evalScripts'=>true)).'&nbsp;&nbsp;'.
                $this->Html->link(__('Delete', true), array('controller'=>'Sections',
                'action' => 'deleteStudentforThisSection', $studentsection['Section']['id'], str_replace('/','-',
				$studentsection['Student'][$i]['studentnumber'])),null, sprintf(__('Are you sure you want to delete %s?', true),
				$studentsection['Student'][$i]['full_name'], str_replace('/','-',$studentsection['Student'][$i]['studentnumber']))).'</td></tr>';
        }
		}
            echo '<tr><td colspan="4" style="text-align: center;" id="ajax_student_'.$k.'">'.$this->Js->link(__('Add', true),
			'/sections/add_student_section/'.$studentsection['Section']['id'],array('update'=>'#ajax_student_'.$k,'evalScripts'=>true)).
			'</td></tr>';
        echo '</table>';
    }
    ?>
 </tr></table>
<?php 
} else if(empty($sections) && !($isbeforesearch)){
    echo "<div class='info-box info-message'><span></span>No section is found with the search criteria</div>";
}
$this->Form->end(); 
?>
