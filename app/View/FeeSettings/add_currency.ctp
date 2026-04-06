<?php
$this->set('title_for_layout', 'Add Payment Currency');
echo $this->Html->css('fees');
echo $this->Html->script('fees');
?>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title">
            <i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Add Payment Currency</span>
        </div>
    </div>
    <div class="box-body">
        <?php
        echo $this->Form->create('PaymentCurrency');
        echo $this->Form->input('name');
        echo $this->Form->input('currency_code');
        echo $this->Form->input('currency_territory');

        echo $this->Form->submit('Save ', array('class' => 'tiny radius button bg-blue'));
        echo $this->Form->end();
        ?>
        <p><?php echo $this->Html->link('Back to Settings', array('action' => 'index', 'currencies')); ?></p>
    </div>
</div>