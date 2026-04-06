<?php
$this->set('title_for_layout', 'Edit Fee Category');

echo $this->Html->css('fees');
echo $this->Html->script('fees');
?>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Edit Fee Types for Category ID: <?= $this->request->data['FeeCategory']['id'].' '.
                $this->request->data['FeeCategory']['name']; ?></span>
        </div>
    </div>
    <div class="box-body">
            <h2>Edit Fee Category</h2>
            <?php
            echo $this->Form->create('FeeCategory');
            echo $this->Form->input('name');
            echo $this->Form->input('description', array('type' => 'textarea'));
            echo $this->Form->submit('Save', array('class' => 'tiny radius button bg-blue'));
            echo $this->Form->end();
            ?>
            <p><?php echo $this->Html->link('Back to Settings', array('action' => 'index', 'categories')); ?></p>
    </div>
</div>