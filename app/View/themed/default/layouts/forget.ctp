<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('SMIS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
       
	<?php echo $scripts_for_layout; ?>
	 <?php  echo $this->Html->css('reset'); ?> 
     <?php  echo $this->Html->css('text'); ?> 
     <?php  echo $this->Html->css('960'); ?> 
     <?php  echo $this->Html->css('layout'); ?> 
     <?php  echo $this->Html->css('common'); ?> 
     <?php  echo $this->Html->css('horizontalmenu'); ?> 
     <?php  echo $this->Html->css('common1'); ?> 
     <?php  echo $this->Html->css('nav'); ?> 
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
		   </div>
			<div class="clear"></div>
		</div>
	
</body>

</html>
