<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

class MissingSectionUpdateShell extends AppShell { 
	 public $uses = array('CourseRegistration');
     public function main() {
	   
		if ($this->args[0] == 'help') {
			$this->help();
			return true;
		}
		$section=$this->CourseRegistration->getRegistrationWithoutStudentSectionCreated($this->args[0]);
	   $this->out(print_r($section, true));
			
		
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
		$this->out("\nTo run a command, type 'cake missing_section_update [department_id]");
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
     public function clear() {
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
