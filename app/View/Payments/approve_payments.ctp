<?php echo $this->Form->create('Payment');?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php if (!isset($admitsearch)) { ?>
<div class="smallheading"> Search the students you want to approve their tutition fee payments. </div>
<table cellpadding="0" cellspacing="0"><tr> 
	
	<td> <?php 
			echo $this->Form->input('Payment.academic_year',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')); ?>
	</td>
    
<td> <?php 
			echo $this->Form->input('Payment.semester',array('options'=>array('I'=>'I','II'=>'II','III'=>'III'))); ?>
	</td>

</tr>
<tr><td>
	   <?php   echo $this->Form->input('Payment.program_id'); ?>  
	</td>
        
<td> <?php 
			echo $this->Form->input('Payment.program_type_id'); ?>
	</td>


</tr>

<tr><td>
	   <?php   echo $this->Form->input('Payment.college_id',array('label'=>'Select College',
			'type'=>'select','empty'=>'---Select College --')); ?>  
	</td>
        
<td> <?php 
			echo $this->Form->input('Payment.department_id',array('label'=>'Select Department','type'=>'select','empty'=>'---Select Department --')); ?>
	</td>


</tr>

	
    <tr><td>

<?php 
echo $this->Form->input('Payment.name');
?>

</td>
<td>
<?php 
echo $this->Form->input('Payment.limit',array('type'=>'number'));
?>

</td></tr>
	<tr><td><?php echo $this->Form->Submit('Continue',array('div'=>false,'name'=>'getonlineapplicant',
'class'=>'tiny radius button bg-blue')); ?> </td>	
</tr></table>
<?php } ?>
<?php 
    if (!empty($onlineApplicants)) {
?>
<table>
   <tr><th colspan=11 class="smallheading"><?php echo  __(' List of students who submitted payment and wait approval of the payment.');?></th></tr>
	<tr>
	        
            <th><?php echo ('No.'); ?> </th>
            
	    <th><?php echo ('Full Name');?></th>
	    <th><?php echo ('Studentnumber');?></th>
	    <th><?php echo ('Sponsor Type');?></th>
	    <th><?php echo ('Total Amount Paid');?></th>
	    <th><?php echo ('Reference');?></th>
	    <th><?php echo ('Payment Slip');?></th>
	    <th><?php echo 'Accept/Reject';?></th>
	    <th><?php echo 'Reason';?></th>
	</tr>
	<?php
	$i = 0;
	$serial_number=1;
	$count=0;
	$options=array('1'=>'Accept','-1'=>'Reject');
        $attributes=array('legend'=>false,'separator'=>"<br/>");
	
	foreach ($onlineApplicants as $onlineApplicant):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
       
        <td><?php echo $serial_number++;?> <?php 
echo $this->Form->hidden('Payment.'.$count.'.id',array('label'=>false,
					'size'=>4,'div'=>false,
					'value'=> $onlineApplicant['Payment']['id']));?></td>
       
        <td><?php echo $onlineApplicant['Student']['full_name']; ?>&nbsp;</td>
		<td><?php echo $onlineApplicant['Student']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $onlineApplicant['Payment']['sponsor_type']; ?>&nbsp;</td>
		<td><?php echo number_format($onlineApplicant['Payment']['fee_amount'], 0, '.', ','); ?>&nbsp;</td>
		
		<td><?php echo $onlineApplicant['Payment']['reference_number']; ?>&nbsp;</td>
		
		
                <td> 

                     <?php 
						if (
							isset($onlineApplicant['Attachment'])
							&& !empty($onlineApplicant['Attachment'])
						) {
							
							foreach ($onlineApplicant['Attachment']
								as $cuk => $cuv) {
								echo '<a
                                    href=' . $this->Media->url(
									$cuv['dirname'] . DS . $cuv['basename'],
									true
								) . '
                                    target=_blank>View
                                    Attachment</a> <br/>';
								
							}
							
						}
?>
              </td>
	      <td>
		<?php 
		echo $this->Form->radio('Payment.'.$count.'.approval_status',$options,$attributes);
		?>
	      </td>
	      <td>
		<?php 
			    echo $this->Form->input('Payment.'.$count.'.approval_remark',array(
		            'value'=>isset($this->request->data['Payment'][$count]['approval_remark'])?
					$this->request->data['Payment'][$count]['approval_remark']:'','label'=>false,'size'=>4,'div'=>false));
		$count++;
		
		?>
	      </td>

		
	</tr>
	
<?php 

endforeach; 
           
echo '<tr><td colspan=9>'.$this->Form->Submit('Approve/Reject Request',array('div'=>false,'name'=>'processSelected',
'class'=>'tiny radius button bg-blue')).'</td></tr>';
?>
</table>
<?php 
    }
echo $this->Form->end();
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
