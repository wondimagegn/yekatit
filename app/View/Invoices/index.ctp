<div class="box">
    <!-- Payment Form -->
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Invoices Management'); ?></span>
        </div>
    </div>
    <div class="box-body">
        <!-- Filter Form - always POST -->
        <?php echo $this->Form->create('Invoice');
        $yTo = date('Y');
        ?>


        <div class="row">
            <div class="large-6 columns">
                <?php
                echo $this->Form->input('payer_name', array(
                        'label'       => 'Payer Name',
                        'placeholder' => 'Contains...',
                        'value'       => h(!empty($filterFormData['payer_name']) ? $filterFormData['payer_name']:'')
                )); ?>
            </div>

            <div class="large-6 columns">
                <?php echo $this->Form->input('status', array(
                        'label'   => 'Status',
                        'options' => $statuses,
                        'empty'   => '-- Any status --',
                        'required' => false,
                        'value'   => !empty($filterFormData['status']) ? $filterFormData['status']:''
                )); ?>
            </div>

        </div>
        <div class="row">
            <div class="large-6 columns">
                <?php
                $yesterday = date('Y-m-d',strtotime('-45 day'));
                echo $this->Form->input(
                        'due_date_from',
                        array(
                                'label'   => 'Due Date From',
                                'type' => 'date',
                                'required' => false,
                                'maxYear' => $yTo,
                                'default'=>$yesterday,
                                'style' => 'width:100px'
                        )
                );

                ?>
            </div>
            <div class="large-6 columns">
                <?php

                $tommorow = date('Y-m-d',strtotime('+1 day'));
                echo $this->Form->input(
                        'due_date_to',
                        array(
                                'label'   => 'Due Date To',
                                'type' => 'date',
                                'required' => false,
                                'maxYear' => $yTo,
                                'default'=>$tommorow,
                                'style' => 'width:100px'
                        )
                );
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <?php echo $this->Form->button('Apply Filters', array(
                        'type'  => 'submit',
                        'name'  => 'apply',
                        'class' => 'btn btn-primary'
                )); ?>

                <?php echo $this->Form->button('Clear Filters', array(
                        'type'  => 'submit',
                        'name'  => 'clear_filters',
                        'value' => '1',
                        'class' => 'btn btn-default',
                        'onclick' => "return confirm('Clear all filters?');"
                )); ?>
            </div>
        </div>

        <?php echo $this->Form->end(); ?>

        <hr>

        <!-- Results Table -->
        <?php if (empty($invoices)): ?>
            <div class="alert alert-info">No invoices found matching your filters.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Receipt Code</th>
                        <th>Payer</th>
                        <th>Total</th>
                        <th>Remaining</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <?php
                        $isOverdue = (strtotime($invoice['Invoice']['due_date']) < time() &&
                                $invoice['Invoice']['remaining'] > 0 &&
                                $invoice['Invoice']['status'] !== 'Paid');
                        ?>
                        <tr class="<?php echo $isOverdue ? 'warning' : ''; ?>">
                            <td><?php echo h($invoice['Invoice']['receipt_code']); ?></td>
                            <td><?php echo h($invoice['Invoice']['payer_name']); ?></td>
                            <td><?php echo number_format($invoice['Invoice']['total_amount'], 2); ?></td>
                            <td><?php echo number_format($invoice['Invoice']['remaining'], 2); ?></td>
                            <td><?php echo h($invoice['Invoice']['due_date']); ?></td>
                            <td>
                                    <span class="label <?php
                                    if ($invoice['Invoice']['status'] === 'Paid') echo 'label-success';
                                    elseif ($isOverdue) echo 'label-danger';
                                    else echo 'label-warning';
                                    ?>">
                                        <?php echo h($invoice['Invoice']['status']); ?>
                                    </span>
                            </td>
                            <td class="text-center actions">
                                <?php if (!empty($invoice['Transaction'])): ?>
                                    <?php echo $this->Html->link(
                                            '<i class="fa fa-money"></i> View Transactions',
                                            array('action' => 'view', $invoice['Invoice']['id']),
                                            array('class' => 'btn-primary', 'escape' => false)
                                    ); ?>
                                <?php endif; ?>

                                <?php if ($invoice['Invoice']['remaining'] > 0): ?>
                                    <?php echo $this->Html->link(
                                            '<i class="fa fa-money"></i> Record Payment',
                                            array('action' => 'recordPayment', $invoice['Invoice']['id']),
                                            array('class' => 'btn-primary', 'escape' => false)
                                    ); ?>
                                <?php endif; ?>

                                <?php if ($isOverdue): ?>
                                    <?php echo $this->Html->link(
                                            '<i class="fa fa-calendar"></i> Extend Due',
                                            array('action' => 'extendDueDate', $invoice['Invoice']['id']),
                                            array('class' => 'btn btn-xs btn-warning', 'escape' => false)
                                    ); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <div class="paging">
                <p>
                    <?php
                    echo $this->Paginator->counter(array(
                            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
                    ));
                    ?>
                </p>

                <?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
                | 	<?php echo $this->Paginator->numbers();?>
                |
                <?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
            </div>
        <?php endif; ?>

    </div>
</div>