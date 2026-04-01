<?php echo $this->Form->create('GeneralSetting');?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
	     <h6 class="box-title">
			<?php echo __('Setup Academic Calendar'); ?>
	     </h6>
	  </div>
	  <div class="large-12 columns">
              	<?php
              	echo $this->Form->input('id');
        echo "<table><tbody>";
	    echo "<tr><td>".$this->Form->input('program_id',array('type'=>'select','multiple'=>'checkbox')).'</td><td>'.$this->Form->input('program_type_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';

	    echo "<tr><td>".$this->Form->input('daysAvaiableForGradeChange', array('label'=>'Days Available For Grade Change','type'=>'number')).'</td></tr>';
		
		echo "<tr><td>".$this->Form->input('daysAvaiableForNgToF', array('label'=>'Days Available For NG To F','type'=>'number')).'</td></tr>';
		
		echo "<tr><td>".$this->Form->input('daysAvaiableForDoToF', array('label'=>'Days Available For DO To F','type'=>'number')).'</td></tr>';

		echo "<tr><td>".$this->Form->input('daysAvailableForFxToF', array('label'=>'Days Available For Fx To F','type'=>'number')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('weekCountForAcademicYear', array('label'=>'Week Count For AcademicYear','type'=>'number')).'</td></tr>';

		echo "<tr><td>".$this->Form->input('minimumCreditForStatus', array('label'=>'Minimum Credit For Status Generation','type'=>'number')).'</td></tr>';
		
		echo "<tr><td>".$this->Form->input('maximumCreditPerSemester', array('label'=>'Maximum Credit For Semester','type'=>'number')).'</td></tr>';
		
		echo "<tr><td>".$this->Form->input('notifyStudentsGradeByEmail', array('label'=>'Notify Student Grade By Email')).'</td></tr>';

		echo "<tr><td>".$this->Form->input('allowStudentsGradeViewWithouInstructorsEvalution', array('label'=>'Allow Students  Grade View Without Instructors Evalution')).'</td></tr>';

		echo "<tr><td>".$this->Form->input('allowRegistrationWithoutPayment', array('label'=>'Allow Students  Registration Without Payment')).'</td></tr>';
		
	?>
	 
<?php 
        echo "<tr><td>".$this->Form->end(array('label'=>__('Submit'),'class'=>'tiny radius button bg-blue')).'</td></tr>';
        echo "</tbody></table>";
?>
	  </div>
       </div>
    </div>
</div>
