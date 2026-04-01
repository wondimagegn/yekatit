<?php //echo $this->Html->script('jquery-1.6.2.min'); 
?>
<?php //echo $this->Html->script('jquery-selectall'); 
?>

<?php echo $this->Form->create('AcceptedStudent', array('action' => 'generate')); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div>
                    <?php if (!isset($show_list_generated)) { ?>
                    <div
                        class="smallheading">
                        <?php echo __('Generate student number') ?>
                    </div>
                    <div
                        class="centeralign_smallheading">
                        <?php echo __('Tables:Summary of students those haven\'t student identification') ?>
                    </div>
                    <table>
                        <tbody>
                            <tr>
                                <?php
									$college_count = count($colleges);
									$count_program = count($programs);
									$count_program_type = count($programTypes);
									debug($count_program_type);
									debug($college_count);
									for ($i = 1; $i <= $college_count; $i++) {
										echo '<td><table style="border: #CCC solid 1px"><tr><td class="smallheading" colspan="3">' .
											$colleges[$i] . '</B></td></tr>'; //Display College name
										echo '<tr><th style="border-right: #CCC solid 1px">' . "ProgramType/ Program" . '</th>'; //Display ProgramType/Program label
										foreach ($programs as $kp => $vp) {
											echo '<th style="border-right: #CCC solid 1px">' . $vp . '</th>';
										}
										echo '</tr>';
										for ($j = 1; $j <= $count_program_type; $j++) {
											if (isset($programTypes[$j])) {
												echo '<tr><td style="border-right: #CCC solid 1px">' .
													$programTypes[$j] . '</td>';
												for ($k = 1; $k <= $count_program; $k++) {

													if (isset($programs[$k])) {
														echo '<td style="border-right: #CCC solid 1px">' . $data[$colleges[$i]][$programs[$k]][$programTypes[$j]] . '</td>';
													}
												}
												echo '</tr>';
											}
										}
										echo '</table></td>';
										if (($i % 3) == 0) {
											echo '<tr></tr>';
										}
									}
									?>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                    <?php if (!isset($show_list_generated)) { ?>
                    <table
                        cellpadding="0"
                        cellspacing="0">
                        <tr>
                            <?php
									echo '<td>' . $this->Form->input('AcceptedStudent.academicyear', array(
										'id' => 'academicyear',
										'label' => 'Academic Year', 'type' => 'select', 'options' => $acyear_array_data,
										'empty' => "--Select Academic Year--", 'selected' => isset($selectedsacdemicyear) ? $selectedsacdemicyear : ''
									)) . '</td>';
									echo '<td>' . $this->Form->input('AcceptedStudent.college_id', array(
										'empty' => "--Select Department--", 'label' => 'Department',
										'onchange' => 'getDepartments()', 'id' => 'ajax_college_id'
									)) . '</td></tr>';

									echo '<tr><td>' . $this->Form->input('AcceptedStudent.program_id', array('empty' => "--Select Program--")) . '</td>';
									echo '<td>' . $this->Form->input('AcceptedStudent.program_type_id', array('empty' => "--Select Program Type--")) . '</td></tr>';

									echo '<tr><td>' . $this->Form->input('AcceptedStudent.limit', array(
										'type' => 'number',
										'style' => 'width:100px;'
									)) . '</td>';
									echo '<td>' . $this->Form->input('AcceptedStudent.department_id', array('empty' => "--Select Field of study--", 'label' => 'Field of study', 'id' => 'ajax_department_id', 'required' => true)) . '</td>';

									echo '</tr>';
									?>
                        <tr>
                            <td><?php echo $this->Form->submit('Search', array('name' => 'search', 'div' => 'false', 'class' => 'tiny radius button bg-blue')); ?>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>
                    <?php
						if (!empty($acceptedStudents)) {
						?>
                    <table cellpadding=0
                        cellspacing=0>
                        <tbody>
                            <tr>
                                <th
                                    style="padding:0">
                                    <?php echo 'Select/Unselect All <br/>' . $this->Form->checkbox(null, array('id' => 'select-all', 'checked' => '')); ?>
                                </th>


                                <th
                                    style="width:30%">
                                    <?php echo $this->Paginator->sort('full_name', 'Full Name'); ?>
                                </th>
                                <th
                                    style="width:5%">
                                    <?php echo $this->Paginator->sort("sex", 'Sex'); ?>
                                </th>
                                <th
                                    style="width:5%">
                                    <?php echo $this->Paginator->sort("studentnumber", "Student Number"); ?>
                                </th>
                                <th
                                    style="width:5%">
                                    <?php echo $this->Paginator->sort('gpa', "GPA"); ?>
                                </th>
                                <th
                                    style="width:1%">
                                    <?php echo $this->Paginator->sort('college_id', 'Stream'); ?>
                                </th>
                                <th
                                    style="width:11%">
                                    <?php echo $this->Paginator->sort('department_id', 'Field of study'); ?>
                                </th>
                                <th
                                    style="width:5%">
                                    <?php echo $this->Paginator->sort('program_type_id', 'Program Type'); ?>
                                </th>
                                <th
                                    style="width:9%">
                                    <?php echo $this->Paginator->sort("attended_stream", "Stream Attended"); ?>
                                </th>

                                <th
                                    style="width:5%">
                                    <?php echo $this->Paginator->sort("university_attended", "University Attended"); ?>
                                </th>


                            </tr>
                            <?php
									$i = 0;
									foreach ($acceptedStudents as $acceptedStudent) :
										$class = null;
										if ($i++ % 2 == 0) {
											$class = ' class="altrow"';
										}
									?>
                            <tr<?php echo $class; ?>>
                                <td><?php echo $this->Form->checkbox('AcceptedStudent.generate.' . $acceptedStudent['AcceptedStudent']['id'], array('class' => 'checkbox1')); ?>&nbsp;
                                </td>
                                <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;
                                </td>
                                <td><?php echo ucwords($acceptedStudent['AcceptedStudent']['sex']); ?>&nbsp;
                                </td>
                                <td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;
                                </td>
                                <td><?php echo $acceptedStudent['AcceptedStudent']['gpa']; ?>&nbsp;
                                </td>
                                <td>
                                    <?php echo $this->Html->link($acceptedStudent['College']['shortname'], array('controller' => 'colleges', 'action' => 'view', $acceptedStudent['College']['id'])); ?>
                                </td>
                                <td>
                                    <?php echo $this->Html->link($acceptedStudent['Department']['name'], array('controller' => 'departments', 'action' => 'view', $acceptedStudent['Department']['id'])); ?>
                                </td>
                                <td>
                                    <?php echo $this->Html->link($acceptedStudent['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $acceptedStudent['ProgramType']['id'])); ?>
                                </td>

                                <td><?php echo $acceptedStudent['AcceptedStudent']['university_attended']; ?>&nbsp;
                                </td>

                                <td><?php echo $acceptedStudent['AcceptedStudent']['attended_stream']; ?>&nbsp;
                                </td>



                                </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                    <table>
                        <tbody>

                            <tr>
                                <td>
                                    <?php
											echo $this->Form->Submit('Generate ID', array('name' => 'generateid', 'div' => 'false', 'class' => 'tiny radius button bg-blue'));

											?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>
                        <?php
								echo $this->Paginator->counter(array(
									'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
								));
								?> </p>

                    <div class="paging">
                        <?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class' => 'disabled')); ?>
                        |
                        <?php echo $this->Paginator->numbers(); ?>
                        |
                        <?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled')); ?>
                    </div>
                    <?php
						} else if (empty($acceptedStudents) && !($isbeforesearch)) {
							echo "<div class='info-box info-message'> <span></span> No Accepted students without student identification in these selected criteria</div>";
						}
						?>
                </div>
            </div>
            <!-- end of columns 12 -->
        </div>
        <!--- end of row -->
    </div> <!-- end of box-body -->
</div><!-- end of box -->
<?php

echo $this->Form->end();
?>

<script type="text/javascript">
$(document).ready(function() {

    getDepartments();

});
</script>
<script type="text/javascript">
function getDepartments() {
    //serialize form data
    var col = $("#ajax_college_id")
    .val();
    $("#ajax_department_id").attr(
        'disabled', true);
    $("#ajax_department_id").empty();
    $("#ajax_year_level_id").empty();
    //get form action
    var formUrl =
        '/course_schedules/get_departments/' +
        col;
    $.ajax({
        type: 'get',
        url: formUrl,
        data: col,
        success: function(data,
            textStatus, xhr
            ) {
            $("#ajax_department_id")
                .attr(
                    'disabled',
                    false);
            $("#ajax_department_id")
                .empty();
            $("#ajax_department_id")
                .append(
                    data);
        },
        error: function(xhr,
            textStatus,
            error) {
            alert(
                textStatus);
        }
    });
    return false;
}
</script>