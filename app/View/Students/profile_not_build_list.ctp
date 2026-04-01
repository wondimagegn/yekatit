<div class="students index">
    <?php

	if (!empty($student_lists)) {


	?>
    <div class="smallheading">
        <?php echo __('List of students their profile not complete'); ?>
    </div>
    <table cellpadding="0"
        cellspacing="0">
        <tr>
            <th>S.N<u>o</u></th>
            <th><?php echo 'Full Name'; ?>
            </th>
            <th><?php echo 'Gender'; ?>
            </th>
            <th><?php echo 'Student Number'; ?>
            </th>

            <th><?php echo 'Admission year'; ?>
            </th>

            <th><?php echo 'Program'; ?>
            </th>
            <th><?php echo 'Program Type'; ?>
            </th>

            <th><?php echo 'Department'; ?>
            </th>
            <th><?php echo 'Field of study'; ?>
            </th>
            <th class="actions"> Actions
            </th>
        </tr>
        <?php
			$i = 0;
			$start = 1;
			foreach ($student_lists as $student) :
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
        <tr<?php echo $class; ?>>
            <td><?php echo $start++; ?>&nbsp;
            </td>
            <td><?php echo $student['Student']['full_name']; ?>&nbsp;
            </td>

            <td><?php echo $student['Student']['gender']; ?>&nbsp;
            </td>
            <td><?php echo $student['Student']['studentnumber']; ?>&nbsp;
            </td>
            <td><?php echo $this->Format->short_date($student['Student']['admissionyear']); ?>&nbsp;
            </td>
            <td><?php echo $student['Program']['name']; ?>&nbsp;
            </td>
            <td><?php echo $student['ProgramType']['name']; ?>&nbsp;
            </td>
            <td><?php echo $student['College']['name']; ?>&nbsp;
            </td>

            <td><?php echo $student['Department']['name']; ?>&nbsp;
            </td>
            <td class="actions">

                <?php
						if ($role_id == ROLE_REGISTRAR) {
							echo $this->Html->link(__('Edit Profile'), array('action' => 'edit', $student['Student']['id']));
						}
						?>

            </td>
            </tr>
            <?php

			endforeach;

				?>

    </table>
    <?php
	}
	?>
</div>