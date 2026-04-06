<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-info-outline"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Course Exemption Details' ; ?></span>
		</div>
	</div>
    <div class="box-body">
       	<div class="row">
	  		<div class="large-12 columns">
			  <div style="margin-top: -30px;"><hr><br></div>
				<div class="courseExemptions view">
					<dl>
						<?php $i = 0; $class = ' class="altrow"'; ?>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Request Date'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $this->Time->format("F j, Y h:i:s A", $courseExemption['CourseExemption']['request_date'], NULL, NULL); ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Reason'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['reason']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Taken Course Title'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['taken_course_title']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Taken Course Code'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['taken_course_code']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Course Taken Credit'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['course_taken_credit']; ?>
						</dd>
						<?php
						if (isset($courseExemption['CourseExemption']['grade']) && !empty($courseExemption['CourseExemption']['grade'])) { ?>
							<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Grade'); ?></dt>
							<dd <?php if ($i++ % 2 == 0) echo $class;?>>
								<?= $courseExemption['CourseExemption']['grade']; ?>
							</dd>
							<?php 
						} ?>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Department Accept Reject'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?php  echo $courseExemption['CourseExemption']['department_accept_reject']==1 ? 'Accepted': (!empty($courseExemption['CourseExemption']['department_approve_by']) ? 'Denied':'Waiting Department Approval'); ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Department Reason'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['department_reason']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Registrar Confirm Deny'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['registrar_confirm_deny']==1 ? 'Accepted': (!empty($courseExemption['CourseExemption']['registrar_approve_by']) ? 'Denied':'Waiting Registrar Confirmation');  ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Registrar Reason'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['registrar_reason']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Department Approve By'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['department_approve_by']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Registrar Approve By'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $courseExemption['CourseExemption']['registrar_approve_by']; ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Course'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $this->Html->link($courseExemption['Course']['course_code_title'].'-'.$courseExemption['Course']['credit'], array('controller' => 'courses', 'action' => 'view', $courseExemption['Course']['id'])); ?>
						</dd>
						<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Student'); ?></dt>
						<dd <?php if ($i++ % 2 == 0) echo $class;?>>
							<?= $this->Html->link($courseExemption['Student']['full_name'] . ' (' . $courseExemption['Student']['studentnumber'] . ')', array('controller' => 'students', 'action' => 'view', $courseExemption['Student']['id'])); ?>
						</dd>
						<?php 
						if (!empty($courseExemption['Attachment']) && count($courseExemption['Attachment']) > 0) { ?>
							<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Attachment'); ?></dt>
							<dd <?php if ($i++ % 2 == 0) echo $class;?>>
								<?=  'PDF file uploaded on: '.$this->Format->humanize_date($courseExemption['Attachment'][0]['created']). '<br/> '; ?>
								<?= "<a href=".$this->Media->url($courseExemption['Attachment'][0]['dirname'].DS.$courseExemption['Attachment'][0]['basename'],true)." target=_blank'>View Attachment</a>"; ?>
							</dd>
							<dt <?php if ($i % 2 == 0) echo $class;?>><?= __('Preview'); ?></dt>
							<dd <?php if ($i++ % 2 == 0) echo $class;?> >
							</dd>
							
							<div>
								<?= $this->Media->embedAsObject($courseExemption['Attachment'][0]['dirname'].DS.$courseExemption['Attachment'][0]['basename'],array('width'=>860,'height'=>'500')); ?>
							</div>
							<?php 
						} ?>
					</dl>
				</div>
	  		</div>
		</div>
    </div>
</div>
