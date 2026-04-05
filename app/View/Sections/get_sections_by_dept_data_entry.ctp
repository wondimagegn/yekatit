<?php
if (isset($sections) && count($sections) > 0) { ?>
	<option value="0">[ Select Section ]</option>
	<?php
	foreach ($sections as $id => $section) {
		echo "<optgroup label='" . $id . "'>";
		foreach ($section as $key => $value) {
			echo "<option value='" . $key . "'>" . $value . "</option>";
		}
		echo "</optgroup>";
	}
} else if (empty($sections)) { ?>
	<option value=''> <?= (isset($department_id_selected) && empty($department_id_selected) ? '[ Department Not Selected ]' : '[ No Section Found by Critetia ]'); ?></option>
	<?php
} 
