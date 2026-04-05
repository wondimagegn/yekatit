
<div class="row">
    <div class="large-12 columns">

        <div class="modal-header">
            <h4 class="modal-title">
                Generate Invoice for
                <?php echo h($targetEntity[$targetType === 'Student' ? 'Student' : 'OnlineApplicant']['full_name']); ?>
            </h4>
        </div>

        <div class="modal-body">
            <?php echo $this->Form->create('Invoice', array(
                    'url' => array('action' => 'generateStudentInvoices', $targetId,'OnlineApplicant'),
                    'id'  => 'generateInvoiceForm'
            )); ?>

            <!-- Hidden field to preserve target ID -->
            <?php if ($targetType === 'Student'): ?>
                <?php echo $this->Form->hidden('student_id', array('value' => $targetId)); ?>
                <?php echo $this->Form->hidden('type', array('value' => 'Student')); ?>

            <?php else: ?>
                <?php echo $this->Form->hidden('online_applicant_id', array('value' => $targetId)); ?>
                <?php echo $this->Form->hidden('type', array('value' => 'OnlineApplicant')); ?>
            <?php endif; ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Select Fee Types & Enter Required Values</strong>
                </div>
                <div class="panel-body">


                    <?php foreach ($feeTypes as $feeTypeId => $feeName): ?>
                        <?php
                        // Get full fee type data to inspect computation_rule
                        $feeTypeData = ClassRegistry::init('FeeType')->findById($feeTypeId);
                        $ruleJson    = !empty($feeTypeData['FeeType']['computation_rule']) ? $feeTypeData['FeeType']['computation_rule'] : null;
                        $rule        = $ruleJson ? json_decode($ruleJson, true) : array();
                        $needsInput  = !empty($rule) && (isset($rule['multiplier']) || isset($rule['unit']));
                        $inputKey    = $needsInput ? (isset($rule['multiplier']) ? $rule['multiplier'] : $rule['unit']) : null;
                        $inputLabel  = $inputKey ? ucfirst($inputKey) : 'Value';
                        ?>

                        <div class="checkbox">
                            <label>
                                <?php echo $this->Form->checkbox("fee_type_ids.{$feeTypeId}", array(
                                        'value'         => $feeTypeId,
                                        'class'         => 'fee-type-checkbox',
                                        'data-needs-input' => $needsInput ? '1' : '0',
                                        'data-input-key'   => $inputKey,
                                        'data-fee-id'      => $feeTypeId
                                )); ?>
                                <?php echo h($feeName); ?>
                                <?php if ($needsInput): ?>
                                    <small class="text-muted">(needs <?php echo strtolower($inputLabel); ?>)</small>
                                <?php endif; ?>
                            </label>

                            <?php if ($needsInput): ?>
                                <div class="dynamic-input" id="input-for-<?php echo $feeTypeId; ?>" style="display:none; margin-left:30px; margin-top:8px;">
                                    <?php echo $this->Form->input("dynamic_values.{$feeTypeId}", array(
                                            'label'       => $inputLabel,
                                            'type'        => 'number',
                                            'step'        => 'any',
                                            'min'         => '0',
                                            'class'       => 'form-control input-sm',
                                            'div'         => false,
                                            'style'       => 'width:180px; display:inline-block;',
                                            'placeholder' => 'e.g. 15 or 120'
                                    )); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal-footer">
                <?php echo $this->Form->button('Generate Invoices', array(
                        'type'  => 'submit',
                        'class' => 'btn btn-primary',
                        'id'    => 'generateBtn'
                )); ?>

            </div>

            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

<a class="close-reveal-modal">&#215;</a>


<!-- JavaScript to toggle dynamic inputs -->
<script type="text/javascript">
    $(document).ready(function() {
        $('.fee-type-checkbox').on('change', function() {
            var $checkbox = $(this);
            var feeId     = $checkbox.data('fee-id');
            var needs     = $checkbox.data('needs-input') == 1;
            var $inputDiv = $('#input-for-' + feeId);

            if ($checkbox.is(':checked') && needs) {
                $inputDiv.show();
            } else {
                $inputDiv.hide();
                // Optional: clear value when unchecked
                $inputDiv.find('input').val('');
            }
        });

        // Prevent submit if nothing selected
        $('#generateBtn').on('click', function(e) {
            if ($('.fee-type-checkbox:checked').length === 0) {
                e.preventDefault();
                alert('Please select at least one fee type.');
            }
        });
    });
</script>