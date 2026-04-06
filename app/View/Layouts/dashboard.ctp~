<?php 
?>
<!DOCTYPE html>
<html class="no-js">
<head>
<!-- META CHARS -->
<?php echo $this->Html->charset(); ?>
<meta name="viewport" content="width=device-width, 
initial-scale=1.0" />
<meta charset="utf-8" />
<!-- PAGE TITLE -->
<title>
	<?php __('SIS'); ?>
</title>
<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/foundation.css" />
<?php
if(Configure::read('debug') || true) {
?>

<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/dripicon.css">
<link rel="stylesheet" href="/css/typicons.css" />
<link rel="stylesheet" href="/css/font-awesome.css" />
<link rel="stylesheet" href="/sass/css/theme.css">
<link href="/css/pace-theme-flash.css" rel="stylesheet" />
<link rel="stylesheet" href="/css/slicknav.css" />
<!--
<link href="/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
-->

<link rel="stylesheet" type="text/css" href="/css/common1.css" media="screen" />
<!--
<link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
-->
<?php } else {
echo $this->AssetCompress->css('internal.css', array('full' => true));
} 
?>
 <script type="text/javascript" src="/js/jquery.js"></script>
<script src="/js/vendor/modernizr.js"></script>
</head>
<body>	
    <!-- preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- End of preloader -->
<!--   
<div id="busy_indicator">
	<img src="/img/busy.gif" alt="" class="displayed" />	     
    </div>
-->
   <div class="off-canvas-wrap" data-offcanvas>
        <!-- right sidebar wrapper -->
        <div class="inner-wrap">
	    <!-- Right sidemenu -->
            <div id="skin-select">
                <!--      Toggle sidemenu icon button -->
                <a id="toggle">
                    <span class="fa icon-menu"></span>
                </a>
                <!--      End of Toggle sidemenu icon button -->

                <div class="skin-part">
                    <div id="tree-wrap">
                        <!-- Profile -->
                        <div class="profile">
			    <a href="/"> 
			  <img alt="" class="" 
src="/img/<?php echo Configure::read('logo'); ?>">
			    <h3>SiS <small>2</small></h3>
			</a>
			</div>
			<!-- end of profile -->
			  <!-- Menu sidebar begin-->
           <div class="side-bar">
		
			   <?php 
				echo $this->element('mainmenu/mainmenuOptimized');
				//echo $this->element('leftmenu/leftmenu');
			?>
			</div>
		    </div>
		</div>
	   </div>
	</div>
	 <!-- end right sidebar wrapper -->
            <div class="wrap-fluid" id="paper-bg">
                <!-- top nav -->
                <div class="top-bar-nest">
                    <nav class="top-bar" data-topbar role="navigation" data-options="is_hover: false">
                        <ul class="title-area left">


                            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                            <li class="toggle-topbar menu-icon"><a href="#"><span></span></a>
                            </li>
                        </ul>
 						   	
					  <section class="top-bar-section ">
					       <!--
							<ul class="left">
								
								<li>
								<span class="bg-green">
								 <a style="color:white;line-height: 27px;" href="/alumni/add">Fill Alumni Survey</a>
								 </span>
								</li>
								
							</ul>
							-->  
							<?php 
								echo $this->element('mainmenu/top-menu');

								?>
							
						   	 	
					    </section>
					   
		    </nav>
		</div>
		
		  <!-- Container Begin -->
                <div class="row" style="margin-top:-20px">
                    <div class="large-12 columns" >
			<div class="row">
			   <div class="large-12 columns" >
			       <div class="box">
						<?php 		
           
			 if ($this->Session->check('Message.auth')) {
                     echo $this->Session->flash('auth');
              }
			 	
               if ($this->Session->check('Message.flash')) {
                     echo $this->Session->flash();
               }
			
	
						?>
					    
		                      
			       </div>
			  </div>
			</div>
			  <?php echo $this->fetch('content'); ?>
		    </div>		    
		</div>
		 <footer>
                    <div id="footer">Copyrightt &copy; <?php echo date('Y');?> <?php echo Configure::read('CopyRightCompany');?></i></div>

                </footer>		
	   </div>
	
    </div>
  

<?php
if(Configure::read('debug') || true) {
?>

    <!-- main javascript library -->
   
    <script type="text/javascript" src="/js/waypoints.min.js"></script>
    <script type='text/javascript' src='/js/preloader-script.js'></script>
    

    <!-- foundation javascript -->
    <script type='text/javascript' src="/js/foundation.min.js"></script>

    <!-- main edumix javascript -->
    <script type='text/javascript' src='/js/slimscroll/jquery.slimscroll.js'></script>
    <script type='text/javascript' src='/js/slicknav/jquery.slicknav.js'></script>
    <script type='text/javascript' src='/js/sliding-menu.js'></script>
    <script type='text/javascript' src='/js/scriptbreaker-multiple-accordion-1.js'></script>
    <script type="text/javascript" src="/js/number/jquery.counterup.min.js"></script>
    <script type="text/javascript" src="/js/circle-progress/jquery.circliful.js"></script>
   

    
    <!-- additional javascript -->
    <script type='text/javascript' src="/js/number-progress-bar/jquery.velocity.min.js"></script>
    <script type='text/javascript' src="/js/number-progress-bar/number-pb.js"></script>
   
     <script type='text/javascript' src='/js/app.js'></script>
   <script type='text/javascript' src="/js/loader/loader.js"></script>
    <script type='text/javascript' src="/js/loader/demo.js"></script>


<?php } else {
echo $this->AssetCompress->script('mainjslib.js', array('full' => true));

echo $this->AssetCompress->script('foundation.js', array('full' => true));

echo $this->AssetCompress->script('maininternaledu.js', array('full' => true));
echo $this->AssetCompress->script('additionaljavascript.js', array('full' => true));
echo $this->AssetCompress->script('floatjavascript.js', array('full' => true));
} 
?>

<script src="/js/angular.min.js"></script>



<script type="text/javascript">
        $(function() {
    	    $(document).foundation();
       });	
	    $(document).ready(function() {
		$('#select-all').click(function(event) {  //on click 
		if(this.checked) { // check select status
		$('.checkbox1').each(function() { //loop through each checkbox
		this.checked = true;  //select all checkboxes with class "checkbox1"               
		});
		}else{
		$('.checkbox1').each(function() { //loop through each checkbox
		this.checked = false; //deselect all checkboxes with class "checkbox1"                       
		});         
		}
		});

		$('.checkbox1').click(function(event) {  
		//on click 
			if(!this.checked) { 
			// check select status    
				$('#select-all').attr('checked', false);
			} 
		});
		

		


	});
				
	/*
	function newMessageNotification() {
	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#AutoMessageDashBoard").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
	url	: "/dashboard/getMessageAjax",
	cache   :false,
	success : function(data)
	{

	$("#AutoMessageDashBoard").empty();
	$("#AutoMessageDashBoard").append(data);

	}
	});

	}

	function studentRank() {

	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#StudentRankDashBoard").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
	url	: "/dashboard/getRankAjax",
	cache   :false,
	success : function(data)
	{

	$("#StudentRankDashBoard").empty();
	$("#StudentRankDashBoard").append(data);
	rank_stand_retrieved=true;
	},
	error: function (xhr, ajaxOptions, thrownError) {

	$("#StudentRankDashBoard").empty();
	}

	});

	}

	function studentStudentAssignedDorm() {

	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#StudentDormDashBoard").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
	url	: "/dashboard/getStudentAssignedDormitory",
	cache   :false,
	success : function(data)
	{

	$("#StudentDormDashBoard").empty();
	$("#StudentDormDashBoard").append(data);
	rank_stand_retrieved=true;
	}
	});
	}

	function gradeChangeApproval() {

	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#GradeChangeApproval").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
	url	: "/dashboard/getApprovalRejectGradeChange",
	cache   :false,
	success : function(data)
	{

	$("#GradeChangeApproval").empty();
	$("#GradeChangeApproval").append(data);

	}
	});
	}

	function gradeApprovalConfirmation() {
		var image = new Image();
		image.src = '/img/busy.gif';  
		$("#GradeConfiramationApproval").empty().html('<img src="/img/busy.gif" class="displayed" >');

		$.ajax({
			url	: "/dashboard/getApprovalRejectGrade",
			cache   :false,
			success : function(data)
			{

			$("#GradeConfiramationApproval").empty();
			$("#GradeConfiramationApproval").append(data);

			}
		});
	}

	function getDispatchedAndAssignedCourse() {

	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#DispatchedAndAssignedCourseID").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
		url	: "/dashboard/disptachedAssignedCourseList",
		cache   :false,
		success : function(data)
		{

		$("#DispatchedAndAssignedCourseID").empty();
		$("#DispatchedAndAssignedCourseID").append(data);

		}
	});

	}

	function getAddDropRequest() {

	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#AddDropRequest").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
	url	: "/dashboard/addDropRequestList",
	cache   :false,
	success : function(data)
	{

	$("#AddDropRequest").empty();
	$("#AddDropRequest").append(data);

	}
	});

	}

	function getClearanceWithdrawSubRequest() {

	var image = new Image();
	image.src = '/img/busy.gif';  
	$("#WithdrawClearnceSubRequest").empty().html('<img src="/img/busy.gif" class="displayed" >');

	$.ajax({
	url	: "/dashboard/clearanceWithdrawSubRequest",
	cache   :false,
	success : function(data)
	{

	$("#WithdrawClearnceSubRequest").empty();
	$("#WithdrawClearnceSubRequest").append(data);

	}
	});

	}

	function getProfileNotComplet() {
	var image = new Image();
	image.src = '/img/busy.gif';
	$("#ProfileNotComplete").empty().html('<img src="/img/busy.gif" class="displayed">');
	$.ajax({
	url	: "/dashboard/getProfileNotComplete",
	cache   :false,
	success : function(data)
	{
	$("#ProfileNotComplete").empty();
	$("#ProfileNotComplete").append(data); 
	}
	});
	}

	function getBackupAccountRequest() {
	var image = new Image();
	image.src = '/img/busy.gif';
	$("#BackupAccountRequest").empty().html('<img src="/img/busy.gif" class="displayed">');
	$.ajax({
	url	: "/dashboard/getBackupAccountRequest",
	cache   :false,
	success : function(data)
	{
	$("#BackupAccountRequest").empty();
	$("#BackupAccountRequest").append(data); 
	}
	});
	}

	function getAcademicCalender() {
	var image = new Image();
	image.src = '/img/busy.gif';
	$("#AcademicCalender").empty().html('<img src="/img/busy.gif" class="displayed">');
	$.ajax({
	url	: "/dashboard/getAcademicCalender",
	cache   :false,
	success : function(data)
	{
	$("#AcademicCalender").empty();
	$("#AcademicCalender").append(data); 
	}
	});
	}

	function getCourseSchedule() {
	var image = new Image();
	image.src = '/img/busy.gif';
	$("#CourseSchedule").empty().html('<img src="/img/busy.gif" class="displayed">');
	$.ajax({
	url	: "/dashboard/getCourseSchedule",
	cache   :false,
	success : function(data)
	{
	$("#CourseSchedule").empty();
	$("#CourseSchedule").append(data); 
	},
	error: function(xhr, status, error) {
	// handle error

	alert(error);
	}
	});
	}

*/
</script>
<script src="/js/smisangularapp.js"></script>
<script>
/*
$(document).ready(function() {
    $("a").click(function() {
        
   		//https://enricopiccini.com/en/kb/AngularJs_Abort_all_pending_ajax_requests_before_change_route-635
   		$scope.getApprovalRejectGrade.unsubscribe();
    });
});
*/
</script>
<?php

//echo $this->Js->writeBuffer(); 
echo $this->fetch('script');
?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
