<?php
$options = "";
if (isset($departments) && !empty($departments)) {
  foreach($departments as $department_id =>$departmentName){
	 $options .= "<option value=\"".$department_id."\">".$departmentName."</option>";
   }
}

if(count($departments) == 0)
	$options = "<option value=\"\"></option>";
echo $options;
?>
 
