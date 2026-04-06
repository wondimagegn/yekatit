<div class="users form">
  <div class="headerfont"><?php __('User Profile'); ?></div>
	<table>
	<tr>
	<?php
	     echo '<td><table><tbody>';
		        echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Basic Data </strong></td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
                echo '<tr><td>Title</td><td>';
               
		if (!empty($user['Staff'][0]['Title']['title'])) {
                        echo $user['Staff'][0]['Title']['title'];
                } else {
                        echo '---';
                }
                echo '</td></tr>';
             echo '<tr><td>Position</td><td>';
            
                if (!empty($user['Staff'][0]['Position']['position'])) {
                        echo $user['Staff'][0]['Position']['position'];
                } else {
                        echo '---';
                }
                
             echo '</td></tr>';
        
            if ($role_id == ROLE_COLLEGE) {
                echo '<tr><td>College</td><td>';
               
                if (!empty($user['Staff'][0]['College']['name'])) {
                        echo $user['Staff'][0]['College']['name'];
                } else {
                        echo '---';
                }
                
                echo '</td></tr>';
           
            }
            
            
            
	    echo '<tr><td>First Name</td><td>';
	    
                if (!empty($user['Staff'][0]['first_name'])) {
                        echo $user['Staff'][0]['first_name'];
                } else {
                        echo '---';
                }
	    
	    echo '</td></td>';
	    echo '<tr><td>Middle Name</td><td>';
	        if (!empty($user['Staff'][0]['middle_name'])) {
                        echo $user['Staff'][0]['middle_name'];
                } else {
                        echo '---';
                }
	   
	    echo '</td></tr>';
	    
	    
	    echo '<tr><td>Last Name</td><td>';
	    
	         if (!empty($user['Staff'][0]['last_name'])) {
                        echo $user['Staff'][0]['last_name'];
                } else {
                        echo '---';
                }
	    
	    
	    echo '</td></tr>';
            echo '<tr><td>Birth Date</td><td>';
           
                if (!empty($user['Staff'][0]['birthdate'])) {
                        echo $user['Staff'][0]['birthdate'];
                } else {
                        echo '---';
                }
            echo '</td></tr>';
            echo '<tr><td>Email</td><td>';
         
            if (!empty($user['Staff'][0]['email'])) {
                        echo $user['Staff'][0]['email'];
                } else {
                        echo '---';
                }
            
            echo '</td></tr>';
            
        echo '</tbody></table>';
        echo '<td><table><tbody>';
		        echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Access Data</td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
                echo '<tr><td>Active</td><td>';
                if($user['User']['active']){
                        echo "Yes";
                } else {
                        echo "No";
                }
                echo '</td></tr>';
                echo '<tr><td>Username</td><td>';
               
                if (!empty($user['User']['username'])) {
                        echo $user['User']['username'];
                } else {
                        echo '---';
                }
                
                echo '</td></td>';
		echo '<tr><td>Role</td><td>';
		
		if (!empty($user['Role']['name'])) {
                        echo $user['Role']['name'];
                } else {
                        echo '---';
                }
                
		echo '</td></tr>';	        
		echo '</tbody></table>';
		echo '<table>';
		 echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Address Data</td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
                echo '<tr><td>Phone Office</td><td>';
               
                if (!empty($user['Staff'][0]['phone_office'])) {
                        echo $user['Staff'][0]['phone_office'];
                } else {
                        echo '---';
                }
                echo '</td></tr>';
             echo '<tr><td>Phone Mobile</td><td>';
                if (!empty($user['Staff'][0]['phone_mobile'])) {
                        echo $user['Staff'][0]['phone_mobile'];
                } else {
                        echo '---';
                }
                
             echo '</td></tr>';
             echo '<tr><td>Address</td><td>';
             
                 if (!empty($user['Staff'][0]['address'])) {
                        echo $user['Staff'][0]['address'];
                } else {
                        echo '---';
                }
             
             echo '</td></tr>';
	    echo '</table>';
	     echo '</td>';
	?>
	</tr>
    	
	</table>
</div>
