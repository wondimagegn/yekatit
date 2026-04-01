<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-6 columns">
            
<div class="staffs view">
<h2><?php 
echo __('Basic Information');
debug($staff);
?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['Title']['title']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['Staff']['full_name']; ?>
			&nbsp;
		</dd>
 		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('StaffID'); ?></dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                        <?php echo $staff['Staff']['staffid']; ?>
                        &nbsp;
                </dd>
	

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Position'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['Position']['position']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			
			 echo $staff['User']['username'];
			 ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Account Staus'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			$accountStaus=null;
			if($staff['User']['active']==1){
				$accountStaus="Account Active";
			} else if($staff['User']['active']==0) {
				$accountStaus="Account Deactivated";
			}
			echo $accountStaus;
			 ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['Staff']['email']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Phone Mobile'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['Staff']['phone_mobile']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Gender'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['Staff']['gender']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $staff['User']['Role']['name']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('College'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($staff['College']['name'], array('controller' => 'colleges', 'action' => 'view', $staff['College']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($staff['Department']['name'], array('controller' => 'departments', 'action' => 'view', $staff['Department']['id'])); ?>
			&nbsp;
		</dd>


	</dl>
</div>

	  </div> <!-- end of columns 6 -->
	   <div class="large-6 columns">
	     <?php if(!empty($staff['CourseInstructorAssignment'])) { ?>
				   <h2><?php 

						echo __('Courses Taught');
					
					?></h2>
					<table class="responsive">
					  <tr>
						<th>S.No</th>
						<th>Course</th>
						<th>Section</th>
						<th>Academic Year</th>
						
					 </tr>
					 <?php 
					 $count=1;
					 $totalCredit=0;
					 foreach($staff['CourseInstructorAssignment'] as $k=>$v) {
					 	debug($v);
					 	if(isset($v['PublishedCourse']) && !empty($v['PublishedCourse'])){
					 		$totalCredit+=$v['PublishedCourse']['Course']['credit'];
					 	 ?>
						   <tr>
							<td><?php echo $count++;?></td>
							<td><?php echo $v['PublishedCourse']['Course']['course_title'];?></td>

							<td><?php echo $v['PublishedCourse']['Section']['name'];?></td>

							<td><?php echo $v['PublishedCourse']['academic_year'].'/'.$v['PublishedCourse']['semester'];?></td>
						 </tr>
					 <?php 
					 	}
					 } ?>
					  <tr>
						<td colspan="3">Total</td>	
						<td><?php echo $totalCredit;?></td>	
					  </tr>
					</table>

			<?php } else { ?>


			<?php } ?>
	   </div>
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
