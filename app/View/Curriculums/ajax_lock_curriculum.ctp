<div class="row">
<div class="large-12 columns">

<?php echo $this->Form->create('Curriculum',array('action'=>'lock', "method"=>"POST"));
	
echo '<h6>Lock/Unlock Curriculumr for Editing</h6>';

echo $this->Form->hidden('Curriculum.id',array('value'=>$staff_profile['Staff']['id']));

echo $this->Form->input('Curriculum.lock',array('label'=>'Lock/Unlock Curriculum for Editing'));
echo $this->Form->end('Update Study');


?>
	
</div>
</div>
<a class="close-reveal-modal">&#215;</a>
