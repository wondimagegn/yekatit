<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html

/*
App::import('Core', array('Router', 'Controller'));
//include CONFIGS . 'routes.php';
App::import('Controller', 'ExamResults'); 

App::import('Core', 'ConnectionManager');
*/

class RemoveLogShell extends AppShell { 
     public $uses = array('User');
	 function main() { 
		       
		        if ($this->args[0] == 'help') {
			    	$this->help();
			    	return true;
			    }
			    if(!empty($this->args[0]) && !empty($this->args[0])) {	
			     //remove log more than 2 years
			     if(is_numeric($this->args[0])){
			    	$status=$this->User->removeLog($this->args[0]);  
			     }
			      $this->out(print_r($status, true));
			    } else {
			   		 //remove log more than 1 year
			    	$status=$this->User->removeLog(); 
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
	
		$this->out("\nTo run a command, type 'cake remove_duplicate_evaluation [department] '");
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
