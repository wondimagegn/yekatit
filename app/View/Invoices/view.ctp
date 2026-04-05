
<div class="box">
    <!-- Payment Form -->
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Invoice - Details #'). $invoice['Invoice']['receipt_code']; ?></span>
        </div>
        <div class="box-tools pull-right">
            <?php echo $this->Html->link(
                    '<i class="fa fa-arrow-left"></i> Back to List',
                    array('action' => 'index'),
                    array('class' => 'btn btn-default btn-sm', 'escape' => false)
            ); ?>
            <?php if ($invoice['Invoice']['remaining'] > 0 ): ?>
                <?php echo $this->Html->link(
                        '<i class="fa fa-money"></i> Record Payment',
                        array('action' => 'recordPayment', $invoice['Invoice']['id']),
                        array('class' => 'btn btn-primary btn-sm', 'escape' => false)
                ); ?>
            <?php endif; ?>


        </div>

    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-6 columns">
                <h4>Invoice Information</h4>
                <dl class="dl-horizontal">
                    <dt>Receipt Code</dt>
                    <dd><?php echo h($invoice['Invoice']['receipt_code']); ?></dd>

                    <dt>Payer Name</dt>
                    <dd><?php echo h($invoice['Invoice']['payer_name']); ?></dd>

                    <dt>Payer Email</dt>
                    <dd><?php echo h($invoice['Invoice']['payer_email']); ?></dd>

                    <dt>Total Amount</dt>
                    <dd><strong><?php echo number_format($invoice['Invoice']['total_amount'], 2); ?> ETB</strong></dd>

                    <dt>Remaining Balance</dt>
                    <dd class="<?php echo $invoice['Invoice']['remaining'] > 0 ? 'text-danger' : 'text-success'; ?>">
                        <strong><?php echo number_format($invoice['Invoice']['remaining'], 2); ?> </strong>
                    </dd>

                    <?php if ($invoice['Invoice']['remaining'] < 0  && $this->Session->read('Auth.User')['is_admin']==1 ): ?>
                        <dt>Refund </dt>
                        <dd class="<?php echo $invoice['Invoice']['remaining'] > 0 ? 'text-danger' : 'text-success'; ?>">
                            <?php echo $this->Html->link(
                                    '<i class="fa fa-undo"></i> Issue Refund / Credit',
                                    array('action' => 'refund', $invoice['Invoice']['id']),
                                    array('class' => 'btn btn-warning', 'escape' => false)
                            ); ?>
                        </dd>
                    <?php endif; ?>

                    <dt>Due Date</dt>
                    <dd><?php echo h($invoice['Invoice']['due_date']); ?></dd>

                    <dt>Status</dt>
                    <dd>
                        <span class="label label-<?php
                        if ($invoice['Invoice']['status'] === 'Paid') echo 'success';
                        elseif ($invoice['Invoice']['status'] === 'Partially Paid') echo 'warning';
                        else echo 'danger';
                        ?>">
                            <?php echo h($invoice['Invoice']['status']); ?>
                        </span>
                    </dd>

                    <dt>Created</dt>
                    <dd><?php echo h($invoice['Invoice']['created']); ?></dd>

                    <dt>Notes</dt>
                    <dd><?php echo nl2br(h($invoice['Invoice']['notes'] ?: '—')); ?></dd>
                </dl>
            </div>

            <div class="large-6 columns">
                <?php if (!empty($invoice['Invoice']['student_id'])): ?>
                    <h4>Related To</h4>
                    <dl class="dl-horizontal">

                        <?php if (!empty($invoice['Student']['full_name'])): ?>
                            <dt>Name</dt>
                            <dd><?php echo h($invoice['Student']['full_name']); ?></dd>
                        <?php endif; ?>
                        <?php if (!empty($invoice['Student']['studentnumber'])): ?>
                            <dt>Application Number</dt>
                            <dd><?php echo h($invoice['Student']['studentnumber']); ?></dd>
                        <?php endif; ?>

                    </dl>
                <?php endif; ?>

                <?php if (!empty($invoice['Invoice']['online_applicant_id'])): ?>
                    <h4>Related To</h4>
                    <dl class="dl-horizontal">
                        <?php if (!empty($invoice['OnlineApplicant']['first_name'])): ?>
                            <dt>Name</dt>
                            <dd><?php echo h($invoice['OnlineApplicant']['first_name']).' '.h($invoice['OnlineApplicant']['father_name']); ?></dd>
                        <?php endif; ?>
                        <?php if (!empty($invoice['OnlineApplicant']['applicationnumber'])): ?>
                            <dt>Application Number</dt>
                            <dd><?php echo h($invoice['OnlineApplicant']['applicationnumber']); ?></dd>
                        <?php endif; ?>

                    </dl>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="large-12 columns">

                <!-- Transactions Section -->
                <h4>Payment Transactions (<?php echo count($invoice['Transaction']); ?>)</h4>

                <?php if (empty($invoice['Transaction'])): ?>
                    <div class="alert alert-info">
                        No payments recorded yet for this invoice.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Transaction Code</th>
                                <th>Paid Amount</th>
                                <th>Method</th>
                                <th>Paid At</th>
                                <th>Status</th>
                                <th>Reference</th>
                                <th>Notes</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($invoice['Transaction'] as $transaction):?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo h($transaction['transaction_code']); ?></td>
                                    <td><?php echo number_format($transaction['paid_amount'], 2); ?>
                                        <?php
                                        echo $transaction['PaymentCurrency']['currency_code'];
                                        ?>
                                    </td>
                                    <td><?php echo h($transaction['PaymentMethod']['name'] ?: '—'); ?></td>
                                    <td><?php echo h($transaction['paid_at']); ?></td>
                                    <td>
                                    <span class="label label-<?php
                                    echo $transaction['status'] === 'Success' ? 'success' :
                                            ($transaction['status'] === 'Failed' ? 'danger' : 'warning');
                                    ?>">
                                        <?php echo h($transaction['status']); ?>
                                    </span>
                                    </td>
                                    <td><?php echo h($transaction['transaction_ref'] ?: '—'); ?></td>
                                    <td><?php echo h($transaction['notes'] ?: '—'); ?></td>

                                    <td>
                                        <?php

                                        if ($this->Session->read('Auth.User')['id'] && $transaction['status'] !== 'Failed'): ?>
                                            <?php echo $this->Form->postLink(
                                                    'Delete',
                                                    array('controller' => 'invoices', 'action' => 'deleteTransaction', $transaction['id']),
                                                    array('class' => 'btn btn-danger', 'confirm' => 'Delete this transaction? This will update the invoice balance.')
                                            ); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <div class="box-footer">
        <?php echo $this->Html->link(
                'Back to Invoices List',
                array('action' => 'index'),
                array('class' => 'btn btn-default')
        ); ?>
    </div>

</div>
<div class="box box-primary">


    <div class="box-body">



    </div><!-- /.box-body -->

</div>