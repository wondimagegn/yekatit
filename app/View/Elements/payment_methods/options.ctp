<?php
echo $this->Form->create('Invoice', array(
    'controller' => 'invoices', 'action' => 'pay_at', 'method' => 'post',

    'id' => 'Invoice',
    'role' => 'form'
));
?>

<?php
$myOptions = array();

if (isset($unpaidPayment) && !empty($unpaidPayment) && isset($paymentMethods) && !empty($paymentMethods)) {



    ?>


    <?php
    $count = 0;
    $myOptions = array();
    if (isset($paymentMethods) && !empty($paymentMethods)) {
        foreach ($paymentMethods as $pk => $pv) {
            ?>
            <?php
            if (!empty($pv['Attachment'])) {

                foreach ($pv['Attachment'] as $ak => $av) {
                    if (!empty($av['dirname']) && !empty($av['basename']) && strcasecmp($av['dirname'], 'img') == 0) {

                        if (isset($pv['PaymentMethod']['id']) && !empty($pv['PaymentMethod']['id'])) {


                            $path = $this->Media->file($av['dirname'] . DS . $av['basename']);

                            $myOptions[$pv['PaymentMethod']['id']] = $this->Html->image($this->Media->url($path), array('width' => '100px', 'height' => '100px'));

                        }
                    }
                }
            } else {

                $myOptions[$pv['PaymentMethod']['id']] = $this->Html->image('/img/noimage.jpg', array('width' => '200px', 'height' => '200px'));


                $myOptions[$pv['PaymentMethod']['id']] = $this->Html->image('/img/noimage.jpg', array('width' => '100px', 'height' => '100px'));
            }
        ?>
        <?php
        }
    }

    ?>





    <?php
    echo '<div>';
    if (isset($unpaidPayment['Student']['full_name']) && !empty($unpaidPayment['Student']['full_name'])) {
        echo '<h5>Name:' . ucwords($unpaidPayment['Student']['full_name']) . '</h5>';

    } else if (isset($unpaidPayment['OnlineApplicant']['full_name']) && !empty($unpaidPayment['OnlineApplicant']['full_name'])) {
        echo '<h5>Name:' . ucwords($unpaidPayment['OnlineApplicant']['full_name']) . '</h5>';

    }

    debug($unpaidPayment);

    echo '<h5>Invoice Number:' . $unpaidPayment['Invoice']['receipt_code'] . '</h5>';
    echo '</div>';
    if (isset($myOptions) && !empty($myOptions)) {
        echo $this->Form->input('Invoice.methodId', array('type' => 'radio', 'options' => $myOptions, 'label' => '',
            'style' => 'padding:5px;margin:5px;', 'legend' => 'Payment Method'));


    } else {
        echo "Payment method is deactivated currently, please come back later when the payment method is back or ask the registrar how to pay it.";

    }



    echo $this->Form->input('Invoice.invoiceNumber', array('type' => 'hidden', 'value' => $unpaidPayment['Invoice']['receipt_code']));


    echo $this->Form->Submit('Continue', array('div' => false, 'name' => 'continue', 'class' => 'tiny radius button bg-blue'));




    ?>


    <?php
}
?>

<script>
    function myPayment() {

        //get form action
        var formUrl =
            '/invoices/pay_at/';
        $.ajax({
            type: 'post',
            url: formUrl,
            data: $('form')
                .serialize(),
            success: function (
                data,
                textStatus,
                xhr
            ) {



            },
            error: function (xhr,
                textStatus,
                error) {
                alert(
                    textStatus
                );
            }
        });

        return false;
    }
</script>

<?php echo $this->Form->end(); ?>