<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Staff Profile'); ?> <?= (isset($staff_profile['Staff']['full_name']) ? ' - '. (ucwords( strtolower(trim($staff_profile['Staff']['full_name'])))) . ' ('. $staff_profile['Staff']['staffid'] .')' : ''); ?> </span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns" style="margin-top: -35px;">
                <hr>
                <?php
				echo $this->Form->create('Staff');
				if (!isset($staff_profile)) { ?>
                    <fieldset style="padding-bottom: 5px;">
                        <legend>&nbsp;&nbsp; Search Staff Profile &nbsp;&nbsp;</legend>
                        <div class="row">
                            <div class="large-4 columns">
                                <?= $this->Form->input('staffid', array('label' => false, 'placeholder' => 'Type Staff '. Configure::read('CompanyShortName').' ID...', 'required', 'maxlength' => 25)); ?>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <?= $this->Form->Submit('Search', array('name' => 'continue', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
                    <?php
                }
				
                if (!empty($staff_profile)) {
					$this->assign('title_details', (!empty($this->request->params['controller']) ? ' ' . Inflector::humanize(Inflector::underscore($this->request->params['controller'])) . (!empty($this->request->params['action']) && $this->request->params['action'] != 'index' ? ' | ' . ucwords(str_replace('_', ' ', $this->request->params['action'])) : '') : '') . (isset($staff_profile['Staff']['full_name']) ? ' - ' . (ucwords(strtolower(trim($staff_profile['Staff']['full_name'])))) . ' (' . $staff_profile['Staff']['staffid'] . ')' : ''));
                    echo $this->element('staffs/staff_profile');
                } ?>
            </div>
        </div>
    </div>
</div>
