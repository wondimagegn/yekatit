<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

class SectionArranageShell extends AppShell { 
	 public $uses = array('Section');
     public function main() {
	   
		if ($this->args[0] == 'help') {
			$this->help();
			return true;
		}
		
         if(!empty($this->args[0]) && !empty($this->args[1]) && !empty($this->args[2]) && !empty($this->args[3]) && !empty($this->args[4]) && !empty($this->args[5]) && !empty($this->args[6])) {
			  
			 $section=$this->Section->swampTheWholeStudentInSpecificBatch($this->args[0],$this->args[1],$this->args[2],$this->args[3],$this->args[4],$this->args[5],$this->args[6],$this->args[7]);
			
			$this->out(print_r($section, true));
			
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
		$this->out("\nTo run a command, type 'cake section_arranage 
[BathAcademicYear] [AcademicYear] [department_id] [year_level] [program_id] [program_type_id] [type] [pre]");
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
