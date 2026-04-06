<?php
// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

App::import('Core', array('Router', 'Controller'));
include CONFIGS . 'routes.php';
App::import('Controller', 'Students'); 
App::import('Core', 'ConnectionManager');

class YearlevelupdaterShell extends AppShell { 

	 function main() { 
			$arg = $this->shiftArgs();

			if ($arg == 'help') {
				$this->help();
				return true;
			}
		
			$this->Students = new StudentsController();
			$this->Students->constructClasses();
			
			 
			if(empty($arg)) {
			     
			    $result = $this->Students->auto_yearlevel_update();  
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
	
		$this->out("\nTo run a command, type 'cake yearlevelupdater'");
		
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
