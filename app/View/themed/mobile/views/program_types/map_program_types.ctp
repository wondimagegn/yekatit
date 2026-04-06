<div class="programTypes form">
<?php echo $this->Form->create('ProgramType');?>
<div style="padding;20px;"></div>
	<fieldset>
		<legend class="smallheading"><?php __('Map Program Type'); ?></legend>
	<?php
		echo $this->Form->input('program_type_id',array('id'=>'program_type_id','label'=>'Program Types','error'=>false,'empty'=>'--select program type--'));
		
		
		
	?>
	<div id="program_type_equivalency">
	    
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Map', true));?>
</div>
<script type="text/javascript">
  $(document).ready(function() { 
    $('#program_type_id').change(function () { 
       
         $('#program_type_equivalency').load('/program_types/get_program_types/'+$(this).val());

    });
  });
</script>
