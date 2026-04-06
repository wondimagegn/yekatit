<div class="periodSettings form">
<?php echo $this->Form->create('PeriodSetting');?>
<div class="smallheading"><?php __('Add Period Setting'); ?></div>
<table cellpadding="0" cellspacing="0">
	<?php
		$period_array = array();
		for($i=1;$i<=15;$i++){
			$period_array[$i] = $i;
		}
		echo "<div class='font'>".$college_name."</div>";
		echo $this->Form->hidden('college_id',array('value'=>$college_id));
		echo '<tr><td>'.$this->Form->input('period',array('type'=>'select','options'=>$period_array)).'</td>';
		echo '<td>'.$this->Form->input('hour',array('label'=>'Starting Time')).'</td></tr>';
	?>
	</table>
<?php echo $this->Form->end(__('Submit', true));?>
<?php if(isset($periodSettings)) {
            echo '<div class="smallheading">Already Recorded Period Settings</div>';
            echo "<table style='border: #CCC solid 1px'>";
            echo "<tr><th style='border-right: #CCC solid 1px'>S.N<u>o</u></th><th style='border-right: #CCC solid 1px'>Period
				</th><th style='border-right: #CCC solid 1px'>Starting Time</th><th style='border-right: #CCC solid 1px'>
				Action</th></tr>";
			$count = 1;
            foreach($periodSettings as $psk=>$psv){
				echo "<tr><td style='border-right: #CCC solid 1px'>".$count++."</td><td style='border-right: #CCC solid 1px'>".
					$psv['PeriodSetting']['period']."</td><td style='border-right: #CCC solid 1px'>".
					$this->Format->humanize_hour($psv['PeriodSetting']['hour']).
				"</td><td style='border-right: #CCC solid 1px'>".
				/*$this->Html->link(__('View', true), array('action' => 'view', $psv['PeriodSetting']['id'])).'&nbsp;&nbsp;&nbsp;'. 
				$this->Html->link(__('Edit', true), array('action' => 'edit', $psv['PeriodSetting']['id'],"fromadd")).'&nbsp;&nbsp;&nbsp;'.*/
				$this->Html->link(__('Delete', true), array('action' => 'delete', $psv['PeriodSetting']['id'],"fromadd"),
					null, sprintf(__('Are you sure you want to delete?', true), $psv['PeriodSetting']['hour'],"fromadd")).
				"</td></tr>";
            }
            echo "</table>";
    } ?>
</div>
