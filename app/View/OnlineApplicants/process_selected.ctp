<?php echo $this->Form->create('OnlineApplicant'); ?>

<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">

                <?php if (!isset($admitsearch)) : ?>

                    <div class="smallheading">
                        Select online admit students to entry process for SIS.<br>
                        Please don't forget to generate student number, and admit them for department to see them for curriculum attachment and section placement.
                    </div>

                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <?php
                                echo $this->Form->input('OnlineApplicant.academicyear', [
                                        'id'     => 'academicyear',
                                        'label'  => 'Academic Year',
                                        'type'   => 'select',
                                        'options'=> $acyear_array_data,
                                        'empty'  => '--Select Academic Year--',
                                        'selected' => isset($defaultacademicyear) ? $defaultacademicyear : ''
                                ]);
                                ?>
                            </td>
                            <td>
                                <?= $this->Form->input('campus_id', [

                                        'empty' => '-- Select Campus --',
                                        'id' => 'campus_id' ,  // ← This must be "campus_id"
                                        'label' => 'Campus',
                                        'class' => 'radius'
                                ]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Field of Study <br/>
                                <select name="data[OnlineApplicant][department_id]" id="department_id" class="radius"
                                        required <?= empty($this->request->data['OnlineApplicant']['department_id']) ? 'disabled' : '' ?>>
                                    <?php if (!empty($this->request->data['OnlineApplicant']['department_id'])): ?>
                                        <option value="<?= h($this->request->data['OnlineApplicant']['department_id']) ?>">
                                            <?= h($departments[$this->request->data['OnlineApplicant']['department_id']]) ?>
                                        </option>
                                    <?php else: ?>
                                        <option>-- Select Campus First --</option>
                                    <?php endif; ?>
                                </select>
                            </td>
                            <td><?php echo $this->Form->input('OnlineApplicant.program_id', ['label' => 'Study Type']); ?></td>

                        </tr>
                        <tr>
                            <td><?php echo $this->Form->input('OnlineApplicant.program_type_id', ['label' => 'Enrollment Type']); ?></td>
                            <td><?php echo $this->Form->input('OnlineApplicant.name'); ?></td>
                        </tr>
                        <tr>

                            <td colspan="2"><?php echo $this->Form->input('OnlineApplicant.limit', ['type' => 'number']); ?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                echo $this->Form->submit('Continue', [
                                        'div'   => false,
                                        'name'  => 'getonlineapplicant',
                                        'class' => 'tiny radius button bg-blue'
                                ]);
                                ?>
                            </td>
                        </tr>
                    </table>

                <?php endif; ?>

                <?php if (!empty($onlineApplicants)) : ?>

                    <table>
                        <tr>
                            <th colspan="8" class="smallheading">
                                <?php echo __('Select List of student you want to batch admit.'); ?>
                            </th>
                        </tr>
                        <tr>
                            <th>No.</th>
                            <th style="padding:0">
                                Select / Unselect All<br>
                                <?php echo $this->Form->checkbox('SelectAll', ['id' => 'select-all']); ?>
                            </th>
                            <th>Application Number</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Entrance Result</th>
                            <th>Department</th>
                            <th>Academic Year</th>
                        </tr>

                        <?php
                        $i = 0;
                        $serial_number = 1;
                        $notPaid = 0;
                        $paid = 0;
                        echo '<pre>';
                        print_r($onlineApplicants);
                        echo '</pre>';

                        foreach ($onlineApplicants as $onlineApplicant):
                            $class = ($i++ % 2 == 0) ? ' class="altrow"' : '';



                            if ($onlineApplicant['Invoice'][0]['status']=='Paid' ||$onlineApplicant['Invoice'][0]['status']=='Approved' ):
                                $paid++;
                                ?>
                                <tr<?php echo $class; ?>>
                                    <td><?php echo $serial_number++; ?></td>
                                    <td>
                                        <?php
                                        echo $this->Form->checkbox('OnlineApplicant.approve.' . $onlineApplicant['OnlineApplicant']['id'], [
                                                'class' => 'checkbox1'
                                        ]);
                                        ?>
                                    </td>
                                    <td><?php echo h($onlineApplicant['OnlineApplicant']['applicationnumber']); ?></td>
                                    <td><?php echo h($onlineApplicant['OnlineApplicant']['full_name']); ?></td>
                                    <td><?php echo h($onlineApplicant['OnlineApplicant']['gender']); ?></td>
                                    <td><?php echo h($onlineApplicant['OnlineApplicant']['entrance_result']); ?></td>
                                    <td><?php echo h($onlineApplicant['Department']['name']); ?></td>
                                    <td><?php echo h($onlineApplicant['OnlineApplicant']['academic_year']); ?></td>
                                </tr>
                            <?php
                            else:
                                $notPaid++;
                            endif;
                        endforeach;
                        ?>

                        <?php if ($paid): ?>
                            <tr>
                                <td colspan="8">
                                    <?php
                                    echo $this->Form->submit('Process', [
                                            'div'   => false,
                                            'name'  => 'processSelected',
                                            'class' => 'tiny radius button bg-blue'
                                    ]);
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($notPaid): ?>
                            <tr>
                                <td colspan="8">
                                    <h5>There are <?php echo $notPaid; ?> online applicants whose documents are checked and complete but payment not approved by finance yet!</h5>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>

                <?php endif; ?>

                <?php
                echo '<pre>';
                print_r($this->request->data);
                echo '</pre>';
                echo $this->Form->end(); ?>

            </div><!-- large-12 -->
        </div><!-- row -->
    </div><!-- box-body -->
</div><!-- box -->


<script>

    // ──────────────────────────────────────────────────────
    // 1. AJAX: Load Departments based on Campus + Calendar Rules
    // ──────────────────────────────────────────────────────

    let selectedDepartment = <?= json_encode(!empty($this->request->data['OnlineApplicant']['department_id']) ?
            $this->request->data['OnlineApplicant']['department_id']:'') ?>;
    $('#campus_id').on('change', function() {
        const campusId = $(this).val();
        const $dept = $('#department_id');

        if (!campusId) {
            $dept.html('<option>-- Select Campus First --</option>').prop('disabled', true);
            return;
        }

        $.post('/onlineApplicants/get_campus_department_combo', $('form').serialize(), function(html) {
            $dept.html(html).prop('disabled', false);

            // Restore previously selected department if available
            if (selectedDepartment && $dept.find('option[value="' + selectedDepartment + '"]').length) {
                $dept.val(selectedDepartment);
            }
        }).fail(() => {
            $dept.html('<option>Error loading departments</option>').prop('disabled', true);
        });
    });
    // Optional: Auto-load departments if campus already selected (e.g., edit mode)
    $(document).ready(function () {
        if ($('#campus_id').val()) {
            $('#campus_id').trigger('change');
        }

    });

</script>