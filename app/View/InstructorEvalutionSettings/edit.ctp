<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	<?php echo __('Instructor Evalution  Setting'); ?>
	 </h2>
     </div>
     <div class="box-body">
       <div class="row">
	   <div class="large-12 columns">
		<?php               
		echo $this->Form->create('InstructorEvalutionSetting');
		echo $this->Form->input('id');
		?>
		<table class="fs12">

			<tr>
				<td>Academic Year</td>
				<td><?php
				echo $this->Form->input('academic_year', array('style' => 'width:100px','label'=>false, 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($this->request->data['InstructorEvalutionSetting']['academic_year']) ? $this->request->data['InstructorEvalutionSetting']['academic_year'] : $defaultacademicyear)));
				 ?></td>
			</tr>

			<tr>
				<td>Student Percent</td>
				<td><?php echo $this->Form->input('student_percent',array('maxlength' => '2','label'=>false)); ?></td>
			</tr>


			<tr>
				<td>Colleague Percent</td>
				<td><?php echo $this->Form->input('colleague_percent',array('maxlength' => '2','label'=>false)); ?></td>
			</tr>


			<tr>
				<td>Head Percent</td>
				<td><?php echo $this->Form->input('head_percent',array('maxlength' => '2','label'=>false)); ?></td>
			</tr>
		</table>
<?php echo $this->Form->end(array('label'=>'Instructor Evalution Setting','class'=>'tiny radius button bg-blue'));?>

	   </div>
	</div>
      </div>
</div>
