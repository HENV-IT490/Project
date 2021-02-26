#!/usr/bin/php
<?php
require_once('RabbitMQ/path.inc');
require_once('RabbitMQ/get_host_info.inc');
require_once('RabbitMQ/rabbitMQLib.inc');
ini_set('frontRabbitMQ.ini','1');


if (isset($_POST['submit']))
{
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request = array();
	$request['type']=$_POST['submit'];
	switch($request['type']){

	case "login":
		$request['username'] = $_POST['username'];
		$request['password'] = $_POST['password'];
		$response = $client->send_request($request);
		print_r($response);
		//would return a redirect to the hello page with
		// header(function) and set their session token to logged
		return;
	case "create-account":
		$request['username'] = $_POST['username'];
		$request['password'] = $_POST['password'];
		//$request['email'] = $_POST['email'];
		//might have JS check if passwords are equal before allowing
		//to submit if we have pw confirm.
		$response= $client->send_request($request);
		//if response is true aka the account create
		//redirect to another page or have them login now
		//else, tell them account already exists or (later on we
		//have to check for valid email address)



	
	}
}

/*$request = array();
$request['type'] = "login";
$request['username'] = "mary";
$request['password'] = "steve";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);*/

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;

