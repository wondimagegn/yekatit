<?php
 $options = "";
 if (isset($curriculums) && !empty($curriculums)) {
 foreach($curriculums as $curriculums_id => $curriculums_name){
	 $options .= "<option value=\"".$curriculums_id."\">".$curriculums_name."</option>";
	}
}
if(count($curriculums) == 0)
	$options = "<option value=\"No Curriculum\"></option>";
echo $options;
?>
