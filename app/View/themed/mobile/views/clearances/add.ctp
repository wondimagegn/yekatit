<div class="clearances form">
<?php //echo $this->Form->create('Clearance');?>
<?php echo $this->Form->create('Clearance',array('action' => 'add','type'=>'file'));?>
	
	<div class="smallheading"><?php __('Clearance/Withdraw'); ?></div>
	<p class="fs13"><strong>Important Note:</strong>The system will check if you have taken any properties 
	from universities and inform you to return the properties to concerned bodies before filling the clearnance,
	 if you have not taken any properties the system will forward your request to registrar for their approval. 
	 The clearance will be final if the registrar confirmed your clearance as cleared.
<ol class="fs13" style="padding-top:0px; margin-top:0px">
	<li>If the request is withdrawal the system will process the clearnce too, 
	please advice your department advisor befor filling withdrawl, 
	inorder to be consider in readmission application  registrar has to approved 
	the clearnce and accepted your withdrawal </li>
	<li>If the request is clearnce, your clearnce application will be cleared if registrar has approved 
	that your cleared else you have to contact registrar</li>
	<?php
	$yFrom = date('Y') - Configure::read('Calendar.clearanceWithdrawInPast');
    $yTo = date('Y') + Configure::read('Calendar.clearanceWithdrawInFuture');
   
		
		echo '<table>';
		echo '<tr>';
		echo '<td>';
	   echo $this->element('student_basic');	
		echo '</td>';
		echo '<td>';
		echo '<table>';
		$options=array('clearance'=>'Clearance','withdraw'=>'Withdraw');
		$attributes=array('legend'=>false,'label'=>false,'separator'=>'<br/>');
		    
		echo '<tr><td style="padding-left:200px;">'.$this->Form->radio('type',$options,$attributes).
		'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('reason',array('after'=>'E.g. End of Academic Year, Graduation, Health Problem, Acadamic Dismissal, Social/Family/Personal Case')).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('request_date',array('label'=>'Last Date Class Attended',
		'minYear'=>$yFrom,'maxYear'=>$yTo)).'</td></tr>';
		
		echo '<tr><td>'.$this->element('attachments', array('plugin' => 'media','label'=>'Upload profile picture')).'</td></tr>';
		echo '<tr><td class="info-box info-message">Note: incase of withdrawl please attach supporting document for your withdrawl.</td></tr>';
		echo '</table>';
		echo '</td>';
		
		echo '</tr>';
		echo '</table>';
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

