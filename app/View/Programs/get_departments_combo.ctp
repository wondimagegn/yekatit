<?php
/* if (isset($departments) && !empty($departments)) {
    $options = '';
    foreach ($departments as $department_id => $departmentName) {
        if (is_array($departmentName) && !empty($departmentName)) {
            foreach ($departmentName as $opt_department_id => $opt_departmentName) {
                $options .= "<option value=\"" . $opt_department_id . "\">" . $opt_departmentName . "</option>";
            }
        } else {
            $options .= "<option value=\"" . $department_id . "\">" . $departmentName . "</option>";
        }
    }
}

if (count($departments) == 0) {
    $options = "<option value=''>[ No Department Found ]</option>";
}
echo $options; */ ?>


<?php
if (count($departments) == 0) { 
    echo "<option value=''>[ No Department Found ]</option>";
} else if (!empty($departments)) { 
    $options = '';
    foreach ($departments as $department_id => $departmentName) {
        if (is_array($departmentName) && !empty($departmentName)) {
            echo "<optgroup label='" . $department_id . "'>";
                foreach ($departmentName as $opt_department_id => $opt_departmentName) {
                    echo "<option value='" . $opt_department_id . "'>" . $opt_departmentName . "</option>";
                }
            echo "</optgroup>";
        } else {
            $options .= "<option value=\"" . $department_id . "\">" . $departmentName . "</option>";
        }
    }

    if (!empty($options)) {
        echo $options;
    }
} ?>