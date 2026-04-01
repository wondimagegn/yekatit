<?php echo $this->Form->create('AcceptedStudent', array('action' => 'deattach_curriculum')); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div
                    class="smallheading">
                    <?php if (!isset($auto_approve)) { ?>
                    Please select the
                    academic year, you
                    want to deattach
                    students from
                    curriculum.

                    <?php } ?>


                </div>


                <div
                    onclick="toggleViewFullId('ListStudent')"><?php
																if (!empty($sections)) {
																	echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg'));
																?><span style="font-size:10px; vertical-align:top; font-weight:bold"
                        id="ListSectionTxt">Display
                        Filter</span><?php
																} else {
																	echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg'));
											?><span style="font-size:10px; vertical-align:top; font-weight:bold"
                        id="ListSectionTxt">Hide
                        Filter</span><?php
																}
											?>
                </div>
                <div id="ListStudent"
                    style="display:<?php echo (!empty($autoplacedstudents) ? 'none' : 'display'); ?>">
                    <p>Please select the
                        academic year,
                        you want to
                        deattach
                        students from
                        curriculum.
                    </p>
                    <?php

					echo '<table class="fs16 small_padding" >';
					echo '<tr><td>Academic Year</td><td>' . $this->Form->input('AcceptedStudent.academicyear', array(
						'id' => 'academicyear',
						'label' => false, 'type' => 'select', 'options' => $acyear_array_data,
						'empty' => "--Select Academic Year--", 'selected' => isset($selected_academicyear) ? $selected_academicyear : ''
					)) . '</td><td>Field of study</td><td>' . $this->Form->input('AcceptedStudent.department_id', array('label' => false)) . '</td></tr>';
					echo '<tr><td>Program</td><td>' . $this->Form->input('AcceptedStudent.program_id', array('label' => false)) . '</td><td>Program Type</td><td>' . $this->Form->input('AcceptedStudent.program_type_id', array('label' => false)) . '</td></tr>';

					echo '<tr><td>Name</td><td>' .
						$this->Form->input('AcceptedStudent.name', array('label' => false)) . '</td>
<td>Limit</td><td>' .
						$this->Form->input('AcceptedStudent.limit', array('label' => false)) . '</td></tr>';

					echo '<tr>';
					echo '<td colspan="4">';
					echo $this->Form->Submit(__('Continue'), array(
						'div' => false,
						'name' => 'searchbutton', 'class' => 'tiny radius button bg-blue'
					));
					echo '</td>';
					echo '</tr>';
					echo '</table>';
					?>

                </div>

                <div
                    class="reservedPlaces form">



                    <?php

					if (!empty($autoplacedstudents)) {

						if (!isset($turn_of_approve_button)) {
							echo "<table>";
							echo "</table>";
						}

						$count = 0;

					?>

                    <?php

						echo "<div class='info-message info-box'><span></span><strong>Note:</strong> Deattaching a given student from a curriculum if only necessary. You are advice to deattach the student from the curriculum if s/he is transfered to other department, or has not taken any course from the attached curriculum, if s/he has taken a course, it is required to substitute all the course from the old curriculum to the new curriculum to be consider as taken course.</div>";
						?>

                    <table>
                        <tr>
                            <th colspan=11
                                class="smallheading">
                                <?php echo  __('List of student placed to ' . $departments[$this->request->data['AcceptedStudent']['department_id']] . ''); ?>
                            </th>
                        </tr>
                        <tr>

                            <th><?php echo ('No.'); ?>
                            </th>
                            <th
                                style="padding:0">
                                <?php echo 'Select/ Unselect All <br/>' . $this->Form->checkbox("SelectAll", array('id' => 'select-all', 'checked' => '')); ?>
                            </th>
                            <th><?php echo ('Full Name'); ?>
                            </th>
                            <th><?php echo ('Sex'); ?>
                            </th>
                            <th><?php echo ('Student Number'); ?>
                            </th>

                            <th><?php echo ('Total Result'); ?>
                            </th>

                            <th><?php echo ('Field of study'); ?>
                            </th>
                            <th><?php echo ('Academic Year'); ?>
                            </th>
                            <th><?php echo ('Field of study approval'); ?>
                            </th>
                            <th><?php echo ('Placement Type '); ?>
                            </th>
                            <th><?php echo ('Curriculum'); ?>
                            </th>

                        </tr>
                        <?php
							$i = 0;
							$serial_number = 1;

							foreach ($autoplacedstudents as $acceptedStudent) :
								$class = null;
								if ($i++ % 2 == 0) {
									$class = ' class="altrow"';
								}
							?>
                        <tr<?php echo $class; ?>>

                            <td><?php echo $serial_number++; ?>
                            </td>
                            <td><?php echo $this->Form->checkbox('AcceptedStudent.approve.' . $acceptedStudent['AcceptedStudent']['id'], array('class' => 'checkbox1')); ?>&nbsp;
                            </td>
                            <?php echo $this->Form->hidden('AcceptedStudent.' . $count . '.id', array('value' => $acceptedStudent['AcceptedStudent']['id'])); ?>
                            <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;
                            </td>
                            <td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;
                            </td>
                            <td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;
                            </td>

                            <td><?php echo $acceptedStudent['AcceptedStudent']['total_results']; ?>&nbsp;
                            </td>

                            <td><?php echo $acceptedStudent['Department']['name']; ?>&nbsp;
                            </td>
                            <td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;
                            </td>
                            <td><?php echo $acceptedStudent['AcceptedStudent']['Placement_Approved_By_Department'] == 1 ? 'Approved By Department' : 'Not Approved By Department'; ?>&nbsp;
                            </td>

                            <td><?php echo $acceptedStudent['AcceptedStudent']['placementtype']; ?>&nbsp;
                            </td>
                            <td><?php echo $acceptedStudent['Curriculum']['curriculum_detail']; ?>&nbsp;
                            </td>
                            </tr>

                            <?php
								$count++;

							endforeach;

								?>
                            <?php
								echo '<tr><td>' . $this->Form->Submit(__('Deattach'), array(
									'div' => false,
									'name' => 'deaattach', 'class' => 'tiny radius button bg-blue'
								)) . '</td></tr>';
								?>
                    </table>

                    <?php

					}

					?>
                </div>
            </div>
            <!-- end of columns 12 -->
        </div> <!-- end of row -->
    </div> <!-- end of box-body -->
</div><!-- end of box -->

<?php echo $this->Form->end(); ?>
<script type="text/javascript">
function toggleView(obj) {
    if ($('#c' + obj.id).css(
            "display") == 'none')
        $('#i' + obj.id).attr("src",
            '/img/minus2.gif');
    else
        $('#i' + obj.id).attr("src",
            '/img/plus2.gif');
    $('#c' + obj.id).toggle("slow");
}

function toggleViewFullId(id) {
    if ($('#' + id).css("display") ==
        'none') {
        $('#' + id + 'Img').attr("src",
            '/img/minus2.gif');
        $('#' + id + 'Txt').empty();
        $('#' + id + 'Txt').append(
            'Hide Filter');
    } else {
        $('#' + id + 'Img').attr("src",
            '/img/plus2.gif');
        $('#' + id + 'Txt').empty();
        $('#' + id + 'Txt').append(
            'Display Filter');
    }
    $('#' + id).toggle("slow");
}
</script>