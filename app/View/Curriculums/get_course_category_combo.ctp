<?php
 $options = "";
 if (isset($courseCategories) && !empty($courseCategories)) {
 foreach($courseCategories as $courseCategory_id => $courseCategory_name){
	 $options .= "<option value=\"".$courseCategory_id."\">".$courseCategory_name."</option>";
	}
}
if(count($courseCategories) == 0)
	$options = "<option value=\"No Course Category\">No Course Category</option>";
echo $options;
?>
