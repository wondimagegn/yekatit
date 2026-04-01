<div class="acceptedStudents index">
 <?php echo $this->Form->create('AcceptedStudent', array('controller' => 'acceptedStudents', 'action' => 'import_newly_students', 'type' => 'file'));
 
 ?>
<table>
<tbody>
<tr><th colspan=5 class="smallheading"><?php 
echo __("Beaware: Before importing the excel
    ,make sure that the value of college, region, program,program types, and department(if exist) field as listed below. If you think there is  a missing  college,region, program type, and program name,department, please contact the system administrator.");
    ?>
   Here is a link to the excel template that shows you how you can store 
   the data in excel that are compatible with the system database. 
   <?php 
  
    /* echo $this->Html->link('Download Import Template!', array('action'=>'download',
                                                "template",
                                                "template.xls"));
                                                */
      
   
   ?>
 
    <a href="/files/template/template.xls">Download Import Template!</a>
    </th>
<tr>
<td>
   <?php
    echo "<table><tbody><tr><th>Import Accepted Students</th></tr>";
    echo "<tr><td>";
    echo $this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')); 
    echo "</td></tr><tr><td>";
    
    echo $this->Form->file('File').'</td></tr>';
    echo '<tr><td>'.$this->Form->submit('Upload').'</td></tr></tbody></table>';
    ?>
</td>
<td width='30%'>
<?php 
   echo "<table><tbody><tr><th>Colleges</th>";
   /* foreach($colleges as $ck=>$cv) {
        echo "<tr><td>".$cv."</td></tr>";
    }
    */
    foreach($departments_organized_by_college as $college=>$department){
         echo "<tr><td><strong>".$college."</strong></td></tr>";
         echo "<tr><td><table>";
            foreach($department as $k=>$dep){
                echo "<tr><td>".$dep."</td></tr>";
            }
         echo "</table></td></tr>";
    }
    echo "</tbody></table>";
 ?>   
 
</td><td>
<?php 
   echo "<table><tbody><tr><th>Regions</th></tr>";
    foreach($regions as $ck=>$cv) {
        echo "<tr><td>".$cv."</td></tr>";
    }
    echo "</tbody></table>";
    ?>
</td><td>
<?php 
   echo "<table><tbody><tr><th>Program</th></tr>";
    foreach($programs as $ck=>$cv) {
        echo "<tr><td>".$cv."</td></tr>";
    }
    echo "</tbody></table>";
    ?>
</td>
<td>
<?php 
   echo "<table><tbody><tr><th>Program Types</th></tr>";
    foreach($programTypes as $ck=>$cv) {
        echo "<tr><td>".$cv."</td></tr>";
    }
    echo "</tbody></table>";
    ?>
</td>

</tr>
<tr>
<?php
    if(isset($non_valide_rows)){
         echo "<td colspan=5>";
          echo "<ul style='color:red'>";
          foreach($non_valide_rows as $k=>$v){
                echo "<li>".$v."</li>";
          }
          echo "</ul>";
          echo "</td></tr>";
    }
   
 ?>
</tbody>
</table>
<?php    
echo $this->Form->end();

?>
</div>
