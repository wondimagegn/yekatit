<?php 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('SMiS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
	
	    <?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
	    
	    <?php echo $this->Html->script('jquery-selectall'); ?>   
	    <?php echo $this->Html->script('generatepassword'); ?>      
	    <?php echo $this->Html->script('smis'); ?>      
     
	    <?php echo $this->Html->script('jquery-populate'); ?>
	     <?php //echo $this->Html->script('jquery-common'); ?>
	      <?php echo $this->Html->script('jquery-populate'); ?>
	     
	    <?php echo $this->Html->script('jquery.dropdownPlain'); ?>
     
        <?php echo $this->Html->script('jquery-department_placement');?>
        <?php //echo $this->Html->script('datepicker/date'); ?> 
       
        <?php //echo $this->Html->script('datepicker/jquery.datePicker'); ?> 
        <?php //echo $this->Html->script('datepicker/cake.datePicker'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.core'); ?> 
        <?php echo $this->Html->script('dialog/jquery.ui.widget'); ?> 
        <?php echo $this->Html->script('dialog/jquery.ui.position'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.dialog'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.mouse'); ?>
        <?php echo $this->Html->script('dialog/jquery.ui.draggable'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.resizable'); ?>
      
	<?php echo $scripts_for_layout; ?>
    <link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/datePicker.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.all.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.dialog.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.theme.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.base.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.resizable.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.tabs.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/ui/jquery.ui.core.css" media="screen" />
    <!-- <link rel="stylesheet" type="text/css" href="/css/verticalmenu.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/common.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/horizontalmenu.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/common1.css" media="screen" />
     -->
    <link rel="stylesheet" type="text/css" href="/css/common1.css" media="screen" />
    <!-- <link rel="stylesheet" type="text/css" href="/css/horizontalmenu.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/common.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/verticalmenu.css" media="screen" /> -->
	<link rel="stylesheet" type="text/css" href="/css/text.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/960.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/layout.css" media="screen" />
	
	<link rel="stylesheet" type="text/css" href="/css/nav.css" media="screen" />
	<!--<link rel="stylesheet" type="text/css" href="/css/style.css" media="screen" /> -->
	
   <!--[if IE 6]><link rel="stylesheet" type="text/css" href="/css/ie6.css" media="screen" /><![endif]-->
   <!--[if IE 7]><link rel="stylesheet" type="text/css" href="/css/ie.css" media="screen" /><![endif]-->


<script type="text/javascript">
/* window.onload = setupFunc;
 //window.onload = onChangeSetup;
 function setupFunc() {
   
   document.getElementsByTagName('body')[0].onclick = clickFunc;
 
   hideBusysign();
         Wicket.Ajax.registerPreCallHandler(showBusysign);
         Wicket.Ajax.registerPostCallHandler(hideBusysign);
         Wicket.Ajax.registerFailureHandler(hideBusysign);
    
 }
 
 function hideBusysign() {
   document.getElementById('busy_indicator').style.display ='none';
 }

 function showBusysign() {
   document.getElementById('busy_indicator').style.display ='inline';
 }

 function clickFunc(eventData) {
    
   var clickedElement = (window.event) ? event.srcElement : eventData.target;

   if ((clickedElement.tagName.toUpperCase() == 'A' 
          && ((clickedElement.target == null) || (clickedElement.target.length <= 0))
          && (clickedElement.href.lastIndexOf('#') != (clickedElement.href.length-1))
          && (!('nobusy' in clickedElement))
          && (clickedElement.href.indexOf('skype') < 0)
          && (clickedElement.href.indexOf('mailto') < 0)
          && (clickedElement.href.indexOf('WicketAjaxDebug') < 0)
          && (clickedElement.href.lastIndexOf('.doc') != (clickedElement.href.length-4))
          && (clickedElement.href.lastIndexOf('.pdf') != (clickedElement.href.length-4))
          && (clickedElement.href.lastIndexOf('.csv') != (clickedElement.href.length-4))
          && (clickedElement.href.lastIndexOf('.xls') != (clickedElement.href.length-4))
          && ((clickedElement.onclick == null) || (clickedElement.onclick.toString().indexOf('window.open') <= 0))
          ) 
      || (clickedElement.parentNode.tagName.toUpperCase() == 'A' 
          && ((clickedElement.parentNode.target == null) || (clickedElement.parentNode.target.length <= 0))
          && (clickedElement.parentNode.href.indexOf('skype') < 0)
          && (clickedElement.parentNode.href.indexOf('mailto') < 0)
          && (clickedElement.parentNode.href.lastIndexOf('#') != (clickedElement.parentNode.href.length-1))
          && (clickedElement.parentNode.href.lastIndexOf('.doc') != (clickedElement.parentNode.href.length-4))
          && (clickedElement.parentNode.href.lastIndexOf('.csv') != (clickedElement.parentNode.href.length-4))
           && (clickedElement.parentNode.href.lastIndexOf('.pdf') != (clickedElement.parentNode.href.length-4))
          && (clickedElement.parentNode.href.lastIndexOf('.xls') != (clickedElement.parentNode.href.length-4))
          && ((clickedElement.parentNode.onclick == null) || (clickedElement.parentNode.onclick.toString().indexOf('window.open') <= 0))
          ) 
      || (
         ((clickedElement.onclick == null) 
           || 
           ((clickedElement.onclick.toString().indexOf('confirm') <= 0)
            && (clickedElement.onclick.toString().indexOf('alert') <= 0) 
            && (clickedElement.onclick.toString().indexOf('Wicket.Palette') <= 0)))
         && (clickedElement.tagName.toUpperCase() == 'INPUT' && (clickedElement.type.toUpperCase() == 'BUTTON' 
              || clickedElement.type.toUpperCase() == 'SUBMIT' || clickedElement.type.toUpperCase() == 'IMAGE'))
         )
      ) {
      showBusysign();
    }
 
 
   
 }
 */
</script> 

</head>
<body>
<?php  //debug($menu); ?>
        <div id="busy_indicator">
			             <?php 
			             
			              //echo $this->Html->image('busy.gif'); ?>
			         <img src="/img/busy.gif" alt="" class="displayed" /> 
			        <?php //echo $this->Html->image('busy.gif', array('id' => 'busy-indicator')); ?>
	    </div>
		<div class="container_16">
		  
		  <div  class="grid_16 banner" style="text-align:right">
			<!-- <div class="prefix_10 banner"> -->
			   
					    <strong>
						<cake:nocache><?php 
						echo date("F j, Y, g:i a");
						?></cake:nocache>
						</strong>
				        |
				        <?php
				       
						echo $this->Html->link('Change Password','/users/changePwd');	
						
						?>
					    |
					    <?php 
					    if(isset($username)){
							echo $username;					
						}
						?>
				        |
				        
					    <?php
						echo $this->Html->link('Log Out','/users/logout');
						
						
						?>
				
			</div>
			
			<div class="clear"></div>
			<!-- <div class="grid_16"> -->
			      				    <?php
				        if((!isset($force_password_change) || $force_password_change == 0) && (!isset($password_duration_expired) || $password_duration_expired != true)) {
				        	//	echo $this->element('mainmenu/mainmenu');
				              
				                  echo $this->element('mainmenu/mainmenuOptimized');
				                  
				        }
				  
				    ?>
				 		
				
			
			
			<!-- </div> <div class="grid_16"> 
			 
			 <?php
			  
				//echo $this->element('submenu/submenu');
				// debug($menu);
			 ?>
			</div>
			-->
			
			
			<div  id="ajax_div" class="grid_16">
			
			
						<div class="message">
			            <?php 
			            //$menu
			            //debug($menu);
			             //echo $this->Session->flash('auth');
			               if ($this->Session->check('Message.auth')) {
                                 echo $this->Session->flash('auth');
                           }
                           if ($this->Session->check('Message.flash')) {
                                 echo $this->Session->flash();
                           }
    
                         ?>
						
						</div>
			            
			            <?php echo $content_for_layout; ?>
			           
			     
			      
			</div>
			
			    
			
			<div class="clear"></div>
			<div class="clear"></div>
		   
			<div class="grid_16" id="site_info">
				<!-- <div class="box">
					<p>Fluid 960 Grid System, created by <a href="http://www.domain7.com/WhoWeAre/StephenBau.html">Stephen Bau</a>, based on the <a href="http://960.gs/">960 Grid System</a> by <a href="http://sonspring.com/journal/960-grid-system">Nathan Smith</a>. Released under the 
		<a href="../../../licenses/GPL_license.txt">GPL</a> / <a href="../../../licenses/MIT_license.txt">MIT</a> <a href="../../../README.txt">Licenses</a>.</p> 
				</div> --->
				  
				 <div class="footerbox">
				   <p style="margin:0px; padding:0px"><strong>&copy; <?php echo (date("Y")); ?> 
				   Ambo University<br />
				 
				  </p> 
				 </div>
			</div>
			<div class="clear"></div>
		</div>
<?php 
   
    echo $this->Js->writeBuffer(); // Write cached scripts
    //echo $this->element('sql_dump'); 
?>	
</body>

</html>
