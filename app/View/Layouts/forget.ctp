<?php
/* Combine & Minify CSS
$this->AssetCompress->addCss('foundation.min');
$this->AssetCompress->addCss('dripicon');
$this->AssetCompress->addCss('theme');
$this->AssetCompress->addCss('login');

$this->AssetCompress->addScript('jquery');
$this->AssetCompress->addScript('pace/pace');
$this->AssetCompress->addScript('vendor/modernizr');*/
?>
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
		<?php __('SIS Sign In'); ?>
	</title>
 <link rel="stylesheet" type="text/css" href="/css/foundation.min.css" media="screen" /> 
<?php

if(Configure::read('debug') || true) {
?>
<link rel="stylesheet" type="text/css" href="/css/dripicon.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/typicons.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/font-awesome.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/pace-theme-flash.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/theme.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/login.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/style.css" media="screen" /> 
<link rel="stylesheet" type="text/css" href="/css/pace-theme-flash.css" media="screen" /> 
<link rel="stylesheet" href="/css/slicknav.css" />

<?php 
} else { 
  echo $this->AssetCompress->css('login.css', array('full' => true));
} 
?>
<script src="/js/vendor/modernizr.js"></script>
</head>


<body class="fullbackground">
    <!-- preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- End of preloader -->
     <!-- right sidebar wrapper -->
    <div class="inner-wrap">
        <div class="wrap-fluid">
            <?php 
                      			     
	  if ($this->Session->flash('Message.auth')) {
		        echo $this->Session->flash('auth');
          }
	 if ($this->Session->check('Message.flash')) {
                                 echo $this->Session->flash();
           }
	
	?>
	    <?php echo $content_for_layout; ?>
	</div>
    </div>


<?php 
if(Configure::read('debug') || true){
?>
<script src="/js/jquery.js"></script>
<script src="/js/waypoints.min.js"></script>
<script src="/js/preloader-script.js"></script>
<script src="/js/pace/pace.js"></script>
<?php 
} else {
echo $this->AssetCompress->script('login.js', array('full' => true));
} 
?>

<?php   
   echo $this->Js->writeBuffer(); // Any Buffered Scripts
?>

</body>
</html>
