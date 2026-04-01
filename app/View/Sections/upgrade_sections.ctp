<?php echo $this->Form->create('Section');  ?>
<script type='text/javascript'>
function toggleViewFullId(id) {
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}
</script>

<div class="box">
   <div class="box-body">
	<div class="row">
		<div class="large-12 columns">
		   <div id="myModalUpgrade" class="reveal-modal" data-reveal>

			</div>
		</div>
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Upgrade year level of students');?>
		      </h2>
		</div>
	</div>
    <div class="row">
	  <div class="large-12 columns">

	   <p class="fs16">
                    <strong> Important Note: </strong> 
                    This tool will help you to upgrade student section to next year level.
                    
</p>
<div onclick="toggleViewFullId('ListUpgradableSection')"><?php 
	if (!empty($sections)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListUpgradableSectionImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListUpgradableSectionTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListUpgradableSectionImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListUpgradableSectionTxt">Hide Filter</span><?php
		}
?>
</div>

<div id="ListUpgradableSection" style="display:<?php echo (!empty($formatedSections) ? 'none' : 'display'); ?>">

<table cellpadding="0" cellspacing="0">
	<?php 

	 echo '<tr><td>'. $this->Form->input('Section.college_id',array('id'=>'ajax_college_id','label'=>false,
			 'type'=>'select','id'=>'ajax_college_id','onchange'=>'getDepartments()','div'=>false,'style'=>'width:60%')).'</td>'; 
        echo '<td>'. $this->Form->input('Section.department_id',array('id'=>'ajax_department_id','label'=>false,
			 'type'=>'select','id'=>'ajax_department_id',
			 'onchange'=>'getYearLevel()','div'=>false,'style'=>'width:60%')).'</td></tr>';  

       
        echo '<tr><td>'. $this->Form->input('Section.program_id',array('empty'=>"--Select Program--")).'</td>'; 
        echo '<td>'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--")).'</td></tr>';  
         echo '<tr><td>'. $this->Form->input('Section.academicyear',array('type'=>'select', 'options'=>$acyear_array_data,'empty'=>'--Select Academic Year--')).'</td>';   
        echo '<td>'. $this->Form->input('Section.year_level_id',array('empty'=>'All','id'=>'ajax_year_level_id')).'</td></tr>'; 
        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>'; 
	?> 
</table>
</div>
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
				if($unqualified_count !=0){ 
	echo '('.$this->HTML->link($unqualified_students_count[$ufsk].' unqualified Students','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalUpgrade',
'data-reveal-ajax'=>'/sections/get_modal_box/'.$ufsk)).')';
	}
				echo '</td>';
			}
			echo '</tr></table></td></tr>';
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
	echo $this->Form->Submit('Upgrade',array('name'=>'upgrade','class'=>'tiny radius button bg-blue','div'=>false));
	} else if(empty($formatedSections) && !($isbeforesearch)) { 
		echo "<div class='info-box info-message'>
<span></span> There is no section to upgrade in the search criteria </div>";
	}
?>    
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
<?php $this->Form->end(); ?>

<script type="text/javascript">
 

    function getDepartments() {
                //serialize form data
                var col = $("#ajax_college_id").val();
                $("#ajax_department_id").attr('disabled', true);
                $("#ajax_department_id").empty().html('<img src="/img/busy.gif" class="displayed" >');
                $("#ajax_year_level_id").empty();
                //get form action
                var formUrl = '/course_schedules/get_departments/'+col;
                $.ajax({
                    type: 'get',
                    url: formUrl,
                    data: col,
                    success: function(data,textStatus,xhr){
                            $("#ajax_department_id").attr('disabled', false);
                            $("#ajax_department_id").empty();
                            $("#ajax_department_id").append(data);
                    },
                    error: function(xhr,textStatus,error){
                            alert(textStatus);
                    }
                });
                return false;
     }

     //Get year level
    function getYearLevel() {
                //serialize form data
                var dept = $("#ajax_department_id").val();
                $("#ajax_year_level_id").attr('disabled', true);
                $("#ajax_year_level_id").empty().
                html('<img src="/img/busy.gif" class="displayed" >');
                var formUrl = '/dormitory_assignments/get_year_levels/'+dept;
                $.ajax({
                    type: 'get',
                    url: formUrl,
                    data: dept,
                    success: function(data,textStatus,xhr){
                        $("#ajax_year_level_id").attr('disabled', false);
                        $("#ajax_year_level_id").empty();
                        $("#ajax_year_level_id").append('<option value="0">All</option');
                        $("#ajax_year_level_id").append(data);
                    },
                    error: function(xhr,textStatus,error){
                            alert(textStatus);
                    }
                });
                return false;
    }
     

</script>
