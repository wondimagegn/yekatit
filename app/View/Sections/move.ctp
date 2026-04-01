<div class="row">
<div class="large-12 columns">
<?php 

echo $this->Form->create('Section',
array('controller'=>'sections','action'=>'section_move_update',"method"=>"POST"));
	echo $this->Form->input('Selected_section_id',array('label'=>'Sections','id'=>'Selected_section_id','type'=>'select',
        'options'=>$sections,'empty'=>"--Select Section--"));
	echo $this->Form->hidden('student_id', array('value'=>$student_id));
	echo $this->Form->hidden('previous_section_id', array('value'=>$previous_section_id));

?>
<?php echo $this->Form->end(
array('label'=>__('Submit'),'class'=>'tiny radius button bg-blue'));?>
</div>
</div>
<a class="close-reveal-modal">&#215;</a>
