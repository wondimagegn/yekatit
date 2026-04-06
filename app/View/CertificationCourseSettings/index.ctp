<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Certification Course Settings'); ?></span>
		</div>
	</div>
    <div class="box-body">
    	<div class="row">
	  		<div class="large-12 columns">
             
				<div class="index" style="margin-top: -30px;">
					<hr>
					<?php
					if (isset($certificationCourseSettings) && !empty($certificationCourseSettings)) { ?>
						<div style="overflow-x:auto;">
							<table cellpadding="0" cellspacing="0" class="table">
								<thead>
								<tr>
									<th style="width: 5%;" class="center">#</th>
									<th class="vcenter"><?= $this->Paginator->sort('academic_year');?></th>
									<th class="center"><?= $this->Paginator->sort('semester');?></th>
									<th class="center"><?= $this->Paginator->sort('program_id');?></th>
                                    <th class="center"><?= $this->Paginator->sort('created');?></th>
									<th class="center"><?= $this->Paginator->sort('modified');?></th>
									<th class="center">Actions</th>
								</tr>
								</thead>
								<tbody>
									<?php
									$start = $this->Paginator->counter('%start%');
									foreach ($certificationCourseSettings as $c_setting) { ?>
										<tr>
											<td class="center"><?= $start++; ?></td>
											<td class="vcenter"><?= $c_setting['CertificationCourseSetting']['academic_year']; ?></td>
                                            <td class="center"><?= $c_setting['CertificationCourseSetting']['semester']; ?></td>
                                            <td class="center"><?= $programs[$c_setting['CertificationCourseSetting']['program_id']]; ?></td>
											<td class="center"><?= $this->Time->format("M j, Y h:i A", $c_setting['CertificationCourseSetting']['created'], NULL, NULL); ?></td>
											<td class="center"><?= $this->Time->format("M j, Y h:i A", $c_setting['CertificationCourseSetting']['modified'], NULL, NULL); ?></td>
											<td class="center">
												<?php
												if (($this->Session->read('Auth.User')['role_id'] == ROLE_SYSADMIN || $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) && $this->Session->read('Auth.User')['is_admin'] == 1) { ?>
													<?= $this->Html->link(__(''), array('action' => 'edit', $c_setting['CertificationCourseSetting']['id']), array('class' => 'fontello-pencil', 'title' => 'Edit')); ?> &nbsp;
													<?php
												}
												if (($this->Session->read('Auth.User')['role_id'] == ROLE_SYSADMIN || $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) && $this->Session->read('Auth.User')['is_admin'] == 1) { ?>
													<?= $this->Html->link(__(''), array('action' => 'delete', $c_setting['CertificationCourseSetting']['id']), array('class' => 'fontello-trash', 'title' => 'Delete'), sprintf(__('Are you sure you want to delete this certification course setting?'))); ?>
													<?php
												} ?>
											</td>
										</tr>
										<?php 
									} ?>
								</tbody>
							</table>
						</div>

						<hr>
						<div class="row">
							<div class="large-5 columns">
								<?= $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total'))); ?>
							</div>
							<div class="large-7 columns">
								<div class="pagination-centered">
									<ul class="pagination">
										<?= $this->Paginator->prev('<< ' . __(''), array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?> <?= $this->Paginator->numbers(array('separator' => '', 'tag' => 'li')); ?> <?= $this->Paginator->next(__('') . ' >>', array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?>
									</ul>
								</div>
							</div>
						</div>
						<?php
					} else { ?>
						<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>Unable to load Certification Course Settings. Please Make sure that you have the privilage to view/list Certification Course Settings.</div>
						<hr>
						<?php
					} ?>
				
				</div>
	  		</div>
		</div>
    </div>
</div>