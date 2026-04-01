<?php
if (isset($staff_basic_data) && !empty($staff_basic_data)) { 
    echo '<table class="fs13">';
    echo '<tr><td style="width:10%">Name</td><td style="width:90%">';
     if (isset($staff_basic_data['Staff'][0]['Title']['title'])) {
         echo $staff_basic_data['Staff'][0]['Title']['title']; 
     }
     if (isset($staff_basic_data['Staff'][0]['full_name'])) {
        echo ' '.$staff_basic_data['Staff'][0]['full_name'];
     }
    
    
    
    echo '</td></tr>';
    
    echo '<tr><td> Position </td><td>';
     if (isset($staff_basic_data['Staff'][0]['Position']) && !empty(
     $staff_basic_data['Staff'][0]['Position'])) {
        echo ' '.$staff_basic_data['Staff'][0]['Position']['position']; 
     } else {
        echo '---';
     }
        
    echo '</td></tr>';
    echo '<tr><td>Email </td><td>';
        if (!empty($staff_basic_data['Staff'][0]['email'])) {
            echo $staff_basic_data['Staff'][0]['email'];
        } else {
            echo '---';
        }
    echo '</td></tr>';
    echo '<tr><td>Office Phone </td><td>';
        if (!empty($staff_basic_data['Staff'][0]['phone_office'])) {
            echo $staff_basic_data['Staff'][0]['phone_office'];
        } else {
            echo '---';
        }
    
    echo '</td></tr>';
     
    echo '<tr><td>Mobile Phone </td><td>';
        if (!empty($staff_basic_data['Staff'][0]['phone_mobile'])) {
            echo $staff_basic_data['Staff'][0]['phone_mobile'];
        } else {
            echo '---';
        }
    
    echo '</td></tr>';
    echo '</table>';
}

?>
