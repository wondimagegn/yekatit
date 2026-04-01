<?php // In app/Lib/Event/UserListener.php
 App::uses('CakeEventListener', 'Event');
 class MailerListener implements CakeEventListener {
    
    public function implementedEvents() {
       return ['Model.Mailer.created' => 'postNotification'];
    }

    public function postNotification(CakeEvent $Event) {
    
	       if(!empty($Event->data['data']['role_ids'])){
            foreach($Event->data['data']['role_ids'] as $k=> $role_id)
          		{
          		
          		   $notified = ClassRegistry::init('AutoMessage')->postMessageToGroup($role_id,
                               $Event->data['data']['subject'],
                             $Event->data['data']['content'],$Event->data['data']);
                           
          		}
    	}   
    	return ;
   }
}
