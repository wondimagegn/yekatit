
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
		<?php __('Yekatit 12 Hospital Medical College  Sign In'); ?>
	</title>
	 <meta name="description" content="A portal for teachers and students for academic transparency " />
	 <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	 
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
            <br>
            <br>
            <?php
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

<script type="text/javascript" src="/js/inputMask/jquery.maskedinput.js"></script>
<script type="text/javascript" src="/js/date-dropdown/jquery.date-dropdowns.min.js"></script>

<script type="text/javascript" src="/js/date-dropdown/jquery.datetimepicker.js"></script>




<?php 
} else {
echo $this->AssetCompress->script('login.js', array('full' => true));
} 
?>

<?php   
   echo $this->Js->writeBuffer(); // Any Buffered Scripts
?>

<script type="text/javascript">
$(document).ready(function() {
	
       //alert(screen.width+' x '+screen.height);
	if(screen.width >= 1366 && screen.height >= 768) {
		$('body').css("background-image","url(\'/img/login-background/<?php echo $login_page_background[$bg_index]['1366_768']; ?>\')");
		//$('#upper_table').css("margin-top","300px");
	}
	else if(screen.width >= 1280 && screen.height >= 800) {
		$('body').css("background-image","url('/img/login-background/<?php echo $login_page_background[$bg_index]['1280_800']; ?>')");
		//$('#upper_table').css("margin-top","300px");
	}
	else if(screen.width >= 1280 && screen.height >= 768) {
		$('body').css("background-image","url('/img/login-background/<?php echo $login_page_background[$bg_index]['1280_768']; ?>')");
		//$('#upper_table').css("margin-top","280px");
	}
	else if(screen.width >= 1280 && screen.height >= 720) {
		$('body').css("background-image","url('/img/login-background/<?php echo $login_page_background[$bg_index]['1280_720']; ?>')");
		$('body').css("background-position","top left");
		//alert(screen.width+' x '+screen.height);
		//$('#upper_table').css("margin-top","230px");
	}
	else if(screen.width >= 1024 && screen.height >= 768) {
		$('body').css("background-image","url('/img/login-background/<?php echo $login_page_background[$bg_index]['1024_768']; ?>')");
		//$('#upper_table').css("margin-top","280px");
	}
	else if(screen.width >= 800 && screen.height >= 600) {
		$('body').css("background-image","url('/img/login-background/<?php echo $login_page_background[$bg_index]['800_600']; ?>')");
		//$('#upper_table').css("margin-top","130px");
	}
	if(($(window).height()-500) > 0)
		$('#upper_table').css("margin-top",($(window).height()-500)+"px");
	else
		$('#upper_table').css("margin-top",(screen.height-700)+"px");
});
</script>
<script type="text/javascript">
   		 //dropdown date picker
        $("#date-dropdown").dateDropdowns();
        //default date & time picker

        $('#datetimepicker').datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            disabledDates: ['1986/01/08', '1986/01/09', '1986/01/10'],
            startDate: '1986/01/05'
        });
        //only tie picker
        $('#datetimepicker1').datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 5
        });
        //disable all weekend
        $('#datetimepicker9').datetimepicker({
            onGenerate: function(ct) {
                $(this).find('.xdsoft_date.xdsoft_weekend')
                    .addClass('xdsoft_disabled');
            },
            weekends: ['01.01.2014', '02.01.2014', '03.01.2014', '04.01.2014', '05.01.2014', '06.01.2014'],
            timepicker: false
        });
        //disable spesific date
        var dateToDisable = new Date();
        dateToDisable.setDate(dateToDisable.getDate() + 2);
        $('#datetimepicker11').datetimepicker({
            beforeShowDay: function(date) {
                if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                    return [false, ""]
                }

                return [true, ""];
            }
     });
    $(document).ready(function() {


        // MASKED INPUT
        (function($) {
            "use strict";
            $("#date").mask("9999-99-99", {
                completed: function() {
                    alert("Your birthday was: " + this.val());
                }
            });
             $("#gradution").mask("9999", {
                
            });
            
            $("#phone").mask("(999) 9999-999-999");

            $("#money").mask("99.999.9999", {
                placeholder: "*"
            });
            $("#ssn").mask("99--AAA--9999", {
                placeholder: "*"
            });
        })(jQuery);

    });
</script>

</body>
</html>
