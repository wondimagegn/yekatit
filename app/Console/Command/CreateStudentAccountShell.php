<?php
class CreateStudentAccountShell extends AppShell { 
  	 public $uses = array('User');
     function main() { 
       
        if ($this->args[0] == 'help') {
			$this->help();
			return true;
		}

		if(!empty($this->args[0]) && !empty($this->args[1])) {	  
			
            $status=$this->User->createStudentAccountBatch($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4]);
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
	
		$this->out("\nTo run a command, type 'cake create_student_account [programType] [department] [admissionYear] [password] [pre=0/1] '");
		
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
