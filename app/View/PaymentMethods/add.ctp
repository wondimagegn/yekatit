<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <?php echo $this->Form->create('PaymentMethod', array(
					'method' => 'post', 'id' => 'MyMethod',
					'enctype' => 'multipart/form-data',
					'type' => 'file'
				)); ?>

                <fieldset>
                    <legend>
                        <?php echo __('Add Payment Method'); ?>
                    </legend>
                    <?php
					echo $this->Form->input('name');
					echo $this->Form->input('url');
					echo $this->Form->input('instruction');

					?>
                    <?php
					echo $this->Form->input('Attachment.0.file', array(
						'type' => 'file', 'label' => 'Logo', 'required' => 'required',
						'id' => 'PaymentMethodLogo',
						'onchange' =>
						"return fileValidationImg(this)"
					));

                    echo $this->Form->input('active');
					?>
                </fieldset>
                <?php
				echo $this->Form->end(array('label' => __('Submit'), 'class' => 'tiny radius button bg-blue'));
				?>

            </div>
        </div>
    </div>
</div>
<script nonce="<?php echo h($nonce)?>">
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