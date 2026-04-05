<div class="box">
    <!-- Payment Form -->
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Refund Payment - Invoice #'). $invoice['Invoice']['receipt_code']; ?></span>
        </div>
    </div>
    <div class="box-body">

        <?php echo $this->Form->create('Transaction'); ?>
        <div class="row">
            <div class="large-12 columns">
                <strong>Current remaining balance:</strong>
                <?php echo number_format($invoice['Invoice']['remaining'], 2); ?>
            </div>
            <div class="large-12 columns">
              <div class="row">
                  <div class="large-6 columns">
                      <?php echo $this->Form->input('refund_amount', array(
                              'label' => 'Refund Amount (ETB)',
                              'type'  => 'number',
                              'step'  => '0.01',
                              'min'   => '0.01',
                              'max'   => abs($invoice['Invoice']['remaining']),
                              'class' => 'form-control',
                              'required' => true,
                              'value' => ''   // ← important: do NOT prefill here if you want clean input
                          )); ?>
                  </div>
                  <div class="large-6 columns">
                      <?php echo $this->Form->input('reason', array(
                              'label'    => array('text' => 'Reason', 'class' => 'col-sm-3 control-label'),
                              'options'  => $refundReasons,
                              'empty'    => '-- Select reason --',
                              'required' => true,
                              'class'    => 'form-control'
                      )); ?>
                  </div>
              </div>
                <div class="row">

                    <div class="large-6 columns">

                        <?php echo $this->Form->input('notes', array(
                                'label' => array('text' => 'Additional Notes', 'class' => 'col-sm-3 control-label'),
                                'type'  => 'textarea',
                                'rows'  => 3,
                                'class' => 'form-control'
                        )); ?>

                    </div>
                    <div class="large-6 columns">
                        <?php echo $this->Form->input('transaction_ref', array(
                                'label' => array('text' => 'Bank/Reference No.', 'class' => 'col-sm-3 control-label'),
                                'class' => 'form-control'
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <?php echo $this->Form->button('Confirm Refund', array(
                                'type'  => 'submit',
                                'class' => 'btn btn-danger'
                        )); ?>

                        <?php echo $this->Html->link('Cancel', array('action' => 'view', $invoice['Invoice']['id']), array(
                                'class' => 'btn btn-default'
                        )); ?>
                    </div>

                </div>
            </div>
        </div>

        <?php echo $this->Form->end(); ?>

    </div>
</div>