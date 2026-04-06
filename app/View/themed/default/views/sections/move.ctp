<?php echo $this->Form->create('Section',array('action'=>'section_move_update', 'method'=>"GET"));
	echo $this->Form->input('Selected_section_id',array('label'=>'Sections','id'=>'Selected_section_id','type'=>'select',
        'options'=>$sections,'onchange'=>"this.form.submit();",'empty'=>"--Select Section--"));
	echo $this->Form->hidden('student_id', array('value'=>$student_id));
	echo $this->Form->hidden('previous_section_id', array('value'=>$previous_section_id));
?>
<!--- <form action="/" method="GET">
 <div align="center"">
  <select name="state" onchange="this.form.submit();">
    <option>Choose One To Submit This Form</option>
    <option value="CA">CA</option>
    <option value="VA">VA</option>
  </select>
 </div>
</form> --->