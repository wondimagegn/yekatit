<?php
header("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Content-Description: Exported as XLS");
?>


<table class="grade_list">
    <tr>


        <th style="width:30%">
            receipt_number

        </th>

        <th style="width:30%">
            bank_name

        </th>
        <th style="width:30%">
            reference_number

        </th>
        <th style="width:30%">
            payment_date


        </th>
        <th style="width:30%">
            actual_amount_paid



        </th>

    </tr>
    <?php
    foreach ($payments as $key => $payment) {

        $invoiceDate = date_create($payment['Payment']['created']);
        $formatedInvoiceDate = date_format($invoiceDate, "Y-m-d");

    ?>
    <tr>



        <td><?php echo $payment['Payment']['receipt_number']; ?>
        </td>


        <td><?php echo $payment['Payment']['bank_name']; ?>
        </td>
        <td><?php echo $payment['Payment']['reference_number']; ?>
        </td>
        <td>
            <?php echo $formatedInvoiceDate; ?>
        </td>
        <td><?php echo $payment['Payment']['total_amount'];
                ?>
        </td>
    </tr>
    <?php
        $count++;
    } //End of each mark entry for each exam type (foreach loop)
    ?>
</table>