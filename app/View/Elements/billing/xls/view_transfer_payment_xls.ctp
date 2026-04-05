<?php
header("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Content-Description: Exported as XLS");
?>
                    <?php
                    if (isset($payments) && !empty($payments)) {



                        ?>

                        <table>
                            <thead>
                                <tr>
                                    <th>S.N<u>o</u>
                                    </th>
                                    <th>
                                        <?php echo 'FullName'; ?>
                                    </th>

                                    <th>
                                        <?php echo 'StudentNumber'; ?>
                                    </th>

                                    <th>
                                        <?php echo 'Reference Number'; ?>
                                    </th>

                                    <th>
                                        <?php echo 'Receipt Number'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Department'; ?>
                                    </th>


                                    <th>
                                        <?php echo 'Total Credit'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Total Contact Hr'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Tutition Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Registration Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Application Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Module Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Lab Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Field Practise Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Research Fee'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Penality Fee'; ?>
                                    </th>


                                    <th>
                                        <?php echo 'Total Amount'; ?>
                                    </th>
                                    <th>
                                        <?php echo 'Payment Status'; ?>
                                    </th>

                                    <th>
                                        <?php echo 'Payment Date'; ?>
                                    </th>




                                </tr>
                            </thead>
                            <?php
                            $i = 0;
                            $start = $this->Paginator->counter('%start%');

                            foreach ($payments as $payment):
                                $class = null;
                                $classI = null;
                                $linkstyle = null;

                                if ($i++ % 2 == 0) {
                                    $classI = 'altrow';
                                }

                                ?>
                                <tr<?php echo $class; ?>>
                                    <td>
                                        <?php
                                        echo $start;
                                        ?>
                                    </td>

                                    <td>

                                        <?php
                                        if (isset($payment['Student']['full_name']) && !empty($payment['Student']['full_name'])) {
                                            echo  ucwords($payment['Student']['full_name']);


                                        } else if (isset($payment['OnlineApplicant']['full_name']) && !empty($payment['OnlineApplicant']['full_name'])) {
                                            echo $payment['OnlineApplicant']['full_name'];

                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($payment['Student']['studentnumber']) && !empty($payment['Student']['studentnumber'])) {
                                            echo  ucwords($payment['Student']['studentnumber']);

                                        } else if (isset($payment['OnlineApplicant']['applicationnumber']) && !empty($payment['OnlineApplicant']['applicationnumber'])) {
                                            echo $payment['OnlineApplicant']['applicationnumber'];

                                        }
                                        ?>&nbsp;
                                    </td>



                                    <td>
                                        <?php
                                        if (isset($payment['Payment']['transactionreference']) && !empty($payment['Payment']['transactionreference'])) {
                                            echo $payment['Payment']['transactionreference'];

                                        } else {
                                            echo $payment['Payment']['reference_number'];
                                        }


                                        ?>&nbsp;


                                    </td>
                                    <td>
                                        <?php

                                          $invoiceType = '';
                                if ($payment['Payment']['payment_term'] == "Split") {
                                    $invoiceType = $payment['Payment']['payment_term'];
                                } else if ($payment['Payment']['payment_term'] == "Full" && $payment['Payment']['payment_group'] == 'Course Registration') {
                                    $invoiceType = 'Full';
                                } else if ($payment['Payment']['payment_term'] == "Full" && $payment['Payment']['payment_group'] == 'Makeup Exam') {
                                    $invoiceType = 'Service';
                                } else if ($payment['Payment']['payment_term'] == "Full" && empty($payment['Payment']['courses'])) {
                                    $invoiceType = 'Service';
                                }
                                        echo $payment['Payment']['receipt_number'];


                                        ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($payment['Student']['department_id']) && !empty($payment['Student']['department_id'])) {
                                            echo $payment['Student']['Department']['name'];


                                        } else if (isset($payment['OnlineApplicant']['department_id']) && !empty($payment['OnlineApplicant']['department_id'])) {
                                            echo $payment['OnlineApplicant']['Department']['name'];

                                        }
                                        ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php echo $payment['Payment']['total_credit']; ?>&nbsp;
                                    </td>

                                    <td>
                                        <?php echo $payment['Payment']['total_contact_hr']; ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php
                                        echo number_format($payment['Payment']['tutition_fee'], 2); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($payment['Payment']['total_credit'] != 0) {
                                            echo number_format($payment['Payment']['registration_fee'], 2);

                                        }
                                        ?>&nbsp;
                                    </td>

                                    <td>
                                        <?php
                                        if ($payment['Payment']['total_credit'] == 0) {
                                            echo number_format($payment['Payment']['registration_fee'], 2);

                                        }

                                        ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php

                                        echo number_format($payment['Payment']['module_fee'], 2);

                                        ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php

                                        echo number_format($payment['Payment']['lab_fee'], 2);

                                        ?>&nbsp;
                                    </td>

                                    <td>
                                        <?php

                                        echo number_format($payment['Payment']['field_practise_fee'], 2);

                                        ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php

                                        echo number_format($payment['Payment']['research_fee'], 2);

                                        ?>&nbsp;
                                    </td>

                                    <td>
                                        <?php

                                        echo number_format($payment['Payment']['penality_fee'], 2);

                                        ?>&nbsp;
                                    </td>


                                    <td>
                                        <?php
                                        echo number_format($payment['Payment']['total_amount'], 2);

                                        ?>&nbsp;
                                    </td>

                                    <td>
                                        <?php
                                        if ($payment['Payment']['payment_status'] == 1) {

                                            echo "Paid";
                                        } else {
                                            echo "Not Paid";


                                        }
                                        ?>&nbsp;
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($payment['Payment']['payment_date']) && !empty($payment['Payment']['payment_date'])) {
                                            $payment_date_f = date_create($payment['Payment']['payment_date']);
                                            $payment_date = date_format($payment_date_f, "jS M Y");

                                            echo $payment_date;

                                        }
                                        ?>
                                    </td>



                                    </tr>

                                    <?php
                                    $start++;
                            endforeach; ?>

                        </table>


                        <?php
                    }
                    ?>