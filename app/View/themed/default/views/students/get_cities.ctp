<?php
# /app/views/students/get_cities.ctp
?>
<option>Select a City</option>
<?php
foreach($cities as $cityId=>$cityName){
echo '
<option value="'.$cityId.'">'.$cityName.'</option>'."\n";
}
?>
