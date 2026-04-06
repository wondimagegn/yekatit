<div class="backups form">
<?php echo $this->Form->create('Backup');?>
<div class="smallheading"><?php __('Download Database Backup'); ?></div>
<p class="fs14"><strong><u>After download, please do not forget to store the external backup device out side of the server room.</u></strong></p>
<table class="fs12">
	<tr>
		<td style="width:10%">Backup From:</td>
		<td style="width:30%"><?php echo $this->Form->input('backup_date_from', array('label' => false, 'type' => 'date', 'dateFormat' => 'MDY', 'minYear' => Configure::read('Calendar.applicationStartYear'), 'maxYear' => date('Y'), 'orderYear' => 'desc', 'selected' => array('year' => (isset($this->data['Backup']['backup_date_from']) ? $this->data['Backup']['backup_date_from']['year'] : date('Y')), 'month' => (isset($this->data['Backup']['backup_date_from']) ? $this->data['Backup']['backup_date_from']['month'] : date('m')), 'day' => (isset($this->data['Backup']['backup_date_from']) ? $this->data['Backup']['backup_date_from']['day'] : (date('d') - 7 > 0 ? date('d') - 7: 1))))); ?></td>
		<td style="width:9%">Backup To:</td>
		<td style="width:28%"><?php echo $this->Form->input('backup_date_to', array('label' => false, 'type' => 'date', 'dateFormat' => 'MDY', 'minYear' => Configure::read('Calendar.applicationStartYear'), 'maxYear' => date('Y'), 'orderYear' => 'desc')); ?></td>
		<td style="width:23%; padding-left:30px"><?php echo $this->Form->submit(__('View Backup', true), array('name' => 'viewBackup', 'id' => 'ViewBackupButton', 'div' => false)); ?></td>
	</tr>
</table>
<?php
if(!empty($files_for_download)) {
?>
<table>
	<tr>
		<th style="width:30%"><?php echo $this->Paginator->sort('Backup File', 'name'); ?></th>
		<th style="width:10%"><?php echo $this->Paginator->sort('size'); ?></th>
		<th style="width:10%"><?php echo $this->Paginator->sort('backup_taken'); ?></th>
		<th style="width:13%"><?php echo $this->Paginator->sort('first_backup_taken_date'); ?></th>
		<th style="width:14%"><?php echo $this->Paginator->sort('last_backup_taken_date'); ?></th>
		<th style="width:14%"><?php echo $this->Paginator->sort('Date Generated / Modified', 'last_backup_taken_date'); ?></th>
		<th style="width:9%">Action</th>
	</tr>
<?php
foreach($files_for_download as $file) {
	?>
	<tr>
		<td><?php echo $file['Backup']['name']; ?></td>
		<td><?php echo number_format(($file['Backup']['size']/1048576), 2, '.', ',').' MB'; ?></td>
		<td class="<?php echo $file['Backup']['backup_taken'] == 1 ? 'accepted' : 'rejected' ?>"><?php echo $file['Backup']['backup_taken'] == 1 ? 'Yes' : 'No'; ?></td>
		<td><?php 
		if($file['Backup']['first_backup_taken_date'] == null || $file['Backup']['first_backup_taken_date'] == '0000-00-00')
			echo '---';
		else {
			$first_backup_taken_date = date('Y-m-d H:i:s', mktime(substr($file['Backup']['first_backup_taken_date'],11 ,2), 
			substr($file['Backup']['first_backup_taken_date'],14 ,2), 
			substr($file['Backup']['first_backup_taken_date'],17 ,2), 
			substr($file['Backup']['first_backup_taken_date'],5 ,2), 
			substr($file['Backup']['first_backup_taken_date'],8 ,2), 
			substr($file['Backup']['first_backup_taken_date'],0 ,4)));
			echo $this->Format->humanize_date($first_backup_taken_date);
		}
		?></td>
		<td><?php
		if($file['Backup']['last_backup_taken_date'] == 0 || $file['Backup']['last_backup_taken_date'] == null || $file['Backup']['last_backup_taken_date'] == '0000-00-00')
			echo '---';
		else {
			$last_backup_taken_date = date('Y-m-d H:i:s', mktime(substr($file['Backup']['last_backup_taken_date'],11 ,2), 
			substr($file['Backup']['last_backup_taken_date'],14 ,2), 
			substr($file['Backup']['last_backup_taken_date'],17 ,2), 
			substr($file['Backup']['last_backup_taken_date'],5 ,2), 
			substr($file['Backup']['last_backup_taken_date'],8 ,2), 
			substr($file['Backup']['last_backup_taken_date'],0 ,4)));
			echo $this->Format->humanize_date($last_backup_taken_date);
		}
		?></td>
		<td><?php echo $this->Format->humanize_date($file['Backup']['created']); ?></td>
		<td><?php echo (!$file['Backup']['file_exists'] ? 'Not Available' : $this->Html->link(__('Download', true), array('action' => 'index', $file['Backup']['id']))); ?></td>
	</tr>
	<?php
}
?>
</table>
	<p>
	<?php
	//$paginator->options(array('url' => $this->passedArgs));
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<?php 
}
echo $this->Form->end();
?>
</div>
