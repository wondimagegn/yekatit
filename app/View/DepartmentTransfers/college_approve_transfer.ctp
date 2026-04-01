<?php ?>
<?php 
 $options=array('1'=>'Accepted','-1'=>'Rejected');
  // $attributes=array('legend'=>false);
   $attributes=array('legend'=>false,'label'=>false,'separator'=>'<br/>');
   ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php 
echo $this->Form->create('DepartmentTransfer',array('novalidate'=>true));
if (!empty($departmentTransfersIncomingToYourDepartment)) {
?>
<div class="info-box info-message"> List of students department transfer request approved by the sender department and college and waiting your college decision </div>
<table cellpadding="0" cellspacing="0">
	<tr>
		    <th>S.N<u>o</u></th>
			<th><?php echo 'Full Name';?></th>
			<th><?php echo 'Semester Attended';?></th>
			<th><?php echo 'Sender Department Approval';?></th>
			<th><?php echo 'Sender College Approval';?></th>
			<th><?php echo 'Destionation Department ';?></th>
			<th><?php echo 'Approval';?></th>
			<th><?php echo 'Remark';?></th>
			
	</tr>
	<?php
	$i = 0;
	$start = 1;
	foreach ($departmentTransfersIncomingToYourDepartment as $departmentTransfer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($departmentTransfer['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $departmentTransfer['Student']['id'])); ?>
		</td>
		
		<td>
			<?php  echo count($departmentTransfer['DepartmentTransfer']['semester_attended']); ?>
		</td>
		
		<td>
			<?php  
			    if ($departmentTransfer['DepartmentTransfer']['sender_department_approval']==1) {
			        echo 'Accepted';
			    } else if ($departmentTransfer['DepartmentTransfer']['sender_department_approval']==-1) {
			        echo 'Rejected';
			    } else {
			        echo '---';     
			    }
			   
			 ?>
		</td>
		<td>
		    <?php  
			    if ($departmentTransfer['DepartmentTransfer']['sender_college_approval']==1) {
			        echo 'Accepted';
			    } else if ($departmentTransfer['DepartmentTransfer']['sender_college_approval']==-1) {
			        echo 'Rejected';
			    } else {
			        echo '---';     
			    }
			   
			 ?>
		</td>
		<td>
		    <?php 
		        echo $departmentTransfer['Department']['name'];
		    ?>   
		</td>
		
	   <?php 
	       echo $this->Form->hidden('DepartmentTransfer.'.$start.'.id',array('value'=>$departmentTransfer['DepartmentTransfer']['id']));
		  echo $this->Form->hidden('DepartmentTransfer.'.$start.'.student_id',
		         array('value'=>$departmentTransfer['Student']['id']));
		         ?>
		    <td>
		        <?php 
		          
		          echo $this->Form->radio('DepartmentTransfer.'.$start.'.receiver_college_approval',$options,$attributes)
		         
		        ?>
		        &nbsp;
		    </td>
		    <td>
                  <?php 
		          
		          echo $this->Form->input('DepartmentTransfer.'.$start.'.receiver_college_remark',
		          array('label'=>false));
		         
		        ?>
            </td>		   
		<?php 
		$start++;
		?>
		
	
	</tr>
<?php endforeach; ?>
</table>
<?php 
  echo $this->Form->submit('submit',array('name'=>'saveIt','div'=>'false')); 
} 
?>

<?php 

if (!empty($departmentTransfersLeaverRequest)) {

     $options=array('1'=>'Accepted','-1'=>'Rejected');
  // $attributes=array('legend'=>false);
   $attributes=array('legend'=>false,'label'=>false,'separator'=>'<br/>');
?>
<div class="info-box info-message"> List of your college students who submitted  department transfer request and waiting your decision for transfer, those accepted transfer request will be forwarded to destionation department for approval.  </div>
<table cellpadding="0" cellspacing="0">
	<tr>
		    <th>S.N<u>o</u></th>
			<th><?php echo 'Full Name';?></th>
			<th><?php echo 'Semester Attended';?></th>
			<th><?php echo 'Destionation Department ' ?></th>
			<th><?php echo 'Minute Number' ?></th>
			<th><?php echo 'Approval';?></th>
			<th><?php echo 'Remark' ?></th>
			
	</tr>
	<?php
	$i = 0;
	$start =1;
	
	foreach ($departmentTransfersLeaverRequest as $departmentTransfer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($departmentTransfer['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $departmentTransfer['Student']['id'])); ?>
		</td>
		<td>
		    <?php 
		        echo count($departmentTransfer['DepartmentTransfer']['semester_attended']);
		    ?>
		</td>
		
		
		<td>
		    <?php 
		        echo $departmentTransfer['Department']['name'];
		    ?>
		</td>
		
	   <?php 
	       echo $this->Form->hidden('DepartmentTransfer.'.$start.'.id',array('value'=>$departmentTransfer['DepartmentTransfer']['id']));
		  echo $this->Form->hidden('DepartmentTransfer.'.$start.'.student_id',
		         array('value'=>$departmentTransfer['Student']['id']));
		         ?>
		<td>
		  <?php 
		      echo $departmentTransfer['DepartmentTransfer']['minute_number'];
		    
		  ?>
		</td>
		<td><?php 
		      
		      echo $this->Form->radio('DepartmentTransfer.'.$start.'.sender_college_approval',$options,$attributes)
		     
		    ?>
		    &nbsp;</td>
		    
		  <td><?php 
		      
		      echo $this->Form->input('DepartmentTransfer.'.$start.'.sender_college_remark',
		      array('label'=>false));
		     
		    ?>
		    &nbsp;</td>
		   
		   
		<?php 
		$start++;
		?>
		
	
	</tr>
<?php endforeach; ?>
</table>
<?php 
echo $this->Form->submit('submit',array('name'=>'saveIt','class'=>'tiny radius button bg-blue','div'=>'false')); 
} 
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
