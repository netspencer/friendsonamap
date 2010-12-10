<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'twilio.php';
  class Twilioapi {
  	function newClient(){
  		$AccountSid = "ACbed6de1fc9079721688c3647d57fca61"; // replace with yours
  		$AuthToken = "dc89fa2f6da6a6bced9c211884eec734"; // replace with yours
  		$client = new TwilioRestClient($AccountSid, $AuthToken);
  		return $client;
  	}
  }

?>