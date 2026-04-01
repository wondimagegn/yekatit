<?php ?>
<ul class="left">
     <li class="has-dropdown bg-white">
                <a class="bg-white" href="#">
			<i class="text-green fa fa-envelope"></i>&nbsp;<span class="label edumix-msg-noft">
<?php 
if(isset($auto_messages)) {
    echo count($auto_messages); 
}
?></span>
		</a>
           <ul class="dropdown dropdown-nest">
                    <li class="top-dropdown-nest">
			<span class="label round bg-green">MESSAGE</span>
                    </li>

		    <li>
		    
		<table style="width:100%;border:0px;" class="condence" id="AutoMessage">
		
			<?php
			if(empty($auto_messages)) {
				echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="padding-bottom:17px">There is no message to display.</p></td></tr>';
			}
			else {
				foreach($auto_messages as $key => $auto_message) {
					?>
					<tr id="<?php echo $auto_message['AutoMessage']['id']; ?>1">
						<td style="font-size:10px; font-weight:bold"><?php echo $this->Format->humanize_date($auto_message['AutoMessage']['created']); ?> (<span style="color:red; cursor:url('../img/error.ico'), default" onclick="closeMessage('<?php echo $auto_message['AutoMessage']['id']; ?>')">close</span>)</td>
					</tr>
					<tr id="<?php echo $auto_message['AutoMessage']['id']; ?>2">
						<td style="padding-left:10px"><?php echo $auto_message['AutoMessage']['message']; ?></td>
					</tr>
					<?php
				}
			}
			?>
			</table>

                    </li>
           </ul>
    </li>
</ul>

<ul class="right">
	
         <li class=" has-dropdown bg-white">
	      <a class="bg-white" href="#">
		<span class="admin-pic-text text-gray">
		<?php 
		  if(isset($username)){
			echo $username;					
		  }
              	?> 
	      	</span>
              </a>
	     <ul class="dropdown dropdown-nest profile-dropdown">
           	       <li>   
                 	<a href="/users/changePwd">
                       Change Password
                    </a>
                  </li>
				<?php
	
 if($this->Session->read('Auth.User')['role_id']!=ROLE_STUDENT) { ?>
				  <li>   
                 	<a href="/users/edit/<?php echo $this->Session->read('Auth.User')['id'];?>">
                       Edit Profile 
                    </a>
                  </li>
				<?php } else if ($this->Session->read('Auth.User')['role_id']==ROLE_STUDENT) { ?>

		 <li>   
                 	<a href="/students/edit">
                        Profile
                    </a>
                  </li>

			<?php } ?>

		  			<li>
                    <a href="/users/logout">
                        <h4>Logout</h4>
                    </a>
                   </li>
	      </ul>
	 </li>
 </ul>