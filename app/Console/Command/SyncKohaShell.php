<?php


class SyncKohaShell extends AppShell { 
	 public $uses = array('Student','Staff');
	 function main() { 
		
		if ($this->args[0] == 'help') {
			$this->help();
			return true;
		}
		
		 if($this->args[0]=="staff") {
	         //$status=$this->Staff->synckoha(0);
			 $this->out(print_r($status, true));
		 } else if($this->args[0]=="student"){
		 	 $status=$this->Student->synckoha(
		 	 $this->args[1]);
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
		$this->out("---------------------------------------------------------------");
	
		$this->out("\nTo run a command, type 'cake sync_koha [staff/student]'");
		
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
