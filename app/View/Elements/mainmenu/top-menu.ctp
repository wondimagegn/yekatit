<ul class="left">
	<li class="has-dropdown bg-white">
		<?php
		// prevent students to get notification notification dropdown that allows to view grade without evaluating their instructors or other tasks that force them to do something.
		if ($this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT || ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT && isset($show_notification_message) && $show_notification_message)) { ?>
			<a class="bg-white" href="#">
				<i class="text-green fa fa-envelope"></i>&nbsp;<span class="label edumix-msg-noft"><?= (isset($auto_messages)? count($auto_messages): '0'); ?></span>
			</a>
			<ul class="dropdown dropdown-nest">
				<li class="top-dropdown-nest">
					<span class="label round bg-green">MESSAGES</span>
				</li>

				<?php 
				if (empty($auto_messages)) { ?>
					<li style="background: #fff; padding-top:5px;">
						<h6 class="text-black" style="text-align:center; padding-top:5px;"> 
							No new messages for now
						</h6>
					</li>
					<?php 
				} else { ?>
					<table cellpadding="0" cellspacing="0" class="condence table" id="AutoMessage">
						<?php
						foreach($auto_messages as $key => $auto_message){ ?>
							<tr id="<?= $auto_message['AutoMessage']['id']; ?>">
								<!-- <td style="font-size:10px; font-weight:bold; padding-left:15px;"><li style="background: #fff; padding-top:5px;"><?php //echo $this->Time->format("M j, Y g:i:s A", $auto_message['AutoMessage']['created'], NULL, NULL); ?> &nbsp; ( <span style="color:red; cursor:url('../img/error.ico'), default" onclick="closeMessage('<?php //echo $auto_message['AutoMessage']['id']; ?>')">close</span>)</li></td> -->
								<td style="font-size:10px; font-weight:bold; padding-left:15px;"><li style="background: #fff; padding-top:5px;"><?= $this->Time->format("M j, Y g:i:s A", $auto_message['AutoMessage']['created']); ?></li></td>
							</tr>
							<tr id="<?= $auto_message['AutoMessage']['id']; ?>">
								<td style="padding-left:15px; padding-right:15px; background-color:white; background: #ffffff;"><?= $auto_message['AutoMessage']['message']; ?></td>
							</tr>
							<?php 
						} ?>				
					</table>
					<?php
				} ?>
			</ul>
			<?php
		} ?>
	</li>
</ul>

<ul class="right">
	<li class=" has-dropdown bg-white">
		<a class="bg-white" href="#">
			<!-- <img alt="" class="admin-pic img-circle" src="/img/Portrait_placeholder.jpg" style="margin: 20px 0px 0px 20px;"> -->
			<span class="admin-pic-text text-gray"><?= (isset($username) ? $username: ''); ?></span>
		</a>
		<ul class="dropdown dropdown-nest profile-dropdown">
			<li>
				<i class="fa fa-key"></i>
				<a href="/users/changePwd"><h4>Change Password</h4> </a>
			</li>
			<?php
			if ($this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT) { ?>
				<li>
					<i class="icon-user"></i>
					<a href="/users/edit/<?= $this->Session->read('Auth.User')['id']; ?>"> <h4>Edit Profile</h4></a>
				</li>
				<?php 
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) { ?>
				<li>
					<i class="icon-user"></i>
					<a href="/students/profile"><h4>Profile</h4> </a>
				</li>
				<?php
			} ?>
			<li>
				<i class="icon-upload"></i>
				<a href="/users/logout"><h4>Logout</h4> </a>
			</li>
		</ul>
	</li>
</ul>