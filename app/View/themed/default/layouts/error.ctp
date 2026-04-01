<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		404 Error Page
	</title>
	<?php   echo $this->Html->css('reset'); ?> 
	<?php   echo $this->Html->css('datePicker'); ?> 
	<?php   echo $this->Html->css('common1'); ?> 
	<?php   echo $this->Html->css('text'); ?> 
	<?php   echo $this->Html->css('960'); ?> 
	<?php   echo $this->Html->css('layout'); ?> 
	<?php   echo $this->Html->css('nav'); ?> 
   <!--[if IE 6]>
      <?php   echo $this->Html->css('ie6'); ?> 
   <![endif]-->
   <!--[if IE 7]>
      <?php   echo $this->Html->css('ie'); ?> 
  <![endif]-->

</head>
<body>
      
		<div class="container_16">
		  

			
			<div class="clear"></div>
		
			
			<div  id="ajax_div" class="grid_16" style='align:center'>
			
			            <?php echo $content_for_layout; ?>
			           
			     
			      
			</div>
			
			    
			
			<div class="clear"></div>
			<div class="clear"></div>
		   
			<div class="grid_16" id="site_info">
				 <div class="footerbox">
				   <p style="margin:0px; padding:0px"><strong>&copy; <?php echo (date("Y")); ?> Arba Minch University<br /></strong>Designed and Developed By Mereb Technologies <a href="http://www.merebtechnologies.com" style="color:#ebad05">MerebTechnologies.com</a> </p> 
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
