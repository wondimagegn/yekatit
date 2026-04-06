<?php

$options = '';

if (isset($departments) && !empty($departments)) { 
    foreach ($departments as $department_id => $departmentName) {

        if (isset($departments['0'])) {
            echo "<option value=\"0\">" . $departments[0] . "</option>";
            unset($departments[0]); // prevent duplicate
        }

        if (isset($departments['-1'])) {
            echo "<option value=\"-1\">" . $departments[-1] . "</option>";
            unset($departments[-1]); // prevent duplicate
        }

        if (is_array($departmentName) && !empty($departmentName)) {
            echo "<optgroup label='" . $department_id . "'>";
                foreach ($departmentName as $opt_department_id => $opt_departmentName) {
                    echo "<option value='" . $opt_department_id . "'>" . $opt_departmentName . "</option>";
                }
            echo "</optgroup>";
        } else if (!is_array($departmentName) && !empty($department_id)) {
            $options .= "<option value=\"" . $department_id . "\">" . $departmentName . "</option>";
        }
    }
} 

echo $options;
