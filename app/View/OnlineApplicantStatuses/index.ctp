<div class="box">
<div class="box-header bg-transparent">
    <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
        <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Online Applicant Statuses'); ?></span>
    </div>
</div>
<div class="box-body">
    <div class="row">
        <div class="large-12 columns">
            <?php
            echo $this->Form->create('OnlineApplicantStatus', array(
                    'action' => 'search', 'novalidate' => true,
                    'method' => 'get'
            ));

            ?>

    <?php
    $yFrom = Configure::read('Calendar.officialTranscriptStartYear');
    $yTo = date('Y');
    ?>

    <table cellspacing="0"
        cellpadding="0" class="fs13">

        <tr>
            <td>Tracking Number:</td>
            <td><?php echo $this->Form->input('applicationnumber', array('label' => false)); ?>
            </td>

            <td>Name:</td>
            <td>
                <?php echo $this->Form->input('name', array('label' => false)); ?>
            </td>
        </tr>
        <tr>
            <td>Request From:</td>
            <td><?php
                echo $this->Form->input('request_from', array('label' => false, 'type' => 'date', 'minYear' => $yFrom, 'maxYear' => $yTo, 'style' => 'width:70px'));
                ?></td>
            <td>Request To:</td>
            <td><?php
                echo $this->Form->input('request_to', array(
                    'label' => false, 'type' => 'date',
                    'minYear' => $yFrom, 'maxYear' => $yTo, 'style' => 'width:70px'
                ));
                ?></td>
        </tr>

        <tr>
            <td colspan="6">
                <?php

                echo $this->Form->submit(__('List Status', true), array(
                    'name' => 'listOfficialTranscriptRequestStatus',
                    'class' => 'tiny radius button bg-blue',
                    'div' => false
                ));

                 ?>
            </td>
        </tr>
    </table>
    <?php if (isset($onlineApplicantStatuses) && !empty($onlineApplicantStatuses)) {

    ?>
            <div style="overflow-x:auto;">

    <table cellpadding="0"
        cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id','S.No'); ?>
                </th>
                <th><?php echo $this->Paginator->sort('online_applicant_id', 'Applicant'); ?>
                </th>
                <th><?php echo $this->Paginator->sort('online_applicant_id', 'Application Number'); ?>
                </th>
                <th><?php echo $this->Paginator->sort('status', 'Status'); ?>
                </th>
                <th><?php echo $this->Paginator->sort('remark', 'Remark'); ?>
                </th>
                <th><?php echo $this->Paginator->sort('user_id', 'By'); ?>
                </th>
                <th><?php echo $this->Paginator->sort('created', 'Status Date'); ?>
                </th>
                <th class="actions">
                    <?php echo __('Actions'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = $this->Paginator->counter('%start%');
                foreach ($onlineApplicantStatuses as $onlineAppl) : ?>
            <tr>
                <td><?php echo $count; ?>
                </td>
                <td>
                    <?php echo $this->Html->link($onlineAppl['OnlineApplicant']['full_name'], array('controller' => 'online_applicants', 'action' => 'view', $onlineAppl['OnlineApplicant']['id'])); ?>
                </td>
                <td>
                    <?php
                    echo  $onlineAppl['OnlineApplicant']['applicationnumber'];
                    ?>
                </td>
                <td><?php echo h($onlineAppl['OnlineApplicantStatus']['status']); ?>&nbsp;
                </td>
                <td><?php echo h($onlineAppl['OnlineApplicantStatus']['remark']); ?>&nbsp;
                </td>
                <td><?php echo h($onlineAppl['User']['Staff'][0]['full_name']); ?>&nbsp;
                </td>
                <td><?php echo date("F j, Y, g:i a", strtotime($onlineAppl['OnlineApplicantStatus']['modified'])); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $onlineAppl['OnlineApplicantStatus']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $onlineAppl['OnlineApplicantStatus']['id'])); ?>
                    <a
                            onclick="deleteStatus(<?php echo h($onlineAppl['OnlineApplicantStatus']['id']); ?>)">
                        <?php echo __('Delete'); ?>
                    </a>
                    <?php

                    ?>
                </td>
            </tr>
            <?php
                $count++;
                endforeach; ?>
        </tbody>
    </table>

            </div>
        <hr>
        <div class="row">
            <div class="large-5 columns">
                <?= $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total'))); ?>
            </div>
            <div class="large-7 columns">
                <div class="pagination-centered">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('<< ' . __(''), array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?> <?= $this->Paginator->numbers(array('separator' => '', 'tag' => 'li')); ?> <?= $this->Paginator->next(__('') . ' >>', array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?>
                    </ul>
                </div>
            </div>
        </div>

    <?php } ?>
            <?= $this->Form->end(); ?>
</div>
    </div>
</div>
</div>
<script>
    function deleteStatus(statusId) {
        if (confirm('Delete online applicant status for ' + statusId + '?')) {
            $.ajax({
                url: '<?php echo $this->Html->url(['controller' => 'OnlineApplicantStatuses',
                        'action' => 'delete']); ?>/' + statusId,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the payment.');
                }
            });
        }
    }


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
