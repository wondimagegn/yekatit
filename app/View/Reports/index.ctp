<div class="row" style="margin-top:-20px">

    <?php
    if (isset($statArray['Registration']['total_registration'])) { ?>
        <div class="large-4 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="icon-graph-pie"></i><span style="font-weight: bold;">Registration Stat for <?= $currentAcademicYear . '-' . $currentSemester; ?></span></h3>
                </div>
                <div class="box-body " style="display: block;">
                    <div class="stats-wrap">
                        <h2><b class="counter-up" style="color:#333;"><?= $statArray['Registration']['total_registration'];?></b>
                            <span style="background:#888;" >+<b class="counter-up"><?= number_format(((($statArray['Registration']['total_registration']) / ($statArray['Registration']['total_active_student_in_section'] - $statArray['Registration']['dismissalStat']['dismissedTotalCount'])) * 100), 2, '.', ''); ?></b>%</span>
                        </h2>
                        <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Total Registered<small style="font-weight: bold;"><strong>Completed</strong></small></p>

                        <h4 style="color:#333;"><b class="counter-up"><?= $statArray['Registration']['total_registration_male']; ?> </b> 
                            <span style="background:#888;">+<b class="counter-up"><?= number_format(((($statArray['Registration']['total_registration_male']) / ($statArray['Registration']['total_active_male_in_section'] - $statArray['Registration']['dismissalStat']['dismissedMaleTotalCount'])) * 100), 2, '.', ''); ?></b>%</span>
                        </h4>
                        <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Total Male<small style="font-weight: bold;"><strong>Completed</strong></small></p>

                        <h4 style="color:#333;"><b class="counter-up"><?= $statArray['Registration']['total_registration_female']; ?></b>
                            <span style="background:#888;">+<b class="counter-up"><?= number_format(((($statArray['Registration']['total_registration_female']) / ($statArray['Registration']['total_active_female_in_section'] - $statArray['Registration']['dismissalStat']['dismissedFemaleTotalCount'])) * 100), 2, '.', ''); ?></b>%</span>
                        </h4>
                        <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Total Female<small style="font-weight: bold;"><strong>Completed</strong></small></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    if (isset($statArray['Student']['total']) && !empty($statArray['Student']['total'])) { ?>
        <div class="large-4 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="icon-graph-pie"></i><span style="font-weight: bold;">Admission Summary</span></h3>
                </div>
                <div class="box-body " style="display: block;">
                    <div style="margin:0" class="row summary-border-top">
                        <div class="large-6 columns">
                            <div class="summary-nest">
                                <!-- Overall -->
                                <h2 class="text-black"><span class="counter-up"><?= $statArray['Student']['total_male']; ?></span><small></small></h2>
                                <p>Overall Male</p>
                            </div>
                        </div>
                        <div class="large-6 columns summary-border-left">
                            <div class="summary-nest">
                                <!-- Overall   -->
                                <h2 class="text-black"><span class="counter-up"><?= $statArray['Student']['total_female']; ?></span><small></small></h2>
                                <p>Overall Female</p>
                            </div>
                        </div>
                    </div>
                    <div style="margin:0" class="row summary-border-top">
                        <div class="large-12 columns">
                            <h6 class="text-black" style="text-align:center"><?= $currentAcademicYear; ?></h6>			
                        </div>                                    
                        <div class="large-6 columns">
                            <div class="summary-nest">                                    
                                <h2 class="text-black"><span class="counter-up"><?= $statArray['Student']['total_new_male']; ?></span><small></small></h2>
                                <p>Male</p>
                            </div>
                        </div>
                        <div class="large-6 columns summary-border-left">
                            <div class="summary-nest">
                                <h2 class="text-black"><span class="counter-up"><?= $statArray['Student']['total_new_female']; ?></span></h2>
                                <p>Female</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="large-4 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="icon-graph-pie"></i><span style="font-weight: bold;">Student Stats</span></h3>
                </div>
                <div class="box-body " style="display: block;">
                    <div style="margin:15px 0 0" class="box-body no-pad">
                        <div class="stats-wrap">
                            <h2><b class="counter-up" style="color:#333;"><?= $statArray['Student']['total']; ?></b> 
                            <span style="background:#888;">+<b class="counter-up"><?= ($statArray['Student']['total_new'] > 0 ? (number_format((($statArray['Student']['total_new'] / $statArray['Student']['total']) * 100), 2, '.', '')) : '0'); ?></b>%</span>
                            </h2>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Total students<small style="font-weight: bold;">This Year</small></p>

                            <h4><b class="counter-up" style="color:#333;"><?= $statArray['Student']['total_graduate_overall']; ?></b> 
                                <span style="background:#888;">+<b class="counter-up"><?= ($statArray['Student']['total_graduate_overall'] > 0 ? (number_format((($statArray['Student']['total_graduate_new'] / $statArray['Student']['total_graduate_overall']) * 100), 2, '.', '')) : '0'); ?></b>%</span>
                            </h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Graduate <small style="font-weight: bold;"></small></p>
                            
                            <h4><b class="counter-up" style="color:#333;"><?= $statArray['Student']['total_new']; ?></b> 
                                <!-- <span style="background:#888;"><b class="counter-up"></b></span> -->
                                <span style="background:#888;">+<b class="counter-up"><?= ($statArray['Student']['total_new'] > 0 ? (number_format((($statArray['Student']['total_new'] / $statArray['Student']['total']) * 100), 2, '.', '')) : '0'); ?></b>%</span>
                            </h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">New students<small style="font-weight: bold;"><?= $currentAcademicYear; ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } 

    if (isset($statArray['Registration']['dismissalStat']) && !empty($statArray['Registration']['dismissalStat'])) { ?>
        <div class="large-4 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="icon-graph-pie"></i><span style="font-weight: bold;">Dismissal Stats for <?= (isset($statArray['Registration']['dismissalStat']['prevACSem']['academic_year']) && !empty($statArray['Registration']['dismissalStat']['prevACSem']['academic_year']) ? $statArray['Registration']['dismissalStat']['prevACSem']['academic_year'] . '-' . $statArray['Registration']['dismissalStat']['prevACSem']['semester'] : ''); ?></span></h3>
                </div>
                <div class="box-body " style="display: block;">
                    <div style="margin:15px 0 0" class="box-body no-pad">
                        <div class="stats-wrap">
                            <h2><b class="counter-up" style="color:#333;"><?= $statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'];?></b></h2>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Total Registered <small style="font-weight: bold;"><?= $statArray['Registration']['dismissalStat']['prevACSem']['academic_year'] . '-' . $statArray['Registration']['dismissalStat']['prevACSem']['semester']; ?></small></p>
                            
                            <h4><b class="counter-up" style="color:#333;"><?= $statArray['Registration']['dismissalStat']['dismissedTotalCount']; ?></b> 
                                <span style="background:#888;">+<b class="counter-up"><?= ($statArray['Registration']['dismissalStat']['dismissedTotalCount'] > 0 && $statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'] > 0 ? number_format((($statArray['Registration']['dismissalStat']['dismissedTotalCount'] / ($statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'])) * 100), 2, '.', '') : ''); ?></b>%</span>
                            </h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Dismissed <small style="font-weight: bold;"><?= $statArray['Registration']['dismissalStat']['prevACSem']['academic_year'] . '-' . $statArray['Registration']['dismissalStat']['prevACSem']['semester']; ?></small></p>

                            <h4><b class="counter-up" style="color:#333;"><?= $statArray['Registration']['dismissalStat']['dismissedMaleTotalCount']; ?></b> 
                                <span style="background:#888;">+<b class="counter-up"> <?= ($statArray['Registration']['dismissalStat']['dismissedMaleTotalCount'] > 0 && $statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'] > 0 ? number_format((($statArray['Registration']['dismissalStat']['dismissedMaleTotalCount'] / ($statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'])) * 100), 2, '.', '') : '0'); ?></b>%</span>
                            </h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Dismissed Male <small style="font-weight: bold;"><?= $statArray['Registration']['dismissalStat']['prevACSem']['academic_year'] . '-' . $statArray['Registration']['dismissalStat']['prevACSem']['semester']; ?></small></p> 

                            <h4><b class="counter-up" style="color:#333;"><?= $statArray['Registration']['dismissalStat']['dismissedFemaleTotalCount']; ?></b> 
                                <span style="background:#888;">+<b class="counter-up"> <?= ($statArray['Registration']['dismissalStat']['dismissedFemaleTotalCount'] > 0 && $statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'] > 0 ? number_format((($statArray['Registration']['dismissalStat']['dismissedFemaleTotalCount'] / ($statArray['Registration']['dismissalStat']['totalRegistrationInPrevSemAc'])) * 100), 2, '.', '') : '0'); ?></b>%</span>
                            </h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Dismissed Female <small style="font-weight: bold;"><?= $statArray['Registration']['dismissalStat']['prevACSem']['academic_year'] . '-' . $statArray['Registration']['dismissalStat']['prevACSem']['semester']; ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    if (isset($gradeSubmissionDelay['Instructor']['totalCourseAssignment']) && !empty($gradeSubmissionDelay['Instructor']['totalCourseAssignment'])) { ?>
        <div class="large-4 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="icon-graph-pie"></i><span style="font-weight: bold;">Grade Submission Delay <?= $currentAcademicYear . '-' . $currentSemester; ?></span></h3>
                </div>
                <div class="box-body " style="display: block;">
                    <div style="margin:15px 0 0" class="box-body no-pad">
                        <div class="stats-wrap">
                            <h4><b class="counter-up" style="color:#333;"><?= $gradeSubmissionDelay['Instructor']['totalCourseAssignment']; ?></b></h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Total Course <small style="font-weight: bold;"><?= $currentAcademicYear . '-' . $currentSemester; ?></p>

                            <h4><b class="counter-up" style="color:#333;"><?= $gradeSubmissionDelay['Instructor']['noInstDelayedSub']; ?></b> 
                                <span style="background:#888;">+<b class="counter-up"> <?= ($gradeSubmissionDelay['Instructor']['noInstDelayedSub'] > 0 && $gradeSubmissionDelay['Instructor']['totalCourseAssignment'] > 0 ? number_format((($gradeSubmissionDelay['Instructor']['noInstDelayedSub'] / ($gradeSubmissionDelay['Instructor']['totalCourseAssignment'])) * 100), 2, '.', '') : '0'); ?></b>%</span>
                            </h4>
                            <p style="background-color: #D3D3D3; font-weight: bold;" class="text-black">Delayed <small  style="font-weight: bold;"><?= $currentAcademicYear . '-' . $currentSemester; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } ?>
</div>
