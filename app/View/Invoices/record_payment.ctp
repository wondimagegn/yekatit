<div class="box">
    <!-- Payment Form -->
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Record Payment - Invoice #'). $invoice['Invoice']['receipt_code']; ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">

            <?php echo $this->Form->create('Transaction'); ?>
            <div class="large-12 columns">
                <hr>
                <table cellspacing="0" cellpading="0" class="table">
                    <tbody>
                    <tr>
                        <td>Payer</td>
                        <td><?php echo h($invoice['Invoice']['payer_name']); ?></td>

                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo h($invoice['Invoice']['payer_email']); ?></td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td><?php echo number_format($invoice['Invoice']['total_amount'], 2); ?> ETB</td>

                    </tr>
                    <?php if (!empty($invoice['Invoice']['remaining'])): ?>
                        <tr>
                            <td>Remaining</td>
                            <td class="<?php echo $invoice['Invoice']['remaining'] > 0 ? 'text-danger' : 'text-success'; ?>">
                                <?php echo number_format($invoice['Invoice']['remaining'], 2); ?> ETB
                            </td>
                        </tr>

                    <?php endif; ?>
                    <tr>
                        <td>Due Date</td>
                        <td><?php echo h($invoice['Invoice']['due_date']); ?></td>
                    </tr>
                    <tr>
                        <td>Current Status</td>
                        <td>
                        <span class="label label-<?php
                        echo $invoice['Invoice']['status'] === 'Paid' ? 'success' :
                                ($invoice['Invoice']['status'] === 'Partially Paid' ? 'warning' : 'danger');
                        ?>">
                            <?php echo h($invoice['Invoice']['status']); ?>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Notes from Invoice:</td>
                        <td> <?php echo nl2br(h($invoice['Invoice']['notes'] ?: 'No notes')); ?> </td>

                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="large-12 columns">
                <div class="row">
                    <div class="large-3 columns">
                        <?php echo $this->Form->input('invoice_id', array(
                                'type' => 'hidden',
                                'value' => $invoice['Invoice']['id']
                        )); ?>
                        <?php echo $this->Form->input('paid_amount', array(
                                'label' => 'Paid Amount *',
                                'type' => 'number',
                                'step' => '0.01',
                                'min' => '-999999.99',  // Allow negatives for refunds
                                'required' => true,
                                'autofocus' => true,
                                'placeholder' => '0.00',

                        )); ?>
                    </div>
                    <div class="large-3 columns">
                        <?php
                        echo $this->Form->input('currency_id', array(
                                'label' => 'Currency',
                                'options' => $paymentCurrencies,  // ← assume passed from controller
                                'empty' => '-- Select Currency --',
                                'default' => 1 // ETB or your default
                        ));
                        ?>
                    </div>
                    <div class="large-3 columns">
                        <?php echo $this->Form->input('converted_amount', array(
                                'label' => 'Converted Amount',
                                'type' => 'number',
                                'step' => '0.01',
                                'placeholder' => 'If different from paid amount'
                        )); ?>
                    </div>
                    <div class="large-3 columns">
                        <?php echo $this->Form->input('exchange_rate', array(
                                'label' => 'Exchange Rate',
                                'type' => 'number',
                                'step' => '0.0001',
                                'placeholder' => '1.0000 if same currency'
                        )); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="large-3 columns">
                        <?php echo $this->Form->input('method_id', array(
                                'label' => 'Payment Method *',
                                'options' => $paymentMethods,  // ← passed from controller $this->Transaction->Method->find('list')
                                'empty' => '-- Select Method --',
                                'required' => true
                        )); ?>

                    </div>

                    <div class="large-3 columns">
                        <?php echo $this->Form->input('transaction_code', array(
                                'label' => 'Transaction Code / Receipt No.',
                                'placeholder' => 'e.g. CBE-REF-123456 or CASH-001'
                        )); ?>

                    </div>

                    <div class="large-3 columns">

                        <?php echo $this->Form->input('transaction_ref', array(
                                'label' => 'Reference / Cheque No.',
                                'placeholder' => 'Bank reference, cheque number, etc.'
                        )); ?>

                    </div>

                    <div class="large-3 columns">
                        <?php echo $this->Form->input('paid_at', array(
                                'label' => 'Payment Date *',
                                'type' => 'text',
                                'class' => 'form-control datepicker',
                                'value' => date('Y-m-d'),
                                'required' => true
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="large-6 columns">
                    <?php echo $this->Form->input('status', array(
                            'label' => 'Transaction Status',
                            'default' => 'Success'
                    )); ?>
                    </div>

                    <div class="large-6">
                    <?php echo $this->Form->input('notes', array(
                            'label' => 'Notes / Remarks',
                            'type' => 'textarea',
                            'rows' => 3,
                            'placeholder' => 'Any additional information (e.g. bank branch, partial payment reason)'
                    )); ?>
                    </div>


                </div>

            </div>
            <div class="large-12 columns">
                <?php echo $this->Form->button('Record Payment', array(
                        'type' => 'submit',
                        'class' => 'btn btn-primary btn-lg'
                )); ?>

                <?php echo $this->Html->link('Cancel', array('action' => 'index'), array(
                        'class' => 'btn btn-default'
                )); ?>
            </div>

            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>