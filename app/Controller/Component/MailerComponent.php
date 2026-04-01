<?php 
/**
 * Attempt Component Class
 * 
 * Based on http://bakery.cakephp.org/articles/aep_/2006/11/04/brute-force-protection
 * 
 * @author Thomas Heymann
 * @version	0.1
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.controllers.components
 **/
class MailerComponent extends Component {

	var $components = array(
		'RequestHandler',
		'Email'
		);
	    /**
		 * send  notification message and log to database; 
         */
  public function __construct(ComponentCollection $collection,$settings = array()) {
        parent::__construct($collection, $settings);
    }
         function sendNotification($email= null,
                 $subject = null, 
                 $body = null){               
             $sent=false;
             $auth = $this->Session->read('Auth.User');            
             $from = $auth['id'];
             $contentOfEMail=NULL;
             if($email != null){
                    $userIdAndBatchName['user_id'] = $auth['id'];
                    if($this->_sendEmail('grade_notification',
                                     $subject,
                                     $email,
                                     $userIdAndBatchName
                                     )) {
                             $contentOfEMail="To:".$email.
                                 "\n"."Subject:".$subject."\n".
                                 $this->getEmailReturnAddress().
                                 "\n"."--content--"."\n".$body."\n";
                             $message=array();
                             $message['from'] = $from;
                             $message['subject'] = $subject;
                             $message['content'] = $contentOfEMail;
                             $message['user_id'] = $user_id;
                             $message['model'] = 'ExamGrade';
                             
                             ClassRegistry::init('Mailer')->logMessage($message);

                             $sent=true;
                             $contentOfEMail=null;
                         }else{
                             $sent=false;
                         }
                return $sent;

            }
         }
         //ClassRegistry::init('Attempt');
         /**
		 * This function set return email address
		 * @ return the setted email addresses
		 */
		 function getEmailReturnAddress(){
		                 $returnAddress=null;
		                 $returnAddress="From:".$this->Email->from."\n".
		                  "Reply-To:".$this->Email->replyTo."\n".
		                  "Return-Path:".$this->Email->return."";
		                  if(isset($returnAddress)){
		                        return $returnAddress;
		                  }
		                
		 }
		 
		 /**
         *  This function setup the template ,subject and  list of users who are 
         *  receiver of this email
         * @ return true or false based on the return of send function
         */
          function sendEmail($templateName,
                $emailSubject,
                $to,
                $userIdAndBatchName,
               
                $from = 'AMU <bugs@mereb.com.et>',
                $replyToEmail = 'noreply@mereb.com.et',
                $return = 'bugs@mereb.com.et',
                $sendAs = 'both') {
               
                if(!$this->__attachNameToEmail($userIdAndBatchName['user_id'])){
                        // invalid user id don't send the email
                        return false;
                }
               
                $this->Email->to = $to;
                
                $this->Email->subject = $emailSubject;
                $this->Email->replyTo = $replyToEmail;
                $this->Email->from = $from;
                // address for bounced mail
                $this->Email->return = $return;
                // additional configuration setting  to  override send mail
                // return path
                $this->Email->additionalParams = "-r $return";
                $this->Email->template = $templateName;
                $this->Email->sendAs = $sendAs;
                return $this->Email->send();
         }
		
		 	/**
		* A function that takes user_id and set first name and last name
		* @ return false if the user_id is invalid 
		*/
        function attachNameToEmail($user_id){
            // if the User id is valid and get the name of the person
            // to attach to his/her name in message for personolization
            if($user_id){
                    $Users=$this->User->getNameOfTheUser($user_id);
                    if(!empty($Users)){
                        foreach($Users as $user=>$value){
                            $title=$value['title'];
                            $firstname=$value['firstname'];
                            $lastname=$value['lastname'];
                        }                          
                        $this->set('firstname',$firstname);
                        $this->set('lastname',$lastname);
                        $this->set('titleofperson',$title);
                        
                    }
                    return true;
                }else {
                    // invalid User id don't send the email 
                    return false;
                }
                //return true;
        }
		
		
	 
}
?>
