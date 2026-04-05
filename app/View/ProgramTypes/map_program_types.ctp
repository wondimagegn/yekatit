<div class="box">
	<div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Map Equivalent Program Type(s)'); ?></span>
        </div>
    </div>
    <div class="box-body">
    	<div class="row">
	  		<div class="large-12 columns">
				<div style="margin-top: -30px;"><hr></div>
				<div class="programTypes form">
					<fieldset style="padding-top: 15px; padding-bottom: 0px;">
						<!-- <legend class="smallheading"><?php //echo __('Map Program Type'); ?></legend> -->
						<?= $this->Form->create('ProgramType'); ?>

						 <div class="row">
	  						<div class="large-4 columns">
								<?= $this->Form->input('program_type_id', array('id' => 'program_type_id',  'style' => 'width: 90%;', 'label' => 'Program Type: ', 'required', 'error' => false, 'empty' => '[ Select Program Type ]')); ?>
							</div>
						</div>
						
					
						<!-- AJAX LOADING -->
						<div id="program_type_equivalency">
							
						</div>
						<!-- AJAX LOADING -->

						<hr>
						<?= $this->Form->end(array('label' => __('Map Selected'), 'id' => 'mapSelected', 'disabled', 'class' => 'tiny radius button bg-blue')); ?>
					</fieldset>
				</div>   
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() { 
    $('#program_type_id').change(function () { 
		var selectedId = $(this).val();

		if (selectedId && selectedId != '') {
        	$('#program_type_equivalency').load('/program_types/get_program_types/'+selectedId);
			$('#mapSelected').removeAttr('disabled');
		} else {
			$('#program_type_equivalency').append().empty();
			$('#mapSelected').attr('disabled', 'disabled'); // Keep disabled if empty
		}
    });
  });
</script>
