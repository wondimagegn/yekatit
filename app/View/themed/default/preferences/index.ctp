<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-department_placement');?>
<div class="preferences index">
	<table><tr><td>
	<?php 
	if($role_id!=ROLE_STUDENT ){
	    echo '<table><tbody>';
	    
	    echo '<tr><td>';  
        echo $this->Form->create('Preference');
		echo $this->Form->input('Preference.academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($selected)?$selected:''));
		echo '</td></tr>';
		 echo '<tr><td>';    
		echo $this->Form->Submit('Submit');
		//echo $ajax->submit('Submit', array('url'=> array('controller'=>'preferences', 'action'=>'index'), 'update' => '#preference_list'));
		
		 echo '</td></tr>';
		 echo '</tbody></table>';
	}
		// echo $this->Js->writeBuffer();
		/*  
		figure out later
		echo $this->Js->submit('Submit',array(
 "update"=>"#preference_list","evalScripts"=>true,'url'=>'/preferences/index'));
        
 */
	?>	
	</td></tr></table>
	<div id="preference_list">
	   <?php 
	   if($role_id==ROLE_STUDENT){
	   echo '<div class="smallheading info-box info-message"><span></span>Important Note: Please fill or change your
	   departmental placement preference before the deadline. <br/> Deadline: '.
	   $format->humanize_date($preference_deadline['PreferenceDeadline']['deadline']).'</div>';
	   }
	   ?>
	</div>
	
<?php if(isset($preferences)&& !empty($preferences)) { ?>
<h3><?php __('List of Student Department Placement Preferences');?></h3>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('Academic Year', 'academicyear');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<th><?php echo $this->Paginator->sort('preferences_order');?></th>
			
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($preferences as $preference):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?></td>
		<td>
			<?php echo $this->Html->link($preference['AcceptedStudent']['full_name'], array('controller' => 'AcceptedStudents', 'action' => 'view', $preference['AcceptedStudent']['id'])); ?>
		</td>
		<td><?php echo $preference['Preference']['academicyear']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($preference['Department']['name'], array('controller' => 'departments', 'action' => 'view', $preference['Department']['id'])); ?>
		</td>
		<td><?php echo $preference['Preference']['preferences_order']; ?>&nbsp;</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit_preference', $preference['Preference']['accepted_student_id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $preference['Preference']['id']), null, sprintf(__('Are you sure you want to delete  %s preferences ?', true),$preference['AcceptedStudent']['full_name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
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
<?php }  ?>
</div>
<?php 
 echo $this->Js->writeBuffer(); // Write cached scripts
 
 ?>
