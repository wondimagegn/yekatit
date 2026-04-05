<?php
echo $this->Form->create('OnlineApplicant', array('novalidate' => true));
?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">
                <h3>
                    <?php echo __('Online Applicant Request List'); ?>
                </h3>
                <?php
                $yFrom = Configure::read('Calendar.officialTranscriptStartYear');
                $yTo = date('Y');
                ?>

                <div
                    onclick="toggleViewFullId('ListOnlineApplicant')">
                    <?php
                    if (!empty($onlineApplicants)) {
                        echo $this->Html->image('plus2.gif', array('id' => 'ListOnlineApplicantImg'));
                        ?><span
                            style="font-size:10px; vertical-align:top; font-weight:bold"
                            id="ListOnlineApplicantTxt">Display
                            Filter</span>
                        <?php
                    } else {
                        echo $this->Html->image('minus2.gif', array('id' => 'ListOnlineApplicantImg'));
                        ?><span
                            style="font-size:10px; vertical-align:top; font-weight:bold"
                            id="ListOnlineApplicantTxt">Hide
                            Filter</span>
                        <?php
                    }
                    ?>
                </div>
                <div id="ListOnlineApplicant"
                    style="display:<?php echo (!empty($onlineApplicants) ? 'none' : 'display'); ?>">

                    <table
                        class="fs13 small_padding"
                        style="margin-bottom:0px">

                        <tr>
                            <td
                                style="width:13%">
                                Academic
                                Year:
                            </td>
                            <td
                                style="width:37%">
                                <?php echo $this->Form->input(
                                    'academic_year',
                                    array(
                                        'label' => 'Academic Year',
                                        'required' => false,
                                        'label' => '',
                                        'type' => 'select',
                                        'options' => $acyear_array_data
                                    )
                                ); ?>
                            </td>
                            <td
                                style="width:13%">
                                Semester:
                            </td>
                            <td
                                style="width:37%">
                                <?php echo $this->Form->input(
                                        'applicationnumber',
                                        array('label' => '', 'required' => false)
                                ); ?>
                            </td>
                        </tr>


                        <tr>
                            <td
                                style="width:13%">
                                Campus:
                            </td>
                            <td
                                style="width:37%">

                                <?= $this->Form->input('campus_id', [

                                        'empty' => '-- Select Campus --',
                                        'id' => 'campus_id' ,  // ← This must be "campus_id"
                                        'label' => '',
                                        'class' => 'radius'
                                ]); ?>
                            </td>
                            <td
                                style="width:13%">
                                <label>Field of Study <span class="required">*</span></label>
                            </td>
                            <td
                                style="width:37%">


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



                        </tr>







                        <tr>
                            <td
                                style="width:13%">
                                Applicant
                                Status:
                            </td>
                            <td
                                style="width:37%">
                                <?php echo $this->Form->input('statuses', array('id' => 'statuses', 'class' => 'fs13', 'label' => false)); ?>
                            </td>
                            <td
                                style="width:13%">
                                Limit

                            </td>
                            <td
                                style="width:37%">
                                <?php echo $this->Form->input('limit', array('id' => 'Limit', 'class' => 'fs13', 'label' => false)); ?>

                                <?php echo $this->Form->hidden('page', array('value' => 1)); ?>

                            </td>



                        </tr>
                        <tr>


                            <td
                                style="width:13%">
                                Name:
                            </td>
                            <td
                                style="width:37%">
                                <?php echo $this->Form->input('name', array('label' => false)); ?>
                            </td>
                        </tr>




                        <tr>
                            <td
                                colspan="4">
                                <?php echo $this->Form->submit(
                                    __('List Requests', true),
                                    array(
                                        'name' => 'listOnlineApplicant',
                                        'class' => 'tiny radius button bg-blue',
                                        'div' => false
                                    )
                                ); ?>
                            </td>
                        </tr>
                    </table>
                </div>
	            <?php
	            echo $this->Form->end();
	            ?>

                <?php if (isset($onlineApplicants) && !empty($onlineApplicants)) { ?>
                    <?php
                    echo $this->Form->submit(__('View PDF', true), array('name' => 'viewPDF', 'class' => 'tiny radius button bg-blue', 'div' => false));
                    ?>

                    <table cellpadding="0"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th
                                    style="width:2%">
                                    &nbsp;
                                </th>
                                <th
                                    style="width:2%">
                                    N<u>o</u>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('applicationnumber', 'Application Number'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('full_name', 'Full name'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('year_of_experience', 'Year of experience'); ?>
                                </th>

                                <th>
                                    <?php echo $this->Paginator->sort('college_id', 'Department'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('department_id', 'Field of Study'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('program_id', 'Study Level'); ?>
                                </th>
                                <th>
                                    <?php echo $this->Paginator->sort('program_type_id', 'Admission Type'); ?>
                                </th>

                                <th
                                    class="actions">
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $notPaidCount = 0;

                            foreach ($onlineApplicants as $onlineApplicant): ?>


                                <tr>
                                    <td onclick="toggleView(this)"
                                        id="<?php echo $count; ?>">
                                        <?php echo $this->Html->image('plus2.gif', array('id' => 'i' . $count)); ?>
                                    </td>

                                    <td>
                                        <?php echo h($count); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['OnlineApplicant']['applicationnumber']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['OnlineApplicant']['full_name']); ?>
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['OnlineApplicant']['year_of_experience']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['College']['name']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['Department']['name']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['Program']['name']); ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo h($onlineApplicant['ProgramType']['name']); ?>&nbsp;
                                    </td>

                                    <td
                                        class="actions">
                                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $onlineApplicant['OnlineApplicant']['id'])); ?>

                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $onlineApplicant['OnlineApplicant']['id'])); ?>
                                        <?php echo $this->Html->link(__('Update Status'), array('controller' => 'OnlineApplicantStatuses', 'action' => 'add', $onlineApplicant['OnlineApplicant']['id'])); ?>
                                        <?php 
                                        //echo $this->Form->postLink(__('Cancel Application'), array('action' => 'delete', $onlineApplicant['OnlineApplicant']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $onlineApplicant['OnlineApplicant']['id'])));
                                        ?>
                                        <?php 

                                        echo $this->Form->postLink('Delete', array('controller'=>'OnlineApplicants','action' => 'delete',$onlineApplicant['OnlineApplicant']['id']),
                                        array(
                                        'id'=>"delete_form_".$onlineApplicant['OnlineApplicant']['id'],
                                        'confirm'=>'Are you sure you want to delete '
                                        )
                                        );
                                        ?>


                                    </td>
                                </tr>

                                <tr id="c<?php echo $count; ?>"
                                    style="display:none">
                                    <td
                                        colspan="10">
                                        <?php
                                        $applicant = $onlineApplicant;
                                        $this->set(compact('applicant'));
                                        echo $this->element('applicant_profile');
                                        ?>
                                    </td>
                                </tr>

                                <?php

                                $count++;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <p>
                        <?php
                        echo $this->Paginator->counter(
                            array(
                                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            )
                        );
                        ?>
                    </p>
                    <div class="paging">
                        <?php
                        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => ''));
                        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                        ?>
                    </div>
                <?php } ?>
            </div>
            <!-- end of columns 12 -->
        </div> <!-- end of row -->
    </div> <!-- end of box-body -->
</div><!-- end of box -->

<?php $this->Form->end();
?>


<script >
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

<script>
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
</script>
