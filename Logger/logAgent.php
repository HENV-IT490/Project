#!/usr/bin/php
<?php
require_once('RabbitMQ/path.inc');
require_once('RabbitMQ/get_host_info.inc');
require_once('RabbitMQ/rabbitMQLib.inc');

function sendLog($message){
	//Thrown after an exception is captured
	//$message is exception class getMessage()
	// Append  Error Message + File Locaton + Line location of error
	// Send message to log listner using rabbitMQ loglistener queue
	// Need to use different ini  file to use that queue
$client = new rabbitMQClient("loggerRabbitMQ.ini","logListener");

/*$request = array();
$request['type'] = "log";
$request['username'] = "steve";
$request['password'] = "password";
$request['message'] = $message; 
$client -> send_request($request); */
$client -> send_request($message);
echo "Log  sent \n";

}





?>
