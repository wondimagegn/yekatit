<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('SMIS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
       
	<?php echo $scripts_for_layout; ?>
    <link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/text.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/960.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/layout.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/common.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/horizontalmenu.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/common1.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/css/nav.css" media="screen" />
  
</head>
<body>
     
		<div class="container_16">
		  
		
			
			<div  id="ajax_div" class="grid_16">
			            <?php 
						 if ($session->check('Message.flash')) {
                                 echo $session->flash();
                           }
                         ?>
			            <?php echo $content_for_layout; ?>
			     
			      
			</div>
			
			    
			
			<div class="clear"></div>
			
		   
			<div class="grid_16" id="site_info">
				<!-- <div class="box">
					<p>Fluid 960 Grid System, created by <a href="http://www.domain7.com/WhoWeAre/StephenBau.html">Stephen Bau</a>, based on the <a href="http://960.gs/">960 Grid System</a> by <a href="http://sonspring.com/journal/960-grid-system">Nathan Smith</a>. Released under the 
		<a href="../../../licenses/GPL_license.txt">GPL</a> / <a href="../../../licenses/MIT_license.txt">MIT</a> <a href="../../../README.txt">Licenses</a>.</p> 
				</div> --->
			</div>
			<div class="clear"></div>
		</div>
	
</body>

</html>
