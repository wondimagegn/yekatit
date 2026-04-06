<?php
App::uses('Component', 'Controller');
class TicketmasterComponent extends Component{
	public $sitename = SITE_NAME;
	//var $linkdomain='smis.dev';

	//how many hours to honor token
	public $hours = (TICKET_TOKEN_EXPIRATION_TIME_IN_HOURS > 0 ? TICKET_TOKEN_EXPIRATION_TIME_IN_HOURS : 0.5); //30 minutes is default if not set explicitly in smis.php

	public function __construct(ComponentCollection $collection,$settings = array()) 
	{
		parent::__construct($collection, $settings);
	}

	public function initialize(Controller $controller) 
	{
	       
	}

    public function shutdown(Controller $controller) {

	}

    // Startup - Link the component to the controller.
    function startup(Controller $controller)
    {
		$this->controller = $controller;    	
    }

	function getExpirationDate()
	{
		$date = strftime('%c');
		$date = strtotime($date);
		$date += ($this->hours * 60 * 60);
		$expired = date('Y-m-d H:i:s', $date);
		return $expired;
	}

	function createMessage($token, $user_name = '', $first_name = '')
	{
		$url = Configure::read('SMIS.url');

		$ms = '<p style="color: black;">Hi';

		if (!empty($first_name)) {
			$ms .= ' '. h(ucfirst(strtolower(trim($first_name))));
		} else {
			$ms .= ' there!';
		}

		$ms .= ', </p>';

		$ms .= '<p style="text-align: justify; color: black;">A password reset was requested for your account ' . (!empty($user_name) ? '"' . $user_name . '"' : '') . ' at ' . $this->sitename . '.</p>';
		$ms .= '<p>To confirm this request, and set a new password for your account, <a href="http://' . $url . '/users/useticket/' . $token . '">please click here.</a> <br>(This link is valid for <b>' . ($this->formatTime($minutes = ($this->hours * 60))) . '</b> from the time this reset was first requested.)</p>';
		$ms .= '<p style="text-align: justify; color: black;">If this password reset was not requested by you, no action is needed.</p>';
		$ms .= '<p style="text-align: justify; color: black;">Please do not reply to this email but use the provided link, as email replies are not monitored. <br>If you need help, please contact the site administrators.</p>';
		$ms .= '<span style="text-align: justify; color: black;">SMiS Support Team<br>Registrar Building, Office No: 207<br>Email: <a href="mailto:' . EMAIL_DEFAULT_REPLY_TO .'" target="_blank">' . EMAIL_DEFAULT_REPLY_TO . '</a></span>';

		$ms = wordwrap($ms, 75, "\n", 0);

		return $ms;

	}
 
	function purgeTickets()
	{
		$this->controller->Ticket->deleteAll(array('Ticket.expires <= ' => Date('Y-m-d h:i:s')));
	}	
 
	// clean ALL ticks for this email
	function voidTicket($hash)
	{
		$this->controller->Ticket->deleteAll(array('hash' => $hash));
	}
 
	function checkTicket($hash)
	{
		$this->purgeTickets();

		$ret = false;
		$tick = $this->controller->Ticket->findByHash($hash);

		if (empty($tick)) {
			//no more ticket			
		} else {
			$ret = $tick;
		}

		return $ret;
	}

	//BeforeRender Callback
	public function beforeRender(Controller $controller) 
	{
	    
	}

	function formatTime($minutes) {
		if ($minutes >= 60) {
			$hours = floor($minutes / 60);
			$remainingMinutes = $minutes % 60;

			$hourLabel = $hours == 1 ? 'hour' : 'hours';
			$minuteLabel = $remainingMinutes == 1 ? 'minute' : 'minutes';

			if ($remainingMinutes > 0) {
				return "{$hours} {$hourLabel} {$remainingMinutes} {$minuteLabel}";
			} else {
				return "{$hours} {$hourLabel}";
			}
		} else {
			$minuteLabel = $minutes === 1 ? 'minute' : 'minutes';
			return "{$minutes} {$minuteLabel}";
		}
	}

} ?>
