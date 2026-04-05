<?php
$this->set('title_for_layout', 'Add Payment Method');
echo $this->Html->css('fees');
echo $this->Html->script('fees');
?>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title">
            <i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Add Payment Method</span>
        </div>
    </div>
    <div class="box-body">
        <?php
        echo $this->Form->create('PaymentMethod',
            array(
                    'controller' => 'feeSettings',
                'action' => 'add_method',
                'method' => 'post', 'id' => 'MyMethod',
                'enctype' => 'multipart/form-data',
                'type' => 'file'
            ));
        echo $this->Form->input('name');
        echo $this->Form->input('url');
        echo $this->Form->input('instruction', array('type' => 'textarea'));
        echo $this->Form->input('active', array('type' => 'checkbox'));
        echo $this->Form->input('gateway');
        echo $this->Form->input('config', array('type' => 'textarea', 'label' => 'Config (JSON)'));
        echo $this->Form->input('Attachment.0.file', array(
            'type' => 'file', 'label' => 'Logo', 'required' => 'required',
            'id' => 'PaymentMethodLogo',
            'onchange' =>
                "return fileValidationImg(this)"
        ));


        echo $this->Form->submit('Save ', array('class' => 'tiny radius button bg-blue'));
        echo $this->Form->end();
        ?>
        <p><?php echo $this->Html->link('Back to Settings', array('action' => 'index', 'methods')); ?></p>
    </div>
</div>


<script>
    function fileValidationImg(obj) {

        var fileInput =
            document.getElementById(obj.id);

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =
            /\.(jpe?g|png|gif|bmp)$/i;

        if (!allowedExtensions.exec(
            filePath)) {
            alert(
                '<?php echo __('Invalid file type: Please upload only image file'); ?>'
            );
            fileInput.value = '';
            return false;
        }
        return true;
    }
</script>