<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

/*
App::import('Core', array('Router', 'Controller'));
//include CONFIGS . 'routes.php';
App::import('Controller', 'ExamResults'); 

App::import('Core', 'ConnectionManager');
*/

class StatusShell extends AppShell { 
     public $uses = array('Student');

      
     function main() { 
       
        if ($this->args[0] == 'help') {
	    	$this->help();
	    	return true;
	    }
        
	if(!empty($this->args[0]) && !empty($this->args[1]) 
&&  ($this->args[4]==0 || $this->args[4]==1  ) && ($this->args[5]==0 || $this->args[5]==1  ) && $this->args[8]=="generate")  {	
	              $status=$this->Student->regenerate_academic_status_by_batch($this->args[0],
	$this->args[1],$this->args[2],$this->args[3],$this->args[4],$this->args[5],
	$this->args[6],$this->args[7]);
	           $this->out(print_r($status, true));
		} else if(!empty($this->args[0]) && !empty($this->args[1]) 
	&&  ($this->args[4]==0 || $this->args[4]==1  ) && ($this->args[5]==0 || $this->args[5]==1  ) && $this->args[8]=="update") {
			
	                $status=$this->Student->update_academic_status_by_batch($this->args[0],
	$this->args[1],$this->args[2],$this->args[3],$this->args[4],$this->args[5],$this->args[6],$this->args[7]);
			$this->out(print_r($status, true));
		 }  else if($this->args[0]=="change") {
	                  $status=$this->Student->updateAcademicStatus();
			 $this->out(print_r($status, true));
		 } else if($this->args[0]=="allStatus" && !empty($this->args[1])){
		 	    $status = $this->Student->updateAllAcademicStatus($this->args[1]);
		 }
   } 
    
    
    /**
 * Shows console help
 *
 * @access public
 */
	function help() {
		$this->clear();
		$this->out("\nWelcome to CakePHP v" . Configure::version() . " Console");
		$this->out("--------------------------------------");
	
		$this->out("\nTo run a command, type 'cake status [department/college] [admissionYear] [StatusAcademicYear] [StatusSemester] [alldepartincollege=1/0] 
[pre=0/1] [program] [programType] [type='generate/update']'");
	}
	
/**
 * Removes first argument and shifts other arguments up
 *
 * @return mixed Null if there are no arguments otherwise the shifted argument
 * @access public
 */
	function shiftArgs() {
		return array_shift($this->args);
	}
	
/**
 * Clear the console
 *
 * @return void
 * @access public
 */
	function clear() {
		if (empty($this->params['noclear'])) {
			if ( DS === '/') {
				passthru('clear');
			} else {
				passthru('cls');
			}
		}
	}


} 
?>
