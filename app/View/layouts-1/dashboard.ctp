<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('SMIS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
	
	    <?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
	  
      
	<?php echo $scripts_for_layout; ?>
  
	<link rel="stylesheet" href="/css/960.css" type="text/css" media="screen" charset="utf-8" />
	 <link rel="stylesheet" type="text/css" href="/css/nav.css" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/css/template.css" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/css/colour.css" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/css/layout.css" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css" media="screen" />
    
		<!--[if IE]><![if gte IE 6]><![endif]-->
	<link href="/js/glow/1.7.0/widgets/widgets.css" type="text/css" rel="stylesheet" />
	<script src="/js/glow/1.7.0/core/core.js" type="text/javascript"></script>
	<script src="/js/glow/1.7.0/widgets/widgets.js" type="text/javascript"></script>
	
       
<script type="text/javascript">
			glow.ready(function(){
				new glow.widgets.Sortable(
					'#content .grid_5, #content .grid_6',
					{
						draggableOptions : {
							handle : 'h2'
						}
					}
				);
			});
</script>
</head>

<body>
  <?php 
   // debug($menuoptimized);
  ?>
        <div id="busy_indicator">
			             <?php  //echo $this->Html->image('busy.gif'); ?>
			        <img src="/img/busy.gif" alt="" class="displayed" />
	    </div>
		<div class="container_16">
		  
		  <div  class="grid_16 banner" style="text-align:right">
			<!-- <div class="prefix_10 banner"> -->
			   
					    <strong>
						<?php echo date("F j, Y, g:i a");?>
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
				      // echo $this->element('mainmenu/mainmenu');
				         echo $this->element('mainmenu/mainmenuOptimized');
				         
				  
				    ?>
				 		
				
			
			
			<!-- </div> <div class="grid_16"> 
			 
			 <?php
			  
				//echo $this->element('submenu/submenu');
				// debug($menu);
			 ?>
			</div>
			-->
			
			
		   <div  id="ajax_div" class='grid_16_modified' > 
			
			
						<div class="message">
			            <?php 
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
				   Arba Minch University </p> 
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
