<?php if (isset($applicant) && !empty($applicant)) { ?>
<div class="row">
    <div class="large-12 columns">

        <h3> <?php echo __('Applicant Details.'); ?>
        </h3>
        <?php

            echo $this->element('applicant_profile');
            ?>
    </div>
</div>

<?php } ?>
