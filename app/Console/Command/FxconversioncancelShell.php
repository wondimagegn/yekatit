<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html


class FxconversioncancelShell extends AppShell { 
        public $uses = array('Student');

	    function main() { 
			if ($this->args[0] == 'help') {
	    		$this->help();
	    		return true;
	    	}
	    	if(!empty($this->args[0]) && !empty($this->args[1]) && !empty($this->args[2]) && !empty($this->args[3]) && !empty($this->args[4]) && !empty($this->args[5])) {
				  /*
				  * 0- acaemic year, 1-semester,2-program_id,3-program_type_id,4-department_id(c~1),5-year_level_id
				  */
				  $result=$this->Student->cancelStudentFxAutomaticallyConvertedChange($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4],$this->args[5]);
				  $this->out(print_r($result, true));

			} else {
                  $result="No matching found!";
				  $this->out(print_r($result, true));
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
		$this->out("---------------------------------------------------------------");
	
		$this->out("\nTo run a command, type 'cake fxconversioncancel [AcaemicYear], [Semester-I,II,II],[ProgramId-1,2],[ProgramTypeId:1,2,3,4,5,6,7],
		[DepartmentId[1,2,3..] For College c~1,2],[YearLevel-1st,2nd,3rd,4th]'");
		
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
