<?php
# /app/views/students/get_regions.ctp
?>
<option>Select a Region/City</option>
<?php
foreach($regions as $regionId=>$regionName){
echo '
<option value="'.$regionId.'">'.$regionName.'</option>'."\n";
}
?>
