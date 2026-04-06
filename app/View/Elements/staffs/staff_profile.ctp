<div class="row">
	<div class="large-12 columns">
		<ul class="tabs" data-tab>
			<li class="tab-title active"><a href="#basicinformation">Basic Staff Profile</a></li>
			<li class="tab-title"><a href="#study">Study Leave & Committement</a></li>
		</ul>
		<div class="tabs-content edumix-tab-horz">
			<div class="content active" id="basicinformation" style="padding-left: 0px; padding-right: 0px;">
				<?php
				if (!empty($staff_profile)) {
					//debug($staff_profile); ?>
					<div class="large-6 columns" style="padding-left: 5px;">
						<table cellpadding="0" cellspacing="0" class="table" style="margin-bottom: 15px;">
							<tbody>
								<tr><td><strong>Demographic Information</strong></td></tr>
								<tr><td style="padding-left:30px;">First Name: <strong> <?= ucwords( strtolower($staff_profile['Staff']['first_name'])); ?></strong></td></tr>
								<tr><td style="padding-left:30px;">Middle Name: <strong> <?= ucwords(strtolower($staff_profile['Staff']['middle_name'])); ?></strong></td></tr>
								<tr><td style="padding-left:30px;">Last Name: <strong> <?= ucwords(strtolower($staff_profile['Staff']['last_name'])); ?></strong></td></tr>
								<tr><td style="padding-left:30px;">Gender: <strong> <?= ucwords($staff_profile['Staff']['gender']); ?></strong></td></tr>
								<tr><td style="padding-left:30px;">BirthDate: <strong> <?= $this->Time->format("M j, Y", $staff_profile['Staff']['birthdate'], NULL, NULL); ?></strong></td></tr>
								<tr><td style="padding-left:30px;"><?= Configure::read('CompanyShortName'); ?> Staff ID: <strong> <?= $staff_profile['Staff']['staffid']; ?></strong></td></tr>
							</tbody>
						</table>

						<table cellpadding="0" cellspacing="0" class="table" style="margin-bottom: 15px;">
							<tbody>
								<tr><td><strong>Department and Service</strong></td></tr>
								<tr><td style="padding-left:30px;"><?= (isset($staff_profile['College']['type']) && !empty($staff_profile['College']['type'])  ? $staff_profile['College']['type'] : 'College'); ?>: <strong> <?= $staff_profile['College']['name']; ?></strong></td></tr>
								<tr><td style="padding-left:30px;"><?= (isset($staff_profile['Department']['type']) && !empty($staff_profile['Department']['type'])  ? $staff_profile['Department']['type'] : 'Department'); ?>: <strong> <?= $staff_profile['Department']['name']; ?></strong></td></tr>
								<tr><td style="padding-left:30px;">Highest Degree: <strong> <?= $staff_profile['Staff']['education']; ?></strong></td></tr>
								<tr><td style="padding-left:30px;">Academic Rank: <strong> <?= $staff_profile['Position']['position']; ?></strong></td></tr>
								<tr><td style="padding-left:30px;">Service Wing: <strong> <?= $staff_profile['Staff']['servicewing']; ?></strong></td></tr>
							</tbody>
						</table>
					</div>
					<div class="large-6 columns" style="padding-left: 5px;">
						<table>
							<tr><td><strong>Profile Picture</strong></td></tr>
							<?php
							//$this->Html->link(__('Delete Picture', true), array('controller' => 'attachments', 'action' => 'delete', $av['id'], $action_controller_id), null, sprintf(__('Are you sure you want to delete picture ?', true)));
							if (isset($staff_profile['Attachment']) && !empty($staff_profile['Attachment'])) {
								foreach ($staff_profile['Attachment'] as $ak => $av) {
									if ($av['group'] == "Profile") {
										if (!empty($av['dirname']) && !empty($av['basename'])) { ?>
											<tr>
												<td>
													<?= $this->Media->embed($this->Media->file($av['dirname'] . DS . $av['basename']), array('width' => '144')); ?>
												</td>
											</tr>
											<?php
										}
										break;
									}
								}
							} else { ?>
								<tr>
									<td valign="top">
										<img src="/img/noimage.jpg" width="144" class="profile-picture">
										<?php //echo $this->element('Media.attachments'); ?>
									</td>
								</tr>
								<?php
							} ?>
							<tr><td><strong>Address & Contact</strong></td></tr>
							<tr><td style="padding-left:30px;">Country: <strong> <?= ucwords($staff_profile['Country']['name']); ?></strong></td></tr>
							<tr><td style="padding-left:30px;">Email: <strong> <?= $staff_profile['Staff']['email']; ?></strong></td></tr>
							<tr><td style="padding-left:30px;">Mobile: <strong> <?=  ucwords($staff_profile['Staff']['phone_mobile']); ?></strong></td></tr>
						</table>
					</div>
								
					<?php
				} ?>
			</div>

			<div class="content" id="study"  style="padding-left: 0px; padding-right: 0px;">
				<?php 
				if (!empty($staff_profile)) { ?>
					<div style="overflow-x:auto;">
						<table cellpadding="0" cellspacing="0" class="table" style="margin-bottom: 15px;">
							<thead>
								<tr>
									<th class="vcenter">Education</th>
									<th class="vcenter">Country Studied</th>
									<th class="vcenter">Specialization</th>
									<th class="center">Committement Signed</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($staff_profile['StaffStudy'] as $stk => $stvalue) { ?>
									<tr>
										<td class="vcenter"><?= ucwords($stvalue['education']); ?></td>
										<td class="vcenter"><?= $countries[$stvalue['country_id']]; ?></td>
										<td class="vcenter"><?= ucwords($stvalue['specialization']); ?></td>
										<td class="center"><?= ($stvalue['committement_signed'] == true ? 'Yes' : 'No'); ?></td>
										<td class="center">
											<?php //echo $this->Html->link('View', array('controller' => 'staffStudies', 'action' => 'view', $stvalue['id'])) . '  ' . $this->Html->link('Edit', '#', array('data-animation' => "fade", 'data-reveal-id' => 'myModalAddStudy', 'data-reveal-ajax' => '/staffs/ajax_add_study/' . $staff_profile['Staff']['id'] . '/' . $stvalue['id'])); ?>
											<?= $this->Html->link('View', '#', array('data-animation' => "fade", 'data-reveal-id' => 'myModalCommitmentDetail', 'data-reveal-ajax' => '/staffStudies/view/' . $stvalue['id'])) . ' &nbsp; &nbsp; ' . $this->Html->link('Edit', '#', array('data-animation' => "fade", 'data-reveal-id' => 'myModalAddStudy', 'data-reveal-ajax' => '/staffs/ajax_add_study/' . $staff_profile['Staff']['id'] . '/' . $stvalue['id'])); ?>
										</td>
									</tr>
									<?php
								} ?>
							</tbody>
						</table>
					</div>
					<?php
				} ?>
				<hr>
				<?= $this->Html->link('Add Study', '#', array('class' => 'tiny radius button bg-blue', 'data-animation' => "fade", 'data-reveal-id' => 'myModalAddStudy', 'data-reveal-ajax' => '/staffs/ajax_add_study/' . $staff_profile['Staff']['id'])); ?>
			</div>
		</div>
	</div>
</div>


<!-- AJAX FOR ADDING STAFF STUDY -->
<div id="myModalAddStudy" class="reveal-modal" data-reveal>

</div>

<!-- END AJAX FOR ADDING STAFF STUDY -->

<!-- AJAX FOR VIEW STAFF STUDY -->
<div id="myModalCommitmentDetail" class="reveal-modal" data-reveal>

</div>
<!-- END AJAX FOR VIEW STAFF STUDY -->
	