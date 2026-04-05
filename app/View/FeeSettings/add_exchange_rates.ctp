<?php
$this->set('title_for_layout', 'Add Multiple Exchange Rates');
echo $this->Html->css('fees');
echo $this->Html->script('fees');
?>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title">
            <i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Add Multiple Exchange Rates</span>
        </div>
    </div>
    <div class="box-body">
        <?php echo $this->Form->create('ExchangeRate', array('url' => array('action' => 'add_exchange_rates'))); ?>
        <div class="row" id="exchange-rates-container">
            <div class="large-12 columns dynamic-row">
                <div class="row">
                    <div class="large-8 columns">
                        <div class="row">
                            <div class="large-3 columns">
                                <label>From Currency:</label>
                                <select name="data[ExchangeRate][0][from_currency_id]" required>
                                    <?php foreach ($currencies as $id => $name): ?>
                                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="large-3 columns">
                                <label>To Currency:</label>
                                <select name="data[ExchangeRate][0][to_currency_id]" required>
                                    <?php foreach ($currencies as $id => $name): ?>
                                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="large-3 columns">
                                <label>Rate:</label>
                                <input type="number" step="0.0001" name="data[ExchangeRate][0][rate]" required>
                            </div>
                            <div class="large-3 columns">
                                <label>Effective Date:</label>
                                <input type="date" name="data[ExchangeRate][0][effective_date]" required>
                            </div>
                        </div>
                    </div>
                    <div class="large-4 columns">
                        <button type="button" class="remove-row">Remove</button>
                    </div>
                </div>
            </div>
            <div></div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <button type="button" class="add-row">Add Another Exchange Rate</button>
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
                <p><?php echo $this->Html->link('Back to Settings', array('action' => 'index', 'exchange_rates')); ?></p>
            </div>
        </div>
    </div>
</div>