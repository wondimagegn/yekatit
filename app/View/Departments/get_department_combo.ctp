<?php
$options = "";
if (isset($departments) && !empty($departments)) {
    $options .= "<option value=0>[ Select Department ]</option>";
    if (isset($excludeFreshmanFromList) && $excludeFreshmanFromList == 0 && $this->Session->read('Auth.User')['role_id'] != ROLE_DEPARTMENT && $this->Session->read('Auth.User')['role_id'] != ROLE_SYSADMIN) {
        $options .= "<option value=-1 style='font-weight: bold'> Pre/Freshman </option>";
    }
    foreach ($departments as $department_id => $departmentName) {
        $options .= "<option value=\"" . $department_id . "\">" . $departmentName . "</option>";
    }
}

if (count($departments) == 0) {
    if (isset($show_freshman_only_no_dept_found) && $show_freshman_only_no_dept_found) {
        $options .= "<option value=0>[ Select Department ]</option>";
        $options .= "<option value=-1 style='font-weight: bold'> Pre/Freshman </option>";
    } else {
        $options = "<option value=''>[ No Department Found ]</option>";
    }
}
echo $options;
