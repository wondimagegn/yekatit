<div class="backups form">
<?php echo $this->Form->create('Backup');?>
<div class="smallheading"><?php __('Generate Database Backup'); ?></div>
<p class="fs14">This tool will enable you to generate database backup so that you can download and store in external device. Normally the system generates the backup dayly during midnight and you should use this tool only for exceptional cases which needs imediate backup before you perform critical tasks. <br /><strong><u>Please do not forget to store the external backup device out side of the server room.</u></strong> </p>
<p style="text-align:center"><?php echo $this->Form->submit(__('Generate Database Backup', true), array('name' => 'generateDatabaseBackup', 'style' => 'width:250px; height:50px; font-size:18px', 'div' => false)); ?></p>
<?php echo $this->Form->end(); ?>
</div>
