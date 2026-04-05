<?php
if (count($students) <= 0) { ?>
	<div class="info-box info-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span>The system is unable to find list of students who are in the selected section elegible for filling preferences.</div>
	<?php
} else { 
	echo $this->element('preference_filling_sheet');
}
