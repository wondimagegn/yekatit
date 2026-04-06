<?php

// See
// http://cakephp.19694.n2.nabble.com/Using-Components-or-whole-Controllers-in-a-cake-shell-td3864438.html


class NgconversionShell extends AppShell { 
        public $uses = array('ExamGradeChange','User');

	    function main() { 
			if ($this->args[0] == 'help') {
	    		$this->help();
	    		return true;
	    	}

	    	$privilaged_registrar = array();
			$all_users = $this->User->find('all',
				array(
					'conditions' => 
					array(
						'User.role_id' => array(4),
						'User.active' => 1,
						'User.is_admin'=>1
					),
					'contain' => array('StaffAssigne')
				)
			);
			
		    $program_ids=array();
		    $program_type_ids=array();
			foreach($all_users as $key => $user) {
				    $program_ids+=unserialize($user['StaffAssigne']['program_id']);
				    $program_type_ids+=unserialize($user['StaffAssigne']['program_type_id']);
					$privilaged_registrar[] = $user;
			}
		    debug($all_users);
		    debug($privilaged_registrar);
			
			$yearsToExclude=array();
			foreach($this->args as $k=>$v){
				$yearsToExclude[$k]=$v;
			}
			
			if(!empty($yearsToExclude) && !empty($yearsToExclude)) {
			    foreach($program_ids as $pk=>$pv){
			      foreach($program_type_ids as $ptk=>$ptv){
			     
				 /*
				  $result=$this->ExamGradeChange->autoNgAndDoConversion($privilaged_registrar,$yearsToExclude,
				  $pv,$ptv);
				  */
				   $result=$this->ExamGradeChange->autoNgAndDoConversion($privilaged_registrar,$yearsToExclude,
				  1,2);
				  $this->out(print_r($result, true));
				  }
				}
			} else {
                  
				  foreach($program_ids as $pk=>$pv){
			      foreach($program_type_ids as $ptk=>$ptv){
			      
				  $result=$this->ExamGradeChange->autoNgAndDoConversion($privilaged_registrar,array(),
				  $pv,$ptv);
				  $this->out(print_r($result, true));
				  }
				}
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
	
		$this->out("\nTo run a command, type 'cake ngconversion'");
		
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
