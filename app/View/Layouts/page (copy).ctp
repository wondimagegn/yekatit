
<?php 
$login_page_background = Configure::read('Image.login_background');
$bg_index = rand(0, 9);
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<!-- META CHARS -->
	<?php echo $this->Html->charset(); ?>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>
		<?php __('SMIS '); ?>
	</title>
 <link rel="stylesheet" type="text/css" href="/css/foundation.min.css" media="screen" /> 

<link rel="stylesheet" type="text/css" href="/css/home/theme.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/home/login.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/home/style_p.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/home/blog.css" media="screen" /> 
<script src="/js/vendor/modernizr.js"></script>
</head>


<body>
    <!-- preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- End of preloader -->
	<div class="off-canvas-wrap" data-offcanvas>
		<div class="inner-wrap">
			<div class="top-bar-nest">
				<nav  class="top-bar " data-topbar role="navigation" data-options="is_hover: false">
				<ul class="title-area left">
				     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
					<li class="toggle-topbar menu-icon"><a href="#"><span></span></a>

					</li>
					
					

				</ul>
				
			    <div class="left top-bar-section menu-margin-front">
					 <div class="left  hide-banner">
                     	  <a class="logo-link-bg" href="/">
							<img style="width:100px;height: 84px;" src="/img/<?php echo Configure::read('logo');?>">
							</a>
                     </div>

                     <div class="left  hide-banner">
							<h4 ><span style="color:#582f85;">Y12hmc</span> <span style="color:#ff5b00;">|</span> <span style="color:#582f85;">Office of the College Registrar </span></h4>
							<h6 style="color:#fefefb;">Educating generations to save lives!</h6>
						
                     </div>
                     
				</div>
                
				 <section  class="top-bar-section">
                
				    
                      <ul  class="right menu menu-margin-front">
                     	<li>
							 <a    class="show-menu" href="#"> Menu </a>
							 
                     	</li>
                     	
                     	<li>
							 <a href="/pages/academic_calender">Academic Calendar</a>
                     	</li>
                     	<li>
							 <a href="/pages/official_transcript_request">Transcript Request</a>
                     	</li>
                     	<li>
							 <a href="/pages/admission">Admission</a>
                     	</li>
                     	
                     	
                     </ul>
				  </section>
				</nav>
			</div>
	  </div>
	</div>

  	<!-- right sidebar wrapper -->
    <div class="inner-wrap container">
        <div class="wrap-fluid">
          <div class="row">
          	<div class="medium-3 large-3 columns">
          	  <?php 
		echo $this->element('leftmenu/leftmenu');
			?>
          	</div>
          	<div class="medium-9 large-9 columns">
          	   <div class="row">
          	   	 <?php
            if ($this->Session->check('Message.flash')) {
                     echo $this->Session->flash();
               }
               ?>
	    <?php echo $content_for_layout; ?>
          	   </div>
          		
          	</div>
          	
          </div>
          
		</div>
   </div>
  <div id="footer">
  		<p>
           Copyright &copy; <?php echo date('Y');?>
            <?php echo Configure::read('CopyRightCompany');?>
           </p>
  </div>
<!-- main javascript library -->
    <script type='text/javascript' src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/waypoints.min.js"></script>
    <script type='text/javascript' src='/js/preloader-script.js'></script>
<!-- foundation javascript -->
    <script type='text/javascript' src="/js/foundation.min.js"></script>
    <script type='text/javascript' src="/js/foundation/foundation.dropdown.js"></script>
 <!-- main edumix javascript -->
    <script type='text/javascript' src='/js/slimscroll/jquery.slimscroll.js'></script>
   
    <script type='text/javascript' src='/js/sliding-menu.js'></script>

    <script type='text/javascript' src='/js/scriptbreaker-multiple-accordion-1.js'></script>
    <script type="text/javascript" src="/js/number/jquery.counterup.min.js"></script>
    <script type="text/javascript" src="/js/circle-progress/jquery.circliful.js"></script>
    <script type='text/javascript' src='/js/app.js'></script>

<?php   
   echo $this->Js->writeBuffer(); // Any Buffered Scripts
?>

<script>
$(document).foundation();
</script>


</body>
</html>
