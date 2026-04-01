<?php ?>
<div class="box" ng-app="generalReport" >
     <div class="box-body" ng-controller="reportCntrl">
       <div class="row">
	  <div class="large-12 columns">
		 
<div class="form">
<?php echo $this->Form->create('Staff');?>
<p class="fs16">
             <strong> Important Note: </strong> 
               This tool will help you to get some predefined reports. By providing some criteria you can find report.
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($attrationRate) || !empty($student_lists) 
|| !empty($student_lists) || !empty($resultBy)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
	}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
	}
?>
</div>
<div id="ListPublishedCourse" 
style="display:block;">

<table cellspacing="0" cellpadding="0" class="fs13" >
	<tr>
		<td> Report Type:</td>
		<td><?php echo $this->Form->input('report_type', array('label'=> false, 'type' => 'select', 'style' => 'width:200px', 'div' => false,'empty'=>'Select Report Type','onchange' => 'toggleFields("reportType")', 'options' => $report_type_options,'id'=>'reportType')); ?> <span style="font-size:11px"></span></td>	

		<td> Gender:</td>
		<td><?php echo $this->Form->input('gender', array('id' => 'Gender', 
		'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false,
		 'options' => array('all' => 'All', 'female' => 'Female', 'male' => 'Male'))); ?></td>	
	</tr>
	
	<tr>
		<td style="width:10%">Department:</td>
		<td style="width:25%"><?php echo $this->Form->input('department_id', array('id' => 'Department', 'class' => 'fs14','style' => 'width:300px', 'label' => false, 'type' => 'select', 'options' => $departments, 'default' => $default_department_id)); ?></td>

		
	</tr>

	

	<?php 

if(isset($this->data['Staff']['report_type'])
&& ($this->data['Staff']['report_type']=='distributionStatsGenderTeachersByGender' || $this->data['Staff']['report_type']=='distributionStatsByAcademicRank' 
|| $this->data['Staff']['report_type']=='distributionStatsByStudents')) { ?>
        
         <tr>
		
		<td class="visibleOnDistribution" colspan="2">Graph Type:</td>
		<td  class="visibleOnDistribution" colspan="2">
                 <?php echo $this->Form->input('graph_type', array('label'=> false, 'type' => 'select', 'div' => false, 'options' =>$graph_type)); ?>
		</td>
	</tr>
	<?php } else { ?>
               <tr>

		<td class="visibleOnDistribution" colspan="2" style="display:none;">Graph Type:</td>
		<td  class="visibleOnDistribution" colspan="2" style="display:none">
                 <?php echo $this->Form->input('graph_type', array('label'=> false, 'type' => 'select', 'div' => false, 'options' =>$graph_type)); ?>
		</td>
	</tr>
         
	<?php } ?>


	<tr>
		<td colspan="2">
		<?php echo $this->Form->submit(__('Get Report', true), array('name' => 'getReport', 'div' => false,'class'=>'tiny radius button bg-blue')); ?>
		</td>

		<td colspan="2" >
		<?php echo $this->Form->submit(__('Export Report Excel', true), array('name' => 'getReportExcel', 'div' => false,'class'=>'tiny radius button bg-blue','onclick'=>'')); ?>
		</td>

	</tr>
	
</table>
</div>

<?php 	

echo $this->Form->end(); ?>
</div>

<?php 
  if (isset($distributionStatistics['distributionStatsTeachersByGender']) && !empty($distributionStatistics['distributionStatsTeachersByGender'])) {
         echo $this->element('staffs/distribution_stat');
  } else if (!empty($distributionStatistics['distributionStatsTeachersByAcademicRank'])) {
  	 echo $this->element('staffs/distribution_academicrank_stat');
  }  else if (!empty($distributionStatistics['getDistributionStatsTeacherToStudents'])) {
  	 echo $this->element('staffs/distribution_teachertostudent_stat');
  } else if(isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) {

  	 echo $this->element('staffs/active_staff_list');

  } else {
      echo '<div id="flashMessage" class="info-box info-message"><span></span>There is no report in the selected criteria</div>';
  }
?>           
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
	

    </div> <!-- end of box-body -->
	
</div><!-- end of box -->

<script type="text/javascript">

function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}

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

//this toggles the visibility of our parent permission fields depending on the current selected value of the underAge field
//this toggles the visibility of our parent permission fields depending on the current selected value of the underAge field
function toggleFields(id)
{
   
    if ($("#"+id).val() == 'attrition_rate') {
	
     	$(".notVisibleOnAttritionRate ").hide();
    } else if(($('#'+id).val()=='distributionStatsGenderTeachersByGender' || $('#'+id).val()=='distributionStatsByAcademicRank'
|| $('#'+id).val()=='distributionStatsByStudents' )) { 
	
		$('.visibleOnDistribution').show();
		$('.academicStatus').hide();
		 $(".academicStatus").hide();

    } else if($("#"+id).val() == 'top_students') {
       
		$(".notVisibleOnAttritionRate ").show();
		 $(".academicStatus").hide();

    } else if ($("#"+id).val() == 'grade_change_statistics') {
		$(".gradeChangeState").hide();
		 $(".academicStatus").hide();

    } else if ($("#"+id).val() == 'academic_status_range') {
		 $(".academicStatus").show();
    } else {
        $(".academicStatus").hide();
	    $(".notVisibleOnAttritionRate ").hide();
        $('.visibleOnDistribution').hide();
    }
  
}

</script>
