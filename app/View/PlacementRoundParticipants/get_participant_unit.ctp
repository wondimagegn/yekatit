<?php
/* $options = "";
if (isset($units) && !empty($units)) {
    $options .= "<option value=''>[ Select Unit ]</option>";
    foreach ($units as $unit_id => $unit_name) {
        $options .= "<option value=\"" . $unit_id . "\">" . $unit_name . "</option>";
    }
}

if (count($units) == 0) {
    $options = "<option value=\"\">[ No Units Found ]</option>";
}
echo $options; */

$options = '';
if (isset($units) && !empty($units)) { 
   $options .= "<option value=\"\">[ Select Unit ]</option>";
    foreach ($units as $department_id => $departmentName) {
        if (is_array($departmentName) && !empty($departmentName)) {
            $options .= "<optgroup label='" . $department_id . "'>";
                foreach ($departmentName as $opt_department_id => $opt_departmentName) {
                    $options .= "<option value=\"" . $opt_department_id . "\">" . $opt_departmentName . "</option>";
                }
            $options .= "</optgroup>";
        } else {
            $options .= "<option value=\"" . $department_id . "\">" . $departmentName . "</option>";
        }
    }
}

if (count($units) == 0) { 
    $options = "<option value=\"\">[ No Units Found ]</option>";
} 

echo $options; ?>