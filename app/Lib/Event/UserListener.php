<?php // In app/Lib/Event/UserListener.php
 App::uses('CakeEmail', 'Network/Email');
 App::uses('CakeEventListener', 'Event');
 class UserListener implements CakeEventListener {
    
    public function implementedEvents() {
       return ['Model.User.created' => 'sendConfirmationEmail'];
    }

    public function sendConfirmationEmail(CakeEvent $Event) {
    	if(!empty($Event->data['email'])){
    		$Email = new CakeEmail('amumail');
		    $Email->from(array(
			'wondetask@gmail.com' => 'SMIS'
		    ));
		    $Email->to($Event->data['email']);
		    $Email->subject('Your account has been created');
		    $Email->template('new_user');
		    $Email->emailFormat('html');
		    $Email->viewVars(array(
			'data' => $Event->data['data']
		    ));
		   			try{
				    	 if($Email->send()){
				    		//success 
						 } else {
						    	if($Event->isStopped()){
						    		return false;
						    	}
						  
						  }
				    } catch(Exception $e){
				    	if($Event->isStopped()){
						    return false;
						}
					
				    }
    	}
	   return;
   }
}
