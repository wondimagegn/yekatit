<div class="row">
	<div class="large-12 columns">
		<?php

		if (!empty($sectionOrganized)) { ?>
		<?php echo $this->Form->create('Section', array('action' => 'add_student_prev_section', "method" => "POST"));
			echo '<h3>' . $student_detail['Student']['first_name'] . ' ' . $student_detail['Student']['middle_name'] . ' ' . $student_detail['Student']['last_name'] . '(' . $student_detail['Student']['studentnumber'] . ')' . '</h3>';
			echo '<table>';

			echo '<tr><td>' . $this->Form->input('Section.year_level_id', array(
				'label' => 'Select Year Level.', 'empty' => '--Select Year Level of Section--', 'id' => 'year_level_id',
				'onchange' => 'updateSection("' . $student_detail['Student']['id'] . '")'
			)) . '</td></tr>';
			/*
	echo '<tr>';
		echo '<th>Section</th>';
		echo '<th>Academic Year</th>';
	echo '</tr>';
	
	foreach($sectionOrganized as $k=>$v) {
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
	*/
			echo '</table>';
			echo '<div id="SectionList"></div>';

			echo $this->Form->hidden(
				'Selected_student_id',
				array('value' => $student_detail['Student']['id'])
			);
			/*
	  echo $this->Form->input('section_id',array('label'=>'Section','type'=>'select',
       'options'=>$sections,'empty'=>"--Select Section--"));
*/
		} else {
			echo '<h4> You can not  add ' . $student_detail['Student']['first_name'] . ' ' . $student_detail['Student']['middle_name'] . ' ' . $student_detail['Student']['last_name'] . '(' . $student_detail['Student']['studentnumber'] . ') to section since s/he has already in the section' . '</h4>';
		}
		?>
	</div>
</div>
<a class="close-reveal-modal">&#215;</a>

<script>
	//Sub cat combo
	function updateSection(studentId) {

		//serialize form data
		var formData = $("#year_level_id").val();
		$("#year_level_id").attr('disabled', true);
		$("#Add_To_Section_Button").attr('disabled', true);

		//get form action
		var formUrl = '/sections/get_sections_by_year_level/' + formData + '/' + studentId;
		$.ajax({
			type: 'get',
			url: formUrl,
			data: formData,
			success: function(data, textStatus, xhr) {
				$("#year_level_id").attr('disabled', false);
				$("#Add_To_Section_Button").attr('disabled', false);
				$("#SectionList").empty();
				$("#SectionList").append(data);


			},
			error: function(xhr, textStatus, error) {
				alert(textStatus);
			}
		});

		return false;

	}
</script>