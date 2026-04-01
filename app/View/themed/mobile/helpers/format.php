<?php 
class FormatHelper extends Helper {
	
	function humanize_date ($date=null) {
		return date("F d, Y h:i:s A", mktime (substr($date,11 ,2), 
		substr($date,14 ,2), 
		substr($date,17 ,2), 
		substr($date,5 ,2), 
		substr($date,8 ,2), 
		substr($date,0 ,4)));
	
	}
	
	function humanize_date_short2($date=null) {
		return date("M d, y h:i:s A", mktime (substr($date,11 ,2), 
		substr($date,14 ,2), 
		substr($date,17 ,2), 
		substr($date,5 ,2), 
		substr($date,8 ,2), 
		substr($date,0 ,4)));
	
	}
	
	function humanize_date_short($date=null) {
		return date("M j, y", mktime (substr($date,11 ,2), 
		substr($date,14 ,2), 
		substr($date,17 ,2), 
		substr($date,5 ,2), 
		substr($date,8 ,2), 
		substr($date,0 ,4)));
	
	}
	
	function humanize_date_short_extended($date=null) {
		return date("M d, Y", mktime (substr($date,11 ,2), 
		substr($date,14 ,2), 
		substr($date,17 ,2), 
		substr($date,5 ,2), 
		substr($date,8 ,2), 
		substr($date,0 ,4)));
	
	}
	
	function humanize_date_short_extended_all($date=null) {
		return date("F d, Y", mktime (substr($date,11 ,2), 
		substr($date,14 ,2), 
		substr($date,17 ,2), 
		substr($date,5 ,2), 
		substr($date,8 ,2), 
		substr($date,0 ,4)));
	
	}
	
	function humanize_hour ($time=null) {
	   /*
	    $time1=substr($time,0,2);
	    $time2=substr($time,3,2);
	    $return_time=date('h:i A',mktime($time1,$time2));
	   */
	    $return_time = strtotime($time);
	    return date("h:i A",$return_time);
		//return $return_time;
		/*$hour = substr($time,0,2);
		$ms = substr($time,2);
		$formatted_hour=null;
		if($hour >=0 && $hour<=12){
			if($hour ==0){
				$hour = 12;
				$formatted_hour = $hour.$ms.' PM';
			} else {
				$formatted_hour = $hour.$ms.' AM';
			}
		} else if($hour >=13 && $hour <=24){
			$formatted_hour = ($hour - 12).$ms.' PM';
		} 
		return $formatted_hour; */
	}
	
	
	function short_date ($date=null) {
	    $date = new DateTime($date);
	    return $date->format("M d, Y");
	}
	
}
?>
