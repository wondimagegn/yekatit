<?php
$options = "";
if (isset($departments) && !empty($departments)) {
  $options .= "<option value='' >--select department--</option>";
  foreach ($departments as $department_id => $departmentName) {
    $options .= "<option value=\"" . $department_id . "\">" . $departmentName . "</option>";
  }
}

if (count($departments) == 0)
  $options = "<option value=\"\">There is no field of study opened for selected academic year and semester </option>";
echo $options;