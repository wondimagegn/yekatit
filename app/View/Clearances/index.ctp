<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
              
<?php 
echo $this->Form->create('Clearance');
if ($role_id != ROLE_STUDENT  && $role_id == ROLE_REGISTRAR) {
?>
<p class="smallheading">View Clearance/Withdrawal Applications.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Academic Year:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.academic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>
			<?php 
			    if (!empty($departments)) {
			    ?>
			     
			<td style="width:12%">Department:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.department_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$departments)); ?></td>    
			    <?php 
			    } else if(!empty($colleges)) {
			    ?>
			    
			<td style="width:12%">College:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.college_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$colleges)); ?></td>
			    <?php 
			    }
			?>
			
			
		</tr>
		<tr>
			<td style="width:12%">Program Type:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.program_type_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$programTypes)); ?></td>
			<td style="width:8%">Program:</td>
			<td style="width:25%"><?php echo $this->Form->input('Search.program_id', array('class' => 'fs14',  'style' => 'width:125px', 'label' => false,'options'=>$programs)); ?></td>
			
		</tr>
		<tr>
		  	<td> Type:</td>
			<td><?php 
			echo $this->Form->input('Search.clear', array('type' => 'checkbox', 'label' => 'Clearance', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['clear'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.withdrawl', array('type' => 'checkbox', 'label' => 'Withdrawal', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['withdrawl'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr>
			
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Clearance/Withdrawal Application'), array('name' => 'viewClearance', 'div' => false,'class'=>'tiny radius button bg-blue')); ?></td>
		</tr>
</table>
<?php 
}
?>
<div class="clearances index">
<?php 

    if (isset($clearances) && !empty($clearances)) {
?>
	<h2><?php echo __('Clearances/Withdraw');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('Full Name','student_id');?></th>
			<th><?php echo $this->Paginator->sort('Department','department_id');?></th>
			<th><?php echo $this->Paginator->sort('Program','program_id');?></th>
			<th><?php echo $this->Paginator->sort('Type','type');?></th>
			<th><?php echo $this->Paginator->sort('Reason','reason');?></th>
			<th><?php echo $this->Paginator->sort('Request Date','request_date');?></th>
			<th><?php echo $this->Paginator->sort('Clearance Accepted/Rejected','confirmed');?></th>
			<th><?php echo $this->Paginator->sort('Withdraw Accepted/Rejected','forced_withdrawal');?></th>
			<?php
			    if ($role_id == ROLE_STUDENT) {   
			 ?>
			<th class="actions"><?php echo __('Actions');?></th>
			
			<?php } ?>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($clearances as $clearance):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($clearance['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $clearance['Student']['id'])); ?>
		</td>
		<td> <?php 
		        if (empty($clearance['Student']['Department']['name'])) {
		                echo 'Pre/Fresh ';
		        } else {
		            echo $clearance['Student']['Department']['name'];
		        }
		         
		    
		    ?>
		    
		    &nbsp;</td>
		<td> <?php echo $clearance['Student']['Program']['name'].'/'.$clearance['Student']['ProgramType']['name']; ?>&nbsp;</td>
		<td><?php echo $clearance['Clearance']['type']; ?>&nbsp;</td>
		<td><?php echo $clearance['Clearance']['reason']; ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($clearance['Clearance']['request_date']); ?>&nbsp;</td>
		<td><?php 
		        if ($clearance['Clearance']['confirmed'] == 1) {
		            echo 'Accepted';
		        } else if ($clearance['Clearance']['confirmed'] == -1) {
		            echo 'Rejected';
		        } else {
		        
		            echo '---';
		        }
		        
		?>&nbsp;
		
		</td>
		
		
		<td><?php 
		   if (strcasecmp($clearance['Clearance']['type'],'withdraw')===0) {
		        if ($clearance['Clearance']['forced_withdrawal'] == 1) {
		            echo 'Accepted';
		        } else if ($clearance['Clearance']['forced_withdrawal'] == -1) {
		            echo 'Rejected';
		        } else {
		        
		            echo '---';
		        }
		   } else {
		         echo 'Not Applicable';
		   }
		        
		?>&nbsp;
		
		</td>
			
		
			
			<?php 
			if ($role_id==ROLE_STUDENT) {
			?>
			<td class="actions">
			    <?php 
			        echo $this->Html->link(__('Cancel'), array('action' => 'delete', $clearance['Clearance']['id']), null, sprintf(__('Are you sure you want to cancel # %s?'), $clearance['Clearance']['id']));
			        
			        ?>
			 </td>   
			    <?php 
			}
			
			
			 ?>
		
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<?php 
}
?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
