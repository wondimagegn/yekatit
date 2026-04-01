<script language="javascript">
var totalRow = <?php if(!empty($this->request->data)) echo (count($this->request->data['ExamType'])); else if(!empty($exam_types)) echo (count($exam_types)); else echo 2; ?>;

function updateSequence(tableID) {
	var s_count = 1;
	for(i = 1; i < document.getElementById(tableID).rows.length; i++) {
		document.getElementById(tableID).rows[i].cells[0].childNodes[0].data = s_count++;
	}
}

function addRow(tableID,model,no_of_fields,all_fields) {
	var elementArray = all_fields.split(',');
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	totalRow++;
	row.id = model+'_'+totalRow;
	var cell0 = row.insertCell(0);
	cell0.innerHTML = rowCount;
	//construct the other cells
	for(var j=1;j<=no_of_fields;j++) {
		var cell = row.insertCell(j);
		
		if (elementArray[j-1] == 'exam_name') {
		   var element = document.createElement("input");
		   //element.size = "4";
		   element.type = "text";
		
		} else if (elementArray[j-1] == 'percent') {
			   var element = document.createElement("input");
			   element.style.width = "75px";
			   element.type = "text";
			   element.maxLength = 5;
		} else if (elementArray[j-1] == 'order') {
			   var element = document.createElement("input");
			   element.style.width = "75px";
			   element.type = "text";
			   element.maxLength = 2;
			   
		} else if (elementArray[j-1] == 'mandatory') {
			   var element = document.createElement("input");
			   element.type = "checkbox";
			   element.value = "1";
		} else if (elementArray[j-1] == 'edit') {
			   var element = document.createElement("a");
			   element.innerText = "Delete";
			   element.textContent = "Delete";
			   element.setAttribute('href','javascript:deleteSpecificRow(\''+model+'_'+totalRow+'\')');
		}
		
		element.name = "data["+model+"]["+rowCount+"]["+elementArray[j-1]+"]";
		cell.appendChild(element);
	}
	updateSequence(tableID);
}

function deleteRow(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		if(rowCount >2 ){
			table.deleteRow(rowCount-1);
			updateSequence(tableID);
		} else {
			alert('No more rows to delete');
		}
	}catch(e) {
		alert(e);
	}
}

function deleteSpecificRow(id) {
	try {
		var row = document.getElementById(id);
		//var table = row.parentElement;
		var table = row.parentNode;
		if(table.rows.length > 2 ){
			row.parentNode.removeChild(row);
			updateSequence('exam_setup');
			//row.parentElement.removeChild(row);
		} else {
			alert('There must be at least one exam type.');
		}
	}catch(e) {
		alert(e);
	}
}
</script>
<script type="text/javascript">
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

$(document).ready(function () {
	$("#PublishedCourse").change(function(){
		//serialize form data
		var pc = $("#PublishedCourse").val();
		$("#ExamSetupDiv").empty();
		$("#ExamSetupDiv").append('<p>Loading ...</p>');
		//get form action
		var formUrl = '/examTypes/get_exam_type_entry_form/'+pc;
		$.ajax({
			type: 'get',
			url: formUrl,
			data: pc,
			success: function(data,textStatus,xhr){
					$("#ExamSetupDiv").empty();
					$("#ExamSetupDiv").append(data);
			},
			error: function(xhr,textStatus,error){
					alert(textStatus);
			}
		});
		
		return false;
	});
});
</script>
<div class="examTypes index">
<?php echo $this->Form->create('ExamType'); ?>
<div class="smallheading"><?php echo __('Course Exam Setup Management');?></div>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($publishedCourses)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (!empty($publishedCourses) ? 'none' : 'display'); ?>">
<table cellspacing="0" cellpadding="0" class="fs14">
	<tr>
		<td style="width:15%">Acadamic Year:</td>
		<td style="width:25%"><?php 
		$options = array();
		$options =  array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => $defaultacademicyear);
		if(isset($acadamic_year))
			$options['default'] = $acadamic_year;
		echo $this->Form->input('acadamic_year', $options);
		?></td>
		<td style="width:15%">Semester:</td>
		<td style="width:55%"><?php 
			$options = array();
			$options = array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'));
			if(isset($semester))
				$options['default'] = $semester;			
			echo $this->Form->input('semester', $options); 
		?></td>
	</tr>
	<tr>
		<td>Program:</td>
		<td><?php 
			$options = array();
			$options = array('id' => 'Program', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $programs);
			if(isset($program_id))
				$options['default'] = $program_id;
			echo $this->Form->input('program_id', $options);
			?></td>
		<td>Program Type:</td>
		<td><?php 
			$options = array();
			$options = array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $program_types);
			if(isset($program_type_id))
				$options['default'] = $program_type_id;
			echo $this->Form->input('program_type_id', $options); ?></td>
	</tr>
	<tr>
		<td colspan="4">
		<?php echo $this->Form->submit(__('List Published Courses'), array('name' => 'listPublishedCourses', 'div' => false)); ?>
		</td>
	</tr>
</table>
</div>
<?php
if(!empty($publishedCourses)) {
?>
<table class="fs14">
	<tr>
		<td style="width:15%">Published Courses</td>
		<td colspan="3" style="width:85%">
<?php
	echo $this->Form->input('published_course_id', array('id' => 'PublishedCourse', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $publishedCourses, 'default' => $published_course_combo_id));
?>
		</td>
	</tr>
</table>
<?php
	}
?>
<?php
if(1||!empty($publishedCourses)) {
?>
<div id="ExamSetupDiv">
<?php echo $this->Form->input('edit', array('type' => 'hidden', 'value' => $edit));?>
<?php
//if(count($publishedCourses) > 0) {
if(!empty($published_course_combo_id)) {
	$input_disable = ($grade_submitted ? "disabled" : false);
	if(!$grade_submitted) {
	?>
	<p class="fs14">Please enter all the exam type for the course you selected with its weight in the given field, below.</p>
	<?php
	}
	else {
	?>
	<p class="fs14">Exam grade is already submited and you can not apply changes on the exam setup.</p>
	<?php
	}
	?>
	<table cellspacing="0" cellpadding="0" id="exam_setup" style="margin-bottom:5px">
		<tr>
			<th style="width:5%">No</th>
			<th style="width:25%">Exam Type</th>
			<th style="width:20%">In Percent</th>
			<th style="width:20%">Order</th>
			<th style="width:10%">Mandatory</th>
			<th style="width:20%">&nbsp;</th>
		</tr>
		<?php
		if(empty($this->request->data)) {
			if(empty($exam_types)) {
				?>
				<tr id="ExamType_1">
					<td style="vertical-align:middle">1</td>
					<td><?php echo $this->Form->input('ExamType.1.exam_name', array('label' => false, 'disabled' => $input_disable));?></td>
					<td><?php echo $this->Form->input('ExamType.1.percent', array('maxlength' => '5','label' => false, 'style' => 'width:75px'));?></td>
					<td><?php echo $this->Form->input('ExamType.1.order', array('maxlength' => '2','type' => 'text', 'label' => false, 'maxlength' => '2', 'style' => 'width:75px'));?></td>
					<td><?php echo $this->Form->input('ExamType.1.mandatory', array('value' => 1, 'label' => false));?></td>
					<td><a href="javascript:deleteSpecificRow('ExamType_1')">Delete</a></td>
				</tr>
				<?php
				}
			else {
				$count = 0;
				foreach($exam_types as $key => $exam_type) {
					?>
					<tr id="ExamType_<?php echo ++$count; ?>">
						<td style="vertical-align:middle"><?php echo $count; ?></td>
						<td><?php echo $this->Form->input('ExamType.'.$count.'.id', array('type' => 'hidden', 'value' => $exam_type['ExamType']['id']));?>
							<?php echo $this->Form->input('ExamType.'.$count.'.exam_name', array('value' => $exam_type['ExamType']['exam_name'], 'label' => false, 'disabled' => $input_disable));?></td>
						<td><?php echo $this->Form->input('ExamType.'.$count.'.percent', array('maxlength' => '5', 'value' => $exam_type['ExamType']['percent'], 'label' => false, 'style' => 'width:75px', 'disabled' => $input_disable));?></td>
						<td><?php echo $this->Form->input('ExamType.'.$count.'.order', array('maxlength' => '2', 'type' => 'text', 'value' => ($exam_type['ExamType']['order'] != 0 ? $exam_type['ExamType']['order'] : ''), 'label' => false, 'maxlength' => '2', 'style' => 'width:75px', 'disabled' => $input_disable));?></td>
						<td><?php
						$coptions = array();
						$coptions['value'] = 1;
						$coptions['label'] = false;
						$coptions['disabled'] = $input_disable;
						if($exam_type['ExamType']['mandatory'] == 1)
							$coptions['checked'] = 'checked';
						echo $this->Form->input('ExamType.'.$count.'.mandatory', $coptions);?></td>
						<td><?php if(!$grade_submitted) { ?><a href="javascript:deleteSpecificRow('ExamType_<?php echo $count; ?>')">Delete</a><?php } ?></td>
					</tr>
					<?php
				}
			$count++;
			}
		}
		else {//debug($this->request->data);
			$count = 1;
			foreach($this->request->data['ExamType'] as $key => $examType) {//debug($examType['mandatory']);
				if(is_array($examType))
					{
			?>
			<tr id="ExamType_<?php echo $count; ?>">
				<td style="vertical-align:middle"><?php echo ($count); ?></td>
				<td><?php if(isset($examType['id'])) echo $this->Form->input('ExamType.'.$key.'.id', array('type' => 'hidden'));?>
					<?php echo $this->Form->input('ExamType.'.$key.'.exam_name', array('label' => false));?></td>
				<td><?php echo $this->Form->input('ExamType.'.$key.'.percent', array('maxlength' => '5','label' => false, 'style' => 'width:75px'));?></td>
				<td><?php echo $this->Form->input('ExamType.'.$key.'.order', array('maxlength' => '2', 'type' => 'text', 'label' => false, 'maxlength' => '2', 'style' => 'width:75px'));?></td>
				<td><?php
				$coptions = array();
				$coptions['value'] = 1;
				$coptions['label'] = false;
				if($examType['mandatory'] == 1)
					$coptions['checked'] = 'checked';
				echo $this->Form->input('ExamType.'.$key.'.mandatory', $coptions);?></td>
				<td><a href="javascript:deleteSpecificRow('ExamType_<?php echo $count++; ?>')">Delete</a></td>
			</tr>
			<?php
					}
				}
			}
		?>
	</table>
	<?php
	if(!$grade_submitted) {
	?>
	<p><input style="margin-bottom:0px" type="button" value="Add Row" onclick="addRow('exam_setup', 'ExamType', 5, '<?php echo $all_exam_setup_detail; ?>')" /></p>
	<?php
		echo $this->Form->submit(__('Submit Exam Setup'), array('div' => false));
		}
	?>
<div id="flashMessage" class="info-box info-message"><span></span>Important Note: If a student fail to take any of the mandatory exam/s, the system will automatically give NG to the student.</div>
	<?php
	}
else if(count($publishedCourses) <= 1) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>Please select academic year and semester to get list of published courses.</div>';
}
else {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>Please select published course to get exam setup form.</div>';
}
?>
</div>
<?php
}
?>
<?php echo $this->Form->end(); ?>
</div>
