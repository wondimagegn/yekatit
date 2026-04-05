<div class="box">
    <div class="pull-right">
        <!-- Generate button that opens modal later -->

            <i class="fa fa-plus"></i>
            <?php
            echo $this->Html->link('Generate New Invoice', '#', array(
                    'class' => 'tiny radius button bg-blue',
                    'data-animation' => "fade", 'data-reveal-id' => 'myModalInvoice',
                    'data-reveal-ajax' => '/invoices/generateStudentInvoices/'.$applicant['OnlineApplicant']['id'].'/OnlineApplicant'
            ));
            ?>

    </div>
        <?php

        $role_id=$this->Session->read('Auth.User')['role_id'];
        if (empty($applicant_detail['Invoice'])): ?>
            <div class="alert alert-info text-center" style="margin: 15px;">
                No invoices found for this student yet.
            </div>
        <?php else: ?>
        <table cellpadding="0"
               cellspacing="0"
               style="width: 100%;">
            <thead>
              <tr>
                  <td>

                  </td>
                  <td>
                      Payer Name
                  </td>
                  <td>
                      Receipt No.
                  </td>

                  <td>
                      Total Amount
                  </td>

                  <td>
                      Remaining
                  </td>
                  <td>
                      Status
                  </td>
                  <td>
                      Note
                  </td>
                  <td>
                      Created
                  </td>
                  <td>
                      Action
                  </td>
              </tr>
            </thead>
            <tbody>

            <?php
            $count=1;
            foreach ($applicant_detail['Invoice'] as $index => $invoice): ?>
                <?php
                $isOverpaid = $invoice['remaining'] < 0;
                $panelClass = $invoice['status'] === 'Paid' ? 'panel-success' :
                        ($isOverpaid ? 'panel-info' : 'panel-warning');
                $badgeClass = $invoice['status'] === 'Paid' ? 'label-success' :
                        ($isOverpaid ? 'label-info' : 'label-warning');
                $rowId = 'detail-row-' . $count;
                $tdRow = 'td-' . $count;

                ?>

                <tr>
                    <td onclick="toggleDetailView(<?php echo $count ?>)" id="<?php echo $tdRow; ?>">
                        <?php echo $this->Html->image('plus2.gif', array(
                                'id' => 'toggle-img-' . $count,
                                )); ?>
                    </td>
                    <td>
                        <?= h($invoice['payer_name']); ?>
                    </td>
                    <td>
                        <?= h($invoice['receipt_code']);?>
                    </td>
                    <td>
                        <?php echo number_format($invoice['total_amount'], 2); ?>
                    </td>
                    <td>
                        <strong><?php echo number_format($invoice['remaining'], 2); ?> </strong>
                        <?php if ($isOverpaid): ?>
                            <small>(overpaid)</small>
                        <?php endif; ?>&nbsp;
                    </td>
                    <td>
                        <span class="label <?php echo $badgeClass; ?>">
                                            <?php echo h($invoice['status']); ?>
                                        </span>
                    </td>
                    <td>
                        <p><strong>Notes:</strong> <?php echo nl2br(h($invoice['notes'] ?: '—')); ?></p>
                    </td>
                    <td>
                        <?php echo h($invoice['created']); ?>
                    </td>
                    <td>

                        <?php
                        if(ROLE_STUDENT!=$role_id){
                            echo $this->Html->link(
                                    '<i class="fa fa-money"></i> Manage Transactions',
                                    array('controller'=>'invoices','action' => 'view', $invoice['id']),
                                    array('class' => 'btn-primary', 'escape' => false)
                            );
                        }
                      ?>
                    </td>
                </tr>

                <tr id="<?php echo $rowId; ?>" style="display:none;">
                    <td colspan="8">
                        <!-- Transactions table -->
                        <?php if (empty($invoice['Transaction'])): ?>
                            <p class="text-muted text-center">No transactions recorded yet.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Method/Reference</th>
                                        <th>Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($invoice['Transaction'] as $t): ?>
                                        <tr class="<?php echo $t['paid_amount'] < 0 ? 'text-danger' : ''; ?>">
                                            <td><?php echo h($t['paid_at']); ?></td>
                                            <td>
                                                <?php
                                                $sign = $t['paid_amount'] < 0 ? '-' : '';
                                                echo $sign . number_format(abs($t['paid_amount']), 2);
                                                ?>
                                            </td>
                                            <td>
                                                            <span class="label label-<?php
                                                            echo $t['status'] === 'Success' ? 'success' :
                                                                    ($t['status'] === 'Refunded' ? 'warning' : 'default');
                                                            ?>">
                                                                <?php echo h($t['status']); ?>
                                                            </span>
                                            </td>
                                            <td><?php echo h($t['PaymentMethod']['name'] .
                                                        ($t['transaction_ref'] ? ' / ' . $t['transaction_ref'] : '')); ?></td>
                                            <td><?php echo h($t['notes'] ?: '—'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            $count++;
            endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
</div>


<script >
    function toggleDetailView(i) {
        if ($('#detail-row-'+i).css("display") == 'none')
            $('#toggle-img-'+i).attr("src", '/img/minus2.gif');
        else
            $('#toggle-img-' + i).attr("src", '/img/plus2.gif');

        $('#detail-row-' + i).toggle("slow");
    }
</script>