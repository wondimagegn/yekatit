<?php
if (isset($resultFound) && !empty($resultFound)) { ?>
    <div class="row">
        <div class="large-12 columns">
            <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" class="table">
                    <tbody>
                        <tr>
                            <td style="background-color: white;">Full Name: &nbsp; <b><?= $resultFound['RemedialResult']['full_name']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Stream: &nbsp; <b><?= $resultFound['RemedialResult']['stream']; ?></b></td>
                        </tr>

                        <tr>
                            <td style="background-color: white;">Year: &nbsp; <b><?= $resultFound['RemedialResult']['year']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Total Score: &nbsp; <b><?= $resultFound['RemedialResult']['total_score']; ?></b></td>
                        </tr>
                        <?php
                        if (isset($resultFound['RemedialResult']['status']) && !empty($resultFound['RemedialResult']['status'])) { ?>
                            <tr>
                                <td style="background-color: white;">Status: &nbsp; <b><?= $resultFound['RemedialResult']['status']; ?></b></td>
                            </tr>
                            <?php
                        }
                        if (isset($resultFound['RemedialResult']['modified']) && !empty($resultFound['RemedialResult']['modified']) && $resultFound['RemedialResult']['modified'] != '0000-00-00 00:00:00') { ?>
                            <tr>
                                <td style="background-color: white;">Updated: &nbsp; <?= $this->Time->timeAgoInWords($resultFound['RemedialResult']['modified'], array('format' => 'M j, Y', 'end' => '1 year', 'accuracy' => array('month' => 'month'))); ?></td>
                            </tr>
                            <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} ?>