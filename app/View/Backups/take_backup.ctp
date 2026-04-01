<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title"> <?php echo __('Generate Database Backup');?></h2>
     </div>
     <div class="box-body">
    	  <div class="row">
	    	<div class="large-12 columns">
		<?php echo $this->Form->create('Backup');?>

		<p class="fs14">This tool will enable you to generate database backup so that you can download and store in external device. Normally the system generates the backup dayly during midnight and you should use this tool only for exceptional cases which needs imediate backup before you perform critical tasks. <br /><strong><u>Please do not forget to store the external backup device out side of the server room.</u></strong> </p>
<p style="text-align:center"><?php echo $this->Form->submit(__('Generate Database Backup'), array('name' => 'generateDatabaseBackup','class'=>'tiny radius button bg-blue', 'style' => 'width:250px; height:50px; font-size:18px', 'div' => false)); ?></p>

                  
		<?php echo $this->Form->end(); ?>
				
		</div>
	</div> 
    </div>
</div>
