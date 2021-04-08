
<?php
require_once(__DIR__.'/../RabbitMQ/path.inc');
require_once(__DIR__.'/../RabbitMQ/get_host_info.inc');
require_once(__DIR__.'/../RabbitMQ/rabbitMQLib.inc');

function sendLog($message){
	//Thrown after an exception is captured
	//$message is exception class getMessage()
	// Append  Error Message + File Locaton + Line location of error
	// Send message to log listner using rabbitMQ loglistener queue
	// Need to use different ini  file to use that queue
$client = new rabbitMQClient(__DIR__."/../Logger/loggerRabbitMQ.ini","logListener");

/*$request = array();
$request['type'] = "log";
$request['username'] = "steve";
$request['password'] = "password";
$request['message'] = $message; 
$client -> send_request($request); */
$response=$client -> publish($message);
echo "Log  sent \n";
return $response;
}





?>
