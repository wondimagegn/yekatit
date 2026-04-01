<?php 
echo '<table>';

    
	echo '<tr>';
		echo '<th>Section</th>';
		echo '<th>Academic Year</th>';
	echo '</tr>';
	
	foreach($sections as $k=>$v) {
	  echo '<tr>';
		   echo '<td>';
			if(!empty($v['YearLevel']['name'])) {
           echo $this->Form->input('Section.assigned_section.'.$v['Section']['id'],array('type'=>'checkbox','value'=>$v['Section']['id'],'label'=>$v['Section']['name'].'('.$v['YearLevel']['name'].')'));
		    } else {
                echo $this->Form->input('Section.assigned_section.'.$v['Section']['id'],array('type'=>'checkbox','value'=>$v['Section']['id'],'label'=>$v['Section']['name'].'(1st)'));
			}
			echo '</td>';
			echo '<td>';
            echo $v['Section']['academicyear'];
	
			echo '</td>';
	  echo '</tr>';
	}
	
	echo '</table>';

echo $this->Form->end('Add to Selected Section',array('id'=>'Add_To_Section_Button'));
?>
