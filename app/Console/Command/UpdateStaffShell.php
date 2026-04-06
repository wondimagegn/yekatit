<?php

class UpdateStaffShell extends AppShell { 
  	 public $uses = array('Staff');
     function main() { 
       
        if ($this->args[0] == 'help') {
			$this->help();
			return true;
		}
  		debug($this->args);
  		if($this->args[0]=="country") {
	         $status=$this->Staff->updateCountry($this->args[1]);
			 $this->out(print_r($status, true));
		 } else if($this->args[0]=="deleteDouble"){
		 	$status=$this->Staff->deleteDoubleStaff($this->args[1]);
			$this->out(print_r($status, true));
		 } else if($this->args[0]=="updateEducationAndServiceWing"){
            $status=$this->Staff->updateEducationAndServiceWing($this->args[1]);
			$this->out(print_r($status, true));
		 } else if($this->args[0]=="updateGender") {
              $status=$this->Staff->updateGender($this->args[1]);
		 } else if($this->args[0]=="updateStaffId"){
             $status=$this->Staff->updateStaffId($this->args[1]);
			$this->out(print_r($status, true));
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
	
		$this->out("\nTo run a command, type 'cake update_staff [country/deleteDouble] [department_id]'");
		
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
