<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

App::import('Core', array('Router', 'Controller'));
include CONFIGS . 'routes.php';
App::import('Controller', 'ExamResults'); 
App::import('Core', 'ConnectionManager');

class StatusShell extends Shell { 
  

    function main() { 
        $arg = $this->shiftArgs();

		if ($arg == 'help') {
			$this->help();
			return true;
		}
		
        $this->ExamResults = new ExamResultsController();
        $this->ExamResults->constructClasses();
         
        if(isset($arg) && !empty($arg)) {
             $this->out("\nSection-" .$arg. "\n");    
             $result = $this->ExamResults->_generate_student_academic_status($arg);
         } else {
            $result = $this->ExamResults->_generate_student_academic_status(null);    
         }
       
        $this->out($result);  
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
	
		$this->out("\nTo run a command, type 'cake status [section_id]'");
		
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
