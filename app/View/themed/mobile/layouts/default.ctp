<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('SMIS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	
	
	    <?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
	    
	    <?php echo $this->Html->script('jquery-selectall'); ?>   
	    <?php echo $this->Html->script('generatepassword'); ?>      
	    <?php echo $this->Html->script('amharictyping'); ?>      
	    <?php echo $this->Html->script('smis'); ?>      
     
	    <?php echo $this->Html->script('jquery-populate'); ?>
	  
	    <?php echo $this->Html->script('jquery-populate'); ?>
	     
	    <?php echo $this->Html->script('jquery.dropdownPlain'); ?>
     
        <?php echo $this->Html->script('jquery-department_placement');?>
       
        <?php echo $this->Html->script('dialog/jquery.ui.core'); ?> 
        <?php echo $this->Html->script('dialog/jquery.ui.widget'); ?> 
        <?php echo $this->Html->script('dialog/jquery.ui.position'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.dialog'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.mouse'); ?>
        <?php echo $this->Html->script('dialog/jquery.ui.draggable'); ?>  
        <?php echo $this->Html->script('dialog/jquery.ui.resizable'); ?>
      
	    <?php echo $scripts_for_layout; ?>
	    <?php echo $this->Html->css('reset'); ?> 
	    <?php echo $this->Html->css('datePicker'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.all'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.dialog'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.theme'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.base'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.resizable'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.tabs'); ?> 
	    <?php echo $this->Html->css('/css/ui/jquery.ui.core'); ?> 
	    <?php echo $this->Html->css('common1'); ?> 
	    <?php echo $this->Html->css('text'); ?> 
	    <?php echo $this->Html->css('960'); ?> 
	    <?php echo $this->Html->css('layout'); ?> 
	    <?php echo $this->Html->css('nav'); ?> 
       <!--[if IE 6]>
        <?php echo $this->Html->css('ie6'); ?> 
       <![endif]-->
       <!--[if IE 7]>
        <?php echo $this->Html->css('ie'); ?> 
       <![endif]-->
</head>
<body>
       <div id="busy_indicator">
			   <?php 
			            echo $this->Html->image('busy.gif', array('class' => 'displayed')); 
			   ?>
	    </div>
		<div class="container_16">
		  
		    <div  class="grid_16 banner" style="text-align:right">		   
					    <strong>
						<?php echo date("F j, Y, g:i a");?>
						</strong>
				        |
				        <?php
				       
						echo $html->link('Change Password','/users/changePwd');	
						
						?>
					    |
					    <?php 
					    if(isset($username)){
							echo $username;					
						}
						?>
				        |
					    <?php
						echo $html->link('Log Out','/users/logout');
						
						
						?>
				
			</div>
			
			<div class="clear"></div>
		     <?php
		        if((!isset($force_password_change) || $force_password_change == 0) && 
		        (!isset($password_duration_expired) || $password_duration_expired != true)) {
		        	     echo $this->element('mainmenu/mainmenuOptimized');
		        }
				  
			 ?>
			<div  id="ajax_div" class="grid_16">
				<div class="message">
	            <?php 
	               if ($session->check('Message.auth')) {
                         echo $session->flash('auth');
                   }
                   if ($session->check('Message.flash')) {
                         echo $session->flash();
                   }

                 ?>
				</div>
			            
			   <?php echo $content_for_layout; ?>   
		   </div>
			
			    
			
			<div class="clear"></div>
			<div class="clear"></div>
		   
			<div class="grid_16" id="site_info">	  
				 <div class="footerbox">
				   <p style="margin:0px; padding:0px"><strong>&copy; <?php echo (date("Y")); ?> 
Arba Minch University<br /></strong> <!-- Designed and Developed By Mereb Technologies <a href="http://www.merebtechnologies.com" style="color:#ebad05">MerebTechnologies.com</a> --> </p> 
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
