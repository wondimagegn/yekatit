
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
		<?php __('Yekatit 12 Hospital Medical College Student Information System  Sign In'); ?>
	</title>
	 <meta name="description" content="A portal for teachers and students for academic transparency " />
	 <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	 
 <link rel="stylesheet" type="text/css" href="/css/foundation.min.css" media="screen" /> 

<link rel="stylesheet" type="text/css" href="/css/foundation.min.css" media="screen" /> 
<script src="/js/vendor/modernizr.js"></script>

<link href="/css/home/style.css" rel="stylesheet" />
<link href="/css/home/flaticon.css" rel="stylesheet" />
    
<link href="/css/home/login.css" rel="stylesheet" />
</head>
<body>
    <div id="intro">
        <div class="row">
            <div class="large-6 medium-6 columns">
              
                <img src="/img/logo.png" alt="logo" />
                <h3 class="color-white heading">Y12HMC | Office of the College Registrar</h3>
                <hr />
                <h5 class="color-white " style="line-height: 27px;"> This is our registrar portal for students, academic staffs and alumni to access different registrar services offered by the office of the university registrar.
                </h5>
            </div>
            <div class="large-6 medium-6 columns">
             
                   <?php
				if ($this->Session->check('Message.flash')) {
				 echo $this->Session->flash();
				
				}
				
				
				?>
                  <?php echo $content_for_layout; ?> 
            </div>
        </div>
    </div>
    <div class="auto-grid">
         <div class="featured-item-grid">
                    <div class="glyph-icon flaticon-calendar23"></div>
                    <h6 class="text-center">
                    <a href="/pages/academic_calender">Academic <br/> Calendar</a>
                    </h6>
                   
          </div>
          
                <div class="featured-item-grid">
                    <div class="glyph-icon flaticon-speech7" style="color: rgb(23, 199, 85);"></div>
                    <h6 class="text-center"><a href="/pages/announcement">Registrar <br/>Announcemnts</a></h6>
                    
        </div>
        <div class="featured-item-grid">
                    <div class="glyph-icon flaticon-laptop10" style="color: rgb(8, 161, 181);"></div>
                    <h6 class="text-center"><a href="/pages/official_request_tracking"> Official <br/> Transcript  </a></h6>
                    
        </div>
           
        <div class="featured-item-grid">
                    <div class="glyph-icon flaticon-cloud47" style="color: rgb(255, 136, 0);"></div>
                   
                   <h6 class="text-center"><a href="/pages/admission">Online <br/>Admission</a></h6>
                   
                   
         </div>
          <div class="featured-item-grid">
                    <div class="glyph-icon flaticon-cloud47" style="color: rgb(255, 136, 0);"></div>

                   <h6 class="text-center"><a href="/pages/online_admission_tracking">Online <br/>Admission Tracking</a></h6>


         </div>


	 <div class="featured-item-grid">
                    <div class="glyph-icon flaticon-user20" style="color: rgb(255, 136, 0);"></div>
                   
                   <h6 class="text-center"><a href="/alumni/member_registration">Alumni Registration</a></h6>
                   
         </div>
          
         <div class="featured-item-grid">
                 <div class="glyph-icon flaticon-cloud47" style="color: rgb(255, 136, 0);"></div>
                   
                   <h6 class="text-center"><a href="/pages/check_graduate">Forgery <br/>Check</a></h6>
                   
                   
         </div>
         
         
        
                
    </div>
   

     <div id="footer">
     	  <p style="padding:5px;">
           Copyright &copy; <?php echo date('Y');?> <?php echo Configure::read('CopyRightCompany');?>
    	</p>
    </div>
	<script>
    $(document).foundation();
</script>


</body>
</html>
