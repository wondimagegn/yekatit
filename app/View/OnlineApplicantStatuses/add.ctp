<?php echo $this->Form->create('OnlineApplicantStatus'); ?>
<div class="box">
    <div
        class="box-header bg-transparent">
        <h6 class="box-title">
            <?php echo __('Add Online Applicant Status'); ?>
        </h6>
    </div>
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">
                <div class="row">
                    <div
                        class="large-6 columns">
                        <?php
                        echo $this->Form->input('online_applicant_id', array('id' => 'ApplicantId', 'onchange' => 'getApplicantDetail()'));
                        ?>
                    </div>
                    <div
                        class="large-6 columns">
                        <?php
                        echo $this->Form->input('status');
                        ?>
                    </div>
                </div>
            </div>
            <div
                class="large-12 columns">
                <?php
                echo $this->Form->input('remark');
                ?>
            </div>
            <div
                class="large-12 columns">

                <?php echo $this->Form->end(array('label' => 'Submit', 'class' => 'tiny radius button bg-blue'));
                ?>
            </div>
            <div class="large-12 columns"
                id="ApplicantStatus">
            </div>

            <div
                class="large-12 columns">
                <?php if (isset($selectedApplicantStatus) && !empty($selectedApplicantStatus)) { ?>

                <table cellpadding="0"
                    cellspacing="0">
                    <tr>
                        <th><?php echo __('S.No'); ?>
                        </th>
                        <th><?php echo __('Status'); ?>
                        </th>
                        <th><?php echo __('Remark'); ?>
                        </th>
                        <th><?php echo __('By'); ?>
                        </th>
                        <th><?php echo __('Checked Date'); ?>
                        </th>

                        <th
                            class="actions">
                            <?php echo __('Actions'); ?>
                        </th>
                    </tr>


                    <?php
                        debug($selectedApplicantStatus);
                        $count = 0;
                        foreach ($selectedApplicantStatus as $k => $selectedStatus) : ?>
                    <tr>
                        <td><?php echo ++$count; ?>
                        </td>

                        <td><?php echo $selectedStatus['OnlineApplicantStatus']['status']; ?>
                        </td>
                        <td><?php echo $selectedStatus['OnlineApplicantStatus']['remark']; ?>
                        </td>

                        <td><?php echo $selectedStatus['User']['Staff'][0]['full_name'] . '(' . $selectedStatus['User']['Staff'][0]['Position']['position'] . ')'; ?>
                        </td>

                        <td><?php
                                    echo date("F j, Y, g:i a", strtotime($selectedStatus['OnlineApplicantStatus']['created']));
                                    ?>
                        </td>

                        <td
                            class="actions">

                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'online_applicant_statuses', 'action' => 'edit', $onlineApplicantStatus['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'online_applicant_statuses', 'action' => 'delete', $onlineApplicantStatus['id']), array('confirm' => __('Are you sure you want to delete # %s?', $onlineApplicantStatus['id']))); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script nonce="<?php echo h($nonce)?>" type="text/javascript">
var image = new Image();
image.src = '/img/busy.gif';

function getApplicantDetail() {
    //serialize form data
    $("#ApplicantStatus")
        .empty().html(
            '<img src="' +
            image.src +
            '" class="displayed" />'
        );
    //get form action
    var formUrl =
        '/onlineApplicantStatuses/get_applicant_detail/';
    $.ajax({
        type: 'post',
        url: formUrl,
        data: $(
                'form'
            )
            .serialize(),
        success: function(
            data,
            textStatus,
            xhr
        ) {

            $('#ApplicantStatus')
                .html(
                    data
                ); // tabs are displayed here
            $(document)
                .foundation(
                    'reflow'
                ); // perform foundation reflow

        },
        error: function(
            xhr,
            textStatus,
            error
        ) {
            alert
                (
                    textStatus
                );
            $("#ApplicantStatus")
                .empty();
        }
    });
    return false;
}
window.onload = function() {

    getApplicantDetail();

}
</script>