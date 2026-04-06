<?php // In app/Lib/Event/LoginListener.php
 App::uses('CakeEmail', 'Network/Email');
 App::uses('CakeEventListener', 'Event');

 class LoginListener implements CakeEventListener {
    
    public function implementedEvents() {
       return ['Model.User.login' => 'loginNotification'];
    }

    public function loginNotification(CakeEvent $Event) {
    	    	$message='';
	    	$Email = new CakeEmail('amumail');
		$Email->from(array(
		'wondetask@gmail.com' => 'SMIS'
		));
		$userDetail=ClassRegistry::init('User')->find('first',
			array('conditions'=>array('User.id'=>
				$Event->data['data']['id']
			),
			'contain'=>array('Staff'=>array('Title'),'Student')
		));

		
			if(!empty($userDetail['Staff'])){

				 $message.="Dear ".$userDetail['Staff'][0]['first_name'].", <br /> <br /> ";
			
				  $email=$userDetail['User']['email'];

			} else if(!empty($userDetail['Student'])){
				$email=$userDetail['User']['email'];
		 			$message.="Dear ".$userDetail['Student'][0]['first_name'].", <br /> <br />";
			

			}
			if(isset($email) && !empty($email)) {
						$message.='We noticed a recent login for your account '.$userDetail['User']['username'].'<br /> <br />';

						$message.='Browser :'.$Event->data['browser'].'<br /> ';
						$message.='OS :'.$Event->data['os'].'<br /> <br /> ';
						$message.='<strong>IF THIS WAS YOU </strong> <br /> Great! There\'s nothing else you need to do. <br /> <br />';

						$message.='<strong>IF THIS WASN\'T YOU </strong> <br/> Your account may have been compromised and you should take a few steps to make sure your account is secure. To start, reset your password now.';
				}
		      	
		    	 if(!empty($message) && !empty($email)) {
					    	$Email->to($email);
						    $Email->subject('New Login to SMIS from '.$Event->data['browser'].' on '.$Event->data['os'] );
						    $Email->template('login_notification');
						    $Email->emailFormat('html');
						    $Email->viewVars(array(
							'message' => $message,
					
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
	
      return ;
      
   }
}
