<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php
			    echo "<div class='font'>".$collegename."</div>";
			   //Display department name if user role is not college
			    if(ROLE_COLLEGE != $role_id ){
				echo "<div class='font'>"."Department of ".$departmentname."</div>";
			    }
                         ?>
		      </h2>
		</div>
		<div class="large-12 columns">
		<?php  
echo $this->Form->create('Section');  
?>
         <table cellpadding="0" cellspacing="0">
	<?php 
       
        echo '<tr><td width="250PX">'. $this->Form->input('Section.program_id',array('empty'=>"--Select Program--",'required')).'</td>'; 
        echo '<td width="400PX">'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--",'required')).'</td>'; 
        if(ROLE_COLLEGE != $role_id ) {  
            echo '<td width="250PX">'. $this->Form->input('Section.year_level_id',array('empty'=>'--Select year level--')).'</td>'; 
        }
		echo '</tr>';
      
        echo '<tr><td colspan="3">'. $this->Form->input('Section.academicyear',
array('options'=>$acyear_array_data,'required')).'</td></tr>'; 

        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>'; 
	?> 
</table>

	     </div>
	     <div class="large-12 columns">
            
<?php 

	if(!empty($sections)){
             /*
			echo '<table>';
			  echo '<tr><td colspan="2">Do you want to swap students ?</td></tr>';
		    echo '<tr><td>'. $this->Form->input('Section.swap',array('div'=>false,'options'=>$swapOptions,'label'=>'By')).'</td>';
		  echo '<td>'. $this->Form->Submit('Swap',array('name'=>'swapStudentSection','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr></table>'; */

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


			echo '<td id="ajax_student_'.$i.'_'.$k.'">'.$this->Html->link(
    'Move',
    '#',
   array('data-animation'=>"fade",
'data-reveal-id'=>'myModalMove','data-reveal-ajax'=>'/sections/move/'.str_replace('/','-',$studentsection['Student'][$i]['studentnumber']).'/'.$studentsection['Section']['id'])
).'&nbsp;&nbsp;'.
                $this->Html->link(__('Delete'), array('controller'=>'Sections',
                'action' => 'deleteStudentforThisSection', $studentsection['Section']['id'], str_replace('/','-',
				$studentsection['Student'][$i]['studentnumber'])),null, sprintf(__('Are you sure you want to delete %s?'),
				$studentsection['Student'][$i]['full_name'], str_replace('/','-',$studentsection['Student'][$i]['studentnumber']))).'</td></tr>';
        }
		}
        
     echo '<tr><td colspan="2">'.$this->Html->link(
    'Move',
    '#',
   array('data-animation'=>"fade",
'data-reveal-id'=>'myModalAdd','data-reveal-ajax'=>'/sections/move_selected_student_section/'.$studentsection['Section']['id'])).'</td><td colspan="2" style="text-align: center;" id="ajax_student_'.$k.'">'.$this->Html->link(
    'Add',
    '#',
   array('data-animation'=>"fade",
'data-reveal-id'=>'myModalAdd','data-reveal-ajax'=>'/sections/add_student_section/'.$studentsection['Section']['id'])).'</td></tr>';


        echo '</table>';
    }
    ?>
 </tr></table>
<?php 
} else if(empty($sections) && !($isbeforesearch)){
    echo "<div class='info-box info-message'><span></span>No section is found with the search criteria</div>";
}
?>
	     </div>
	</div>
     </div>
</div>
<div class="box">
     <div class="box-body">
            <div class="row">
            	<div class="large-12 columns">
            		<div id="myModalMove" class="reveal-modal" data-reveal>

            		</div>

            		<div id="myModalAdd" class="reveal-modal" data-reveal>

            		</div>
            	</div>
            </div>
    </div>
</div>
<?php 
echo $this->Form->end(); 
?>
