<?php ?>
<script type='text/javascript'>
$(document).ready(function() {
    $("#CollegeID").change(
        function() {
            //serialize form data
            $("#DepartmentID")
                .attr(
                    'disabled',
                    true);
            $("#CollegeID")
                .attr(
                    'disabled',
                    true);
            var cid = $(
                "#CollegeID"
                ).val();
            //get form action
            var formUrl =
                '/departments/get_department_combo/' +
                cid;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: cid,
                success: function(
                    data,
                    textStatus,
                    xhr
                    ) {
                    $("#DepartmentID")
                        .attr(
                            'disabled',
                            false
                            );
                    $("#CollegeID")
                        .attr(
                            'disabled',
                            false
                            );
                    $("#DepartmentID")
                        .empty();
                    $("#DepartmentID")
                        .append(
                            '<option>No Field of study</option>'
                            );
                    $("#DepartmentID")
                        .append(
                            data
                            );

                },
                error: function(
                    xhr,
                    textStatus,
                    error
                    ) {
                    alert
                        (
                            textStatus);
                }
            });

            return false;
        });
});
</script>

<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <div
                    class="acceptedStudents form">
                    <?php echo $this->Form->create('AcceptedStudent'); ?>

                    <div
                        class='smallheading'>
                        <?php echo __('Add Accepted Student'); ?>
                    </div>
                    <p class="fs13">
                        <strong>Important
                            Note:</strong>
                        The system
                        display current
                        academic year
                        and one year
                        plus in the
                        future (Academic
                        year start from
                        September 1 and
                        ends in August
                        31. )

                        <?php
						echo $this->Form->input('id');
						?>

                    </p>
                    <?php
					echo '<table><tr>';
					echo '<td>';
					echo "<table><tbody>";
					echo "<tr><td>" . $this->Form->input('first_name') . "</td></tr>";

					echo "<tr><td>" . $this->Form->input('middle_name') . "</td></tr>";;

					echo "<tr><td>" . $this->Form->input('last_name') . "</td></tr>";

					$options = array('male' => 'Male', 'female' => 'Female');
					$attributes = array('legend' => false, 'separator' => "<br/>");

					echo '<tr><td style="padding-left:150px;">' . $this->Form->input('sex', array('options' => $options, 'type' => 'radio', 'legend' => false, 'separator' => '<br/>', 'label' => false)) . '</td></tr>';
					//echo $this->Form->input('studentnumber');

					echo '<tr><td>' . $this->Form->input('gpa', array('label' => 'GPA', 'style' => 'width:50px')) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('region_id', array('style' => 'width:200px')) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('woreda', array('style' => 'width:200px')) . '</td></tr>';
					echo '</tbody>';
					echo '</table>';
					echo '</td>';
					echo '<td>';
					echo '<table>';
					echo '<tr><td>' . $this->Form->input('academicyear', array(
						'id' => 'academicyear',
						'label' => 'Academic Year', 'style' => 'width:120px', 'type' => 'select', 'options' => $acyear_array_data,
						'selected' => isset($this->request->data['AcceptedStudent']['academicyear'])
							&& !empty($this->request->data['AcceptedStudent']['academicyear']) ? $this->request->data['AcceptedStudent']['academicyear'] : $defaultacademicyear
					)) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('college_id', array(
						'label' => 'Deparment', 'id' => 'CollegeID', 'empty' => '--select department--',
						'style' => 'width:200px'
					)) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('department_id', array('empty' => "No field of study", 'id' => 'DepartmentID', 'label' => 'Field of study', 'style' => 'width:200px')) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('program_id', array('style' => 'width:150px')) . '</td></tr>';

					echo  '<tr><td>' . $this->Form->input('program_type_id', array('style' => 'width:150px')) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('university_attended', array('style' => 'width:200px')) . '</td></tr>';
					echo '<tr><td>' . $this->Form->input('attended_stream', array('style' => 'width:200px')) . '</td></tr>';

					echo "</tbody></table>";
					echo '</td></tr>';
					echo '</table>';
					?>
                    <?php echo $this->Form->end(array(
						'label' => __('Submit'),
						'class' => 'tiny radius button bg-blue'
					)); ?>
                </div>
            </div>
            <!-- end of columns 12 -->
        </div>
        <!--- end of row -->
    </div> <!-- end of box-body -->
</div><!-- end of box -->