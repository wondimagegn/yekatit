<?php
if (isset($courses) && !empty($courses)) {
    if (isset($course_mapping) && $course_mapping) {
        // display as it is as array with optgroup
        $options = '';
        foreach ($courses as $c_id => $courseDetail) {
            if (is_array($courseDetail) && !empty($courseDetail)) {
                echo "<optgroup label='" . $c_id . "'>";
                    foreach ($courseDetail as $opt_c_id => $opt_c_Name) {
                        echo "<option value='" . $opt_c_id . "'>" . $opt_c_Name . "</option>";
                    }
                echo "</optgroup>";
            } else {
                $options .= "<option value=\"" . $c_id . "\">" . $courseDetail . "</option>";
            }
        }

        if (!empty($options)) {
            echo $options;
        }
    } else {
        foreach($courses as $courseId => $courseDetail){
            echo '<option value="' . $courseId . '">' . $courseDetail . '</option>';
        }
    }
} else {
    echo '<option value="">[ No Course found in the Curriculum ]</option>';
} ?>
