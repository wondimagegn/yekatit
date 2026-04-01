<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->script('jquery-1.6.2.min'); ?>
<?php
$login_page_background = Configure::read('Image.login_background');
$bg_index = rand(0, 0);
// debug($login_page_background);
?>
<script type="text/javascript">
$(document).ready(function() {
	
	if(screen.width >= 1366 && screen.height >= 768) {
		$('body').css("background-image",
		"url(\'/img/login-background/<?php echo $login_page_background[$bg_index]['1366_768']; ?>\')");
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
	} else {
	  $('body').css("background-image","url('/img/login-background/<?php echo $login_page_background[$bg_index]['1024_768']; ?>')");
		
	}
	
	if(($(window).height()-500) > 0) 
		$('#upper_table').css("margin-top",($(window).height()-500)+"px");
	else
		$('#upper_table').css("margin-top",(screen.height-700)+"px");
});
</script>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('SMiS'); ?>
		<?php //echo $title_for_layout; ?>
	</title>
	<?php echo $scripts_for_layout; ?>
<style>
body {
/*background-image:url('/img/login-background/library-1280-800.jpg');*/
}
.transparent, .transparent tr td {
   filter:alpha(opacity=8);
   -moz-opacity: 0.8;
   opacity: 0.8;
}
.transparent1, .transparent1 tr td {
   filter:alpha(opacity=0);
   -moz-opacity: 0;
   opacity: 0;
}
.transparent2, .transparent2 tr td {
   filter:alpha(opacity=9);
   -moz-opacity: 9;
   opacity: 9;
}


.alpha60y, .alpha60y tr td {
font-family:arial;
/* Fallback for web browsers that doesn't support RGBa */
background: rgb(255, 247, 221) transparent;
/* RGBa with 0.6 opacity */
background: rgba(255, 247, 221, 0.5);
/* For IE 5.5 - 7*/
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99f9ef9b, endColorstr=#99f9ef9b);
/* For IE 8*/
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99f9ef9b, endColorstr=#99f9ef9b)";
}

.alpha60, .alpha60 tr td {
font-family:arial;
/* Fallback for web browsers that doesn't support RGBa */
background: rgb(255, 255, 255) transparent;
/* RGBa with 0.6 opacity */
background: rgba(255, 255, 255, 0.5);
/* For IE 5.5 - 7*/
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99FFFFFF, endColorstr=#99FFFFFF);
/* For IE 8*/
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99FFFFFF, endColorstr=#99FFFFFF)";
}

.bg0, .bg0 tr{
/* Fallback for web browsers that doesn't support RGBa */
background: rgb(0, 0, 0) transparent;
/* RGBa with 0.6 opacity */
background: rgba(255, 255, 255, 0);
/* For IE 5.5 - 7*/
/*AARRGGBB*/
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF, endColorstr=#00FFFFFF);
/* For IE 8*/
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#00FFFFFF, endColorstr=#00FFFFFF)"; 
}
.container {
    position:relative;
}
.content {
    position:relative;
    color:black;
    z-index:5;
}
.background {
    position:absolute;
    top:0px;
    left:0px;
    width:100%;
    height:100%;
    background-color:white;
    z-index:1;
    /* These three lines are for transparency in all browsers. */
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
    filter: alpha(opacity=50);
    opacity:.5;
}
a:link, a:active, a:hover, a:visited {
	color:#58595b;
	text-decoration: none;
}
A:hover {
color:#58595b;
text-decoration: underline
}
</style>
</head>
<body id="login_body">
<table style="margin-right:20px; width:100%">
	<tr >
		<td colspan="2">&nbsp;</td>
		<td style="width:100px">
		<?php 
		echo $this->Html->image("ambologo.gif", array(
    "alt" => "Logo",
    'url' => array('controller' => 'users', 'action' => 'login'),
    'style'=>"width:100px; height:100px;"
));
?>
		</td>
		<td style="width:270px; color:#e8c803; font-family:serif; font-size:18px; font-weight:bold; text-align:center; padding-right:20px">
		<?php 
		
		    echo $this->Html->link(
    'STUDENT INFORMATION SYSTEM',
    array('controller' => 'users', 'action' => 'login'),
    array('style'=>'color:#e8c803; font-family:serif; font-size:18px; font-weight:bold; text-align:center; padding-right:20px;underline:none')
);
		?>
		
		</td>
	</tr>
</table>
<?php echo $content_for_layout; ?>
<?php
    echo $this->Js->writeBuffer();
?>
</body>
</html>
