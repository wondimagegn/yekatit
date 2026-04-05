<?php
?>

<div class="row">
    <div class="large-12 columns">

        <?php echo $this->Form->create('OnlineApplicant', array('action' => 'accept_document', "method" => "POST"));
        echo '<h3>' . $applicant_details['OnlineApplicant']['amharic_fullname'] . ' ' . $applicant_details['OnlineApplicant']['first_name'] . ' ' . $applicant_details['OnlineApplicant']['father_name'] . '(' . $applicant_details['OnlineApplicant']['applicationnumber'] . ')' . '</h3>';

        echo '<h6>Please provide the remark you want</h6>';


        echo $this->Form->input(
            'OnlineApplicant.id',
            array('type' => 'hidden', 'value' => $applicant_details['OnlineApplicant']['id'])
        );
        ?>
        <label>

            <?php
            echo __('Do you want to accept this document as complete ? ');
            ?>

            <label for="chkYesD">
                <input type="radio"
                    id="chkYesD"
                    name="OnlineApplicant[document_submitted]"
                    value="Yes" />

                <?php
                echo __('Yes');
                ?>

            </label>
            <label for="chkNoD">
                <input type="radio"
                    id="chkNoD"
                    name="OnlineApplicant[document_submitted]"
                    value="No" />

                <?php
                echo __('No');
                ?>
            </label>
            <div>
                <?php
                echo $this->Form->input('OnlineApplicant.remark', array(
                    'label' => 'Remark'
                ));


                ?>

            </div>
        </label>
        <?php




        echo
        $this->Form->submit(
            __('Approve/Reject the document', true),
            array(
                'name' =>
                'updateDocumentStaus', 'class'
                => 'tiny radius button bg-blue',
                'div' => false
            )
        );


        ?>


    </div>
</div>
<a class="close-reveal-modal">&#215;</a>