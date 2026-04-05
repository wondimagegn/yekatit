<?php
if (isset($resultFound) && !empty($resultFound)) { ?>
    <div class="row">
        <div class="large-12 columns">
            <div style="overflow-x:auto;">

                <fieldset>
                    <legend>&nbsp;&nbsp; Admission & Campus Details &nbsp;&nbsp;</legend>
                    <div class="large-6 columns">
                        <span class="fs14">
                            Full Name: &nbsp; &nbsp; <b class="text-black"><?= ucwords(strtolower($resultFound['CampusPlacement']['full_name'])); ?></b> <br>
                            Gender: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['gender']; ?></b> <br>
                            Student ID: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['studentnumber']; ?></b> <br>
                            Stream: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['stream']; ?></b> <br>
                            Admission Year: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['admission_year']; ?></b> <br>
                            Admission: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['program']; ?></b> <br>
                            Admission Type: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['program_type']; ?></b> <br>
                            Assigned Campus: &nbsp; &nbsp; <b class="text-black"><?= $resultFound['CampusPlacement']['campus']; ?></b> <br> <br>
                            <?php
                            if (isset($resultFound['CampusPlacement']['modified']) && !empty($resultFound['CampusPlacement']['modified']) && $resultFound['CampusPlacement']['modified'] != '0000-00-00 00:00:00') { ?>
                                Updated: &nbsp; &nbsp; <b><?= $this->Time->timeAgoInWords($resultFound['CampusPlacement']['modified'], array('format' => 'M j, Y', 'end' => '1 year', 'accuracy' => array('month' => 'month'))); ?></b> <br>
                                <?php
                            } ?>
                        </span>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <?php
} ?>