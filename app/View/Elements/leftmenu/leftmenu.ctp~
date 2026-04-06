<?php 
$controller=str_replace('_','',$this->request->params['controller']);
$action=!empty($this->request->params['action'])?$this->request->params['action']:'index';
if($controller=="pages" && $action=="academic_calender"){
   $arr_mod['active']='active';
   $arr_mod['action']='academic_calender';
} else if($controller=="pages" && $action=="official_transcript_request"){
  $arr_mod['active']='active';
   $arr_mod['action']='official_transcript_request';
} else if($controller=="pages" && $action=="admission"){
  $arr_mod['active']='active';
   $arr_mod['action']='admission';
}
?>
<ul id='menu-showhide' class='topnav slicknav'>  
	  <li class="<?php if(!empty($arr_mod['active']) && $arr_mod['action']=='academic_calender') echo $arr_mod['active'];?>">
			 <a href="/pages/academic_calender">Academic Calendar</a>
	  </li>
	  <li class="<?php if(!empty($arr_mod['active']) && $arr_mod['action']=='official_transcript_request')echo $arr_mod['active'];?>">
	    <a href="#">Transcript</a>
	    <ul class="vertical menu">
			<li>
			 <a href="/pages/official_transcript_request">Transcript Request</a>
			 </li>
			 <li>
			 <a href="/pages/official_request_tracking">Official request status tracking</a>
			 </li>
		 
		 </ul>
	  </li>
	  <li class="<?php if(!empty($arr_mod['active']) && $arr_mod['action']=='admission') echo $arr_mod['active'];?>">
		 <a href="#">Admission</a>
		   <ul class="vertical menu">
			<li>
			 <a href="/pages/admission">Online Admission </a>
			 </li>
			 <li>
			 <a href="/pages/online_admission_tracking">Track Online Admission Status</a>
			 </li>
		    
		 </ul>
	  </li>
	  
	   <li class="<?php if(!empty($arr_mod['active']) && $arr_mod['action']=='alumni') echo $arr_mod['active'];?>">
		 <a href="#">Alumni</a>
		   <ul class="vertical menu">
			<li>
			 <a href="/alumni/member_registration">Alumni Registration </a>
			 </li>
			 
		 </ul>
	  </li>
</ul>
