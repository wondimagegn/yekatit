<?php
App::uses('AppModel', 'Model');
/**
 * TelebirrRequest Model
 * TelebirrRequest.php
 */	
class TelebirrRequest extends AppModel {
   var $name = 'TelebirrRequest';
   
   public function requestSend($invoiceNumber,$oneTimeInvoiceNumber){
	$check=$this->find('first',
		array('conditions'=>array('TelebirrRequest.invoice_number'=>$invoiceNumber),
		'recursive'=>-1));
	if(isset($check) && !empty($check)){
		$this->id=$check['TelebirrRequest']['id'];
		$this->saveField('request_number',$oneTimeInvoiceNumber);
	} else {
		$data['TelebirrRequest']['invoice_number']=$invoiceNumber;
		$data['TelebirrRequest']['request_number']=$oneTimeInvoiceNumber;
		$this->save($data);
	}	
    }

	public function getInvoiceForSuccessfullRequest($oneTimeInvoiceNumber)
	{
		$check = $this->find(
			'first',
			array(
				'conditions' => array('TelebirrRequest.request_number' => $oneTimeInvoiceNumber),
				'recursive' => -1
			)
		);
		return $check['TelebirrRequest']['invoice_number'];
	}
}
?>
