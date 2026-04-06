<?php

echo $this->Html->css('fees');
echo $this->Html->script('fees');
debug($currencies);
?>
<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Add Multiple Fee Types '); ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">

                <div class="row" id="fee-types-container">
                    <div class="large-12 columns">

                        <h2>Add Multiple Fee Types <?php if ($category_id) echo 'for Category ID: ' . $category_id; ?></h2>
                        <?php echo $this->Form->create('FeeType', array('url' => array('controller'=>'feeSettings',
                            'action' => 'add_fee_types',
                            $category_id))); ?>
                        
                    </div>
                    <div class="large-12 columns" id="dynamic-row">
                        <div class="row">
                            <div class="large-8 columns">
                                <div class="row">
                                    <div class="large-3 columns">

                                        <label>Name:</label>
                                        <input type="text" name="data[FeeType][0][name]" required>
                                    </div>
                                    <div class="large-3 columns">

                                        <label>Amount:</label>
                                        <input type="number" step="0.01" name="data[FeeType][0][amount]" required>

                                    </div>
                                    <div class="large-3 columns">
                                        <label>Currency:</label>
                                        <select name="data[FeeType][0][currency_id]" required>
                                            <?php foreach ($currencies as $id => $name): ?>
                                                <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="large-3 columns">

                                        <label>Recurrence:</label>
                                        <select name="data[FeeType][0][recurrence]">
                                            <option value="one-time">One-Time</option>
                                            <option value="semesterly">Semesterly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="large-3 columns">

                                        <label>Tax Rate (%):</label>
                                        <input type="number" step="0.01" name="data[FeeType][0][tax_rate]">

                                    </div>
                                    <div class="large-3 columns">
                                        <label>Discountable:</label>
                                        <input type="checkbox" name="data[FeeType][0][discountable]">

                                    </div>
                                    <div class="large-3 columns">

                                        <label>Applicable To:</label>
                                        <select name="data[FeeType][0][applicable_to]">
                                            <option value="all">All</option>
                                            <option value="students">Students</option>
                                            <option value="alumni">Alumni</option>
                                            <option value="guests">Guests</option>
                                        </select>

                                    </div>
                                    <div class="large-3 columns">
                                        <label>Active:</label>
                                        <input type="checkbox" name="data[FeeType][0][active]" checked>
                                    </div>
                                </div>

                                <div class="row">
                                  
                                    <div class="large-4 columns">

                                        <label>Description:</label>
                                        <textarea name="data[FeeType][0][description]"></textarea>

                                    </div>
                                    <div class="large-4 columns">



                                        <label>Computation Rule (JSON):</label>
                                        <textarea name="data[FeeType][0][computation_rule]"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="large-4 columns">


                                <button type="button" class="remove-row">Remove</button>
                            </div>
                         

                        </div>

                        <div></div>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <button type="button" class="add-row tiny radius button bg-blue">Add Another Fee Type</button>
                    </div>
                </div>
                       
                <div class="row">
                    <div class="large-6 columns">
                        <?php 
                        echo $this->Form->submit('Save All ', array('class' => 'tiny radius button bg-blue'));
                        echo $this->Form->end();
                        ?>
                    </div>
                    <div class="large-6 columns">
                        <p><?php echo $this->Html->link('Back to Settings', array('action' => 'index')); ?></p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>