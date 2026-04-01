<?php ?>
<script type="text/javascript">
var image = new Image();
image.src = '/img/busy.gif';

$(document).ready(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$("#dialog-modal-box").dialog({
			heght: 140,
			width: 450,
			autoOpen: false,
			closeOnEscape: true,
			modal: true

	});

	$(".jsviewModal").click(function() {
				$("#dialog-modal-box").empty().html('<img src="'+image.src+'" class="displayed" />');
				$("#dialog-modal-box").dialog("open");
				
				return false;
	});		

});
</script>

<div id="dialog-modal-box" title="Detail of Un-Upgraded Students"></div>
<?php
echo $this->Form->create('Section');  
if($role_id == ROLE_DEPARTMENT){
	echo "<div class='centeralign_smallheading'> Upgrade Sections</div>";
    echo "<div class='font'>".$college_name."</div>";
    echo "<div class='font'>"."Department of ".$department_name."</div>";

?>
<table cellpadding="0" cellspacing="0">
	<?php 
       
        echo '<tr><td width="250PX">'. $this->Form->input('Section.program_id',array('empty'=>"--Select Program--")).'</td>'; 
        echo '<td width="400PX">'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--")).'</td></tr>';  
         echo '<tr><td width="400PX">'. $this->Form->input('Section.academicyear',array('type'=>'select', 'options'=>$acyear_array_data,'empty'=>'--Select Academic Year--')).'</td>';   
        echo '<td width="250PX">'. $this->Form->input('Section.year_level_id',array('empty'=>'All')).'</td></tr>'; 
        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','div'=>false)).'</td></tr>'; 
	?> 
</table>
<?php

if(!empty($formatedSections)){

foreach($formatedSections as $fsk=>$fsv){
	echo '<div class="smallheading">'.$fsk.'</div>';
	echo '<table style="border: #CCC solid 2px">';
	echo '<tr><td class="font"> Upgrade able Sections</td></tr>';
	if(isset($fsv['Upgradable']) && !empty($fsv['Upgradable'])){
		echo '<tr><td><table><tr>';
		foreach($fsv['Upgradable'] as $ufsk=>$ufsv){
			$unqualified_count = 0;
			if(isset($unqualified_students_count[$ufsk])){
				$unqualified_count = count($unqualified_students_count[$ufsk]);
			}
			echo '<td>'.$this->Form->input('Section.Upgradbale_Selected.'.$ufsk,array('class'=>'upgradableSelectedSection','type'=>'checkbox','value'=>$ufsk,'label'=>$ufsv));
			if($unqualified_count !=0){ echo '('.$this->Js->link($unqualified_students_count[$ufsk].' unqualified Students',array('action'=>'get_modal_box',$ufsk),array('class'=>'jsviewModal','update'=>"#dialog-modal-box")).')';}
			echo '</td>';
		}
	/*echo $this->Js->get("input.upgradableSelectedSection")->event("change", $this->Js->request(array('controller'=>'sections',
			'action'=>'getUnupgradableStudentCount'), array(
						'update'=>"#unupgradableStudentCount",
						'async' => true,
						'method' => 'post',
						'dataExpression'=>true,
						'data'=> $this->Js->serializeForm(array(
						'isForm' => false,
						'inline' => true
			))
		))
	); */
		
		echo '</tr></table></td></tr>';
		//echo '<tr><td><div id="unupgradableStudentCount"></div></td></tr>';
	
	}
	if(isset($fsv['Unupgradable']) && !empty($fsv['Unupgradable'])){
		echo '<tr><td class="font"> The following list of sections are not qualify for upgrade. Since one or more published courses grade are not sumbited for those sections.</td></tr>';
		echo '<tr><td><table><tr>';
		foreach($fsv['Unupgradable'] as $uufsk=>$uufsv){
			echo '<td>'.$uufsv.'</td>';
		}
		echo '</tr></table></td></tr>';
	}
	echo '</table>';
}
echo $this->Form->Submit('Upgrade',array('name'=>'upgrade','div'=>false));
} else if(empty($formatedSections) && !($isbeforesearch)) { 
	echo "<div class='info-box info-message'><span></span> There is no section to upgradre in the search criteria </div>";
}
} // close if department
$this->Form->end(); 
?>
