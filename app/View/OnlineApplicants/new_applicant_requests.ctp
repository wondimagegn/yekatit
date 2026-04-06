<?php
echo $this->Form->create('OnlineApplicant', array('novalidate' => true));


?>

<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">
                <h3><?php echo __('New Registered Applicant List'); ?>
                </h3>

                <?php if (isset($applicant_lists) && !empty($applicant_lists)) {


                ?>


                <table cellpadding="0"
                    cellspacing="0"
                    style="width: 100%;">
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
                            <th><?php echo $this->Paginator->sort('applicationnumber', 'Application Number'); ?>
                            </th>
                            <th><?php echo $this->Paginator->sort('full_name', 'Full name'); ?>
                            </th>
                            <th><?php echo $this->Paginator->sort('program_id', 'Study Level'); ?>
                            </th>
                            <th><?php echo $this->Paginator->sort('program_type_id', 'Enrollement Type'); ?>
                            </th>
                            <th><?php echo $this->Paginator->sort('academic_year', 'Academic Year'); ?>
                            </th>

                            <th><?php echo $this->Paginator->sort('department_id', 'Field of Study'); ?>
                            </th>
                            <th><?php echo $this->Paginator->sort('college_id', 'Faculty'); ?>
                            </th>

                            <th><?php echo $this->Paginator->sort('campus_id', 'Campus'); ?>
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

                            foreach ($applicant_lists as $applicant) : ?>
                        <tr>
                            <td onclick="toggleView(this)"
                                id="<?php echo $count; ?>">
                                <?php echo $this->Html->image('plus2.gif', array('id' => 'i' . $count)); ?>
                            </td>

                            <td><?php echo h($count); ?>&nbsp;
                            </td>
                            <td><?php echo $applicant['OnlineApplicant']['applicationnumber']; ?>&nbsp;
                            </td>
                            <td><?php echo ucwords(h($applicant['OnlineApplicant']['full_name'])); ?>
                            </td>
                            <td><?php echo h($applicant['Program']['name']); ?>&nbsp;
                            </td>

                            <td><?php echo h($applicant['ProgramType']['name']); ?>&nbsp;
                            </td>
                            <td><?php echo h($applicant['OnlineApplicant']['academic_year']); ?>&nbsp;
                            </td>

                            <td><?php echo h($applicant['Department']['name']); ?>&nbsp;
                            </td>


                            <td><?php echo h($applicant['College']['name']); ?>&nbsp;
                            </td>
                            <td><?php echo h($applicant['College']['Campus']['name']); ?>&nbsp;
                            </td>





                            <td
                                class="actions">

                                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $applicant['OnlineApplicant']['id'])); ?>
                                <?php echo $this->Html->link(__('Update Status'), array('controller' => 'OnlineApplicantStatuses', 'action' => 'add', $applicant['OnlineApplicant']['id'])); ?>





                            </td>
                        </tr>

                        <tr id="c<?php echo $count; ?>"
                            style="display:none">
                            <td
                                colspan="11">
                                <?php
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
                        echo $this->Paginator->counter(array(
                            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                        ));
                        ?> </p>
                <div class="paging">
                    <?php
                        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => ''));
                        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                        ?>
                </div>
                <?php } else { ?>
                There is no new
                applicants in the system
                <?php } ?>
            </div>
            <!-- end of columns 12 -->
        </div> <!-- end of row -->
    </div> <!-- end of box-body -->
</div><!-- end of box -->

<?php $this->Form->end();
?>



<div class="row">
    <div class="large-12 columns">


        <div id="myModalInvoice"
            class="reveal-modal"
            data-reveal>

        </div>


    </div>
</div>

<script >
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