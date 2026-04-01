<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	 <?php echo __('Instructor Evalution Setting View');?>
	 </h2>
     </div>
     <div class="box-body">
	

       <div class="row">
	   <div class="large-12 columns">
        <table class="fs12">
				<?php if(!empty($instructorEvalutionSetting)) { ?>
					<tr>
						<td><?php echo __('Academic Year'); ?></td>
						<td><?php echo $instructorEvalutionSetting['InstructorEvalutionSetting']['academic_year']; ?></td>
					</tr>
                    <tr>
						<td><?php echo __('Student %'); ?></td>
						<td><?php echo $instructorEvalutionSetting['InstructorEvalutionSetting']['student_percent']; ?></td>
					</tr>

					 <tr>
						<td><?php echo __('Colleague %'); ?></td>
						<td><?php echo $instructorEvalutionSetting['InstructorEvalutionSetting']['colleague_percent']; ?></td>
					</tr>

					 <tr>
						<td><?php echo __('Head %'); ?></td>
						<td><?php echo $instructorEvalutionSetting['InstructorEvalutionSetting']['head_percent']; ?></td>
					</tr>

				
				<?php } ?>
				<tr>
					<td colspan="2" style="padding-top:20px"><?php echo $this->Html->link("Change Instructor Evalution Setting", array('controller' => 'instructorEvalutionSettings', 'action' => 'edit'), array('style' => 'font-weight:bold','class'=>'tiny radius button bg-blue')); ?></td>
				</tr>
		</table>
	   </div>

       </div>
    </div>
</div>
