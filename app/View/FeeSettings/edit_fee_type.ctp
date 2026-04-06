<?php
$this->set('title_for_layout', 'Edit Fee Type');
echo $this->Html->css('fees');
echo $this->Html->script('fees');
?>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title">
            <i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Edit Payment Method</span>
        </div>
    </div>
    <div class="box-body">

<h2>Edit Fee Type</h2>
<?php
echo $this->Form->create('FeeType');
echo $this->Form->input('name');
echo $this->Form->input('amount', array('type' => 'number', 'step' => '0.01'));
echo $this->Form->input('currency_id', array('options' => $currencies));
echo $this->Form->input('category_id', array('options' => $categories, 'empty' => 'Select Category (optional)'));
echo $this->Form->input('recurrence', array('options' => array('one-time' => 'One-Time', 'semesterly' => 'Semesterly', 'yearly' => 'Yearly')));
echo $this->Form->input('tax_rate', array('type' => 'number', 'step' => '0.01', 'label' => 'Tax Rate (%)'));
echo $this->Form->input('discountable', array('type' => 'checkbox'));
echo $this->Form->input('applicable_to', array('options' => array('students' => 'Students', 'alumni' => 'Alumni', 'guests' => 'Guests', 'all' => 'All')));
echo $this->Form->input('active', array('type' => 'checkbox'));
echo $this->Form->input('year');
echo $this->Form->input('description', array('type' => 'textarea'));
echo $this->Form->input('computation_rule', array(
    'type' => 'textarea',
    'label' => 'Computation Rule (JSON, e.g., {"base": 100, "multiplier": "credits"})'
));


echo $this->Form->submit('Save  ', array('class' => 'tiny radius button bg-blue'));
echo $this->Form->end();
?>
<p><?php echo $this->Html->link('Back to Settings', array('action' => 'index', 'fee_types')); ?></p>
        
    </div>
</div>
