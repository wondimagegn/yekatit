<div class="mergedSectionsExams form">

<?php echo $this->Form->create('MergedSectionsExam');  ?>
<div class="smallheading"><?php __('Merge Sections For Exam'); ?></div>
	<div class="font"><?php echo 'Colege/Institute: '.$college_name ?></div>

<table cellpadding="0" cellspacing="0">
	<?php 
       	echo '<tr><td class="font"> Program</td>';
        echo '<td>'. $this->Form->input('program_id',array('label'=>false,'empty'=>"--Select Program--", 'style'=>'width:200PX')).'</td>'; 
        echo '<td class="font"> Program Type</td>';
        echo '<td>'. $this->Form->input('program_type_id',array('label'=>false,'empty'=>"--Select Program Type--",'style'=>'width:200PX')).'</td>'; 
        echo '<td class="font"> Semester</td>';
		echo '<td>'.$this->Form->input('semester',array('label'=>false,'options'=>array('I'=>'I','II'=>'II','III'=>'III'),'empty'=>'--select semester--','style'=>'width:200PX')).'</td></tr>'; 
        echo '<tr><td colspan="6">'. $this->Form->Submit('Search',array('name'=>'search','div'=>false)).'</td></tr>'; 
	?> 
</table>
 <?php 
 if(!empty($formatedSections)){
        
    ?>
    <table style="width:100%;">
    <?php 
	foreach($formatedSections as $sk=>$sections){
	?>
		<tr><td><div class="smallheading"><?php __('Year Level: '.$sk); ?></div></td></tr>
	<?php 
		$section_list_name=null;
        foreach($sections as $key=>$value) {
            //echo $this->Form->hidden('Section.'.$key.'.id', array('value'=>$value['Section']['id']));
            $section_list_name=$value['Section']['name'];
			
			echo '<tr><td>'.$this->Form->input('Section.selected.'.$value['Section']['id'], array('class'=>'mergedSection','label'=>$section_list_name,'type'=>'checkbox','value'=>$value['Section']['id'])).'</td></tr>';
		}
	}
		echo $this->Js->get("input.mergedSection")->event("change", $this->Js->request(array('controller'=>'publishedCourses',
			'action'=>'getPublishedCoursesForExam'), array(
						'update'=>"#PublishedCoursesList",
						'async' => true,
						'method' => 'post',
						'dataExpression'=>true,
						'data'=> $this->Js->serializeForm(array(
						'isForm' => false,
						'inline' => true
			))
		))
	);
			
        //echo '<td style="vertical-align:middle; "><table><tr><td>'. $this->Form->input('new_section_name').'</td></tr>';

        //echo '</table></td>';
		
		//renderElement() //depricated
		//if (isset($element)) {
			echo "<tr><td><div id='PublishedCoursesList'></div></td></tr>";	
		//} else {
			//echo $this->element('list_published_course');
		//}
		//echo '<tr><td>'. $this->Form->input('merged_section_name').'</td></tr>';
       // echo '<tr><td >'. $this->Form->Submit('Merge',array('name'=>'merge','div'=>false)).'</td></tr>';
        
    ?>
	
	</table>
<?php 
} else if(empty($formatedSections) && !($isbeforesearch)){
    echo "<div class='info-box info-message'><span></span>No section is found with the search criteria</div>";
}
?>
</div>

<script type="text/javascript">

  $(document).ready(function() { 
  
 
    $(".mergedSection").each( function() {
            if ($(this).is(":checked")){
               $('#PublishedCoursesList').load('/publishedCourses/getPublishedCoursesForExam/2');
               // return true;
               //alert("<?php echo $this->data;?>")
           }
    })
    
  /*
        if ($(".mergedSection:checked"))
        {
          
            alert('checked');
        }
    */ 
  }); 
</script>

<?php echo $this->Form->end();     ?>
