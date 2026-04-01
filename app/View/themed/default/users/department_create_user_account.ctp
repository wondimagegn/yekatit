<div class="users form">
<?php echo $this->Form->create('User');?>
<?php 
if (!isset($staff_account_valid)) {
  
?>
<div class="smallheading"><?php __('Staff  List');?></div>
<p class="fs12">Please enter the first one or two letter of staff first, middle or last name.</p>
<table class="fs13 small_padding">
	<tr> 
		<td style="width:15%">First Letter of Name:</td>
		<td style="width:85%"><?php echo $this->Form->input('Staff.name',array('label'=>false)); ?></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $this->Form->Submit('Search',array('div'=>false,'name'=>'search')); ?></td>	
	</tr>
	</table>

<?php 

}
 if (!empty($staffs) && !isset($staff_account_valid)) { ?>
<table cellpadding="0" cellspacing="0">
	<tr>
	    <th style="width:5%">S.N<u>o</u></th>
		<th style="width:25%"><?php echo 'Full Name'; ?></th>
		
		<th style="width:10%; text-align:center" class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count=1;
	foreach ($staffs as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
	    <td><?php echo $count++; ?></td>
		<td><?php echo $user['Staff']['full_name']; ?>&nbsp;</td>
		
		<td class="actions">
			 <?php echo $this->Html->link(__('Create Account', true), array('action' => 'department_create_user_account', $user['Staff']['id'])); ?> 
			 &nbsp;
		
		</td>
	</tr>
<?php endforeach; ?>
	</table>
<?php 

}

if (isset($staff_account_valid)) {
?>
    <div class="smallheading"><?php
       
         __('Create User account for system access.'); 
     ?></div>
	
	<table>
	<tr>
	<?php
	   
	     echo '<td style="width:60%"><table class="fs13"><tbody>';
		        echo '<tr><td colspan="3" class="fs13" style="font-weight:bold">Basic Data</td></tr>';
                
                echo '<tr><td>';
                  echo $this->element('staff_basic');
                echo '</td></tr>';
              
        echo '</tbody></table></td>';
        echo '<td style="width:40%"><table><tbody>';
		     
		       echo '<tr><td colspan=2 class="fs13" style="font-weight:bold">Access Data</td></tr>';
              
               echo $this->Form->hidden('Staff.0.id',array('value'=>$staff_basic_data['Staff'][0]['id']));
               echo '<tr><td colspan=2 style="align:left">'. $this->Form->input('User.username').'</td></td>';
		       echo '<tr><td colspan=2 style="align:left">'.$this->Form->input('User.passwd',
		       array( 'label' => 'Password')).'</td></tr>';	
		       echo '<tr><td colspan=2 style="align:left">'.$this->Form->input('User.role_id',array('empty'=>'--select role--','id'=>'user_role_id','value'=>!empty($this->data['User']['role_id'])?$this->data['User']['role_id']:'')).'</td></tr>';	 
		      
	 echo '</tbody></table></td>';
	 
	?>
	</tr>
	<tr><td><?php

                  echo $this->Form->submit('Submit',array('name'=>'createAccount','div'=>'false'));
	
	
	?></td></tr>
	</table>
<?php 
}
echo $this->Form->end();
?>
</div>
