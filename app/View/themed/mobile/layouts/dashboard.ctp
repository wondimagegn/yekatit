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
	  
      
	<?php echo $scripts_for_layout; ?>
  
	  <?php  echo $this->Html->css('960'); ?> 
      <?php  echo $this->Html->css('nav'); ?> 
      <?php  echo $this->Html->css('template'); ?> 
      <?php  echo $this->Html->css('colour'); ?> 
      <?php  echo $this->Html->css('layout'); ?> 
      <?php  echo $this->Html->css('dashboard'); ?> 
      <?php  echo $this->Html->css('/js/glow/1.7.0/widgets/widgets'); ?> 
      
        <?php  echo $this->Html->script('/js/glow/1.7.0/core/core'); ?> 
        <?php  echo $this->Html->script('/js/glow/1.7.0/widgets/widgets'); ?> 
    
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
 
        <div id="busy_indicator">
			       <img src="/img/busy.gif" alt="" class="displayed" />
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
				         echo $this->element('mainmenu/mainmenuOptimized');
				  
				?>
		   <div  id="ajax_div" class='grid_16_modified' > 
			
			
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
				   Arba Minch University<br /></strong>Designed and Developed By Mereb Technologies <a href="http://www.merebtechnologies.com" style="color:#ebad05">MerebTechnologies.com</a> </p> 
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
