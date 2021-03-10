#!/usr/bin/php
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');
require('../Front/random.php');
ini_set('frontRabbitMQ.ini','1');


if (isset($_POST['submit']))
{
	$client = new rabbitMQClient("frontRabbitMQ.ini","testServer");
	$request = array();
	$request['type']=$_POST['submit'];
	switch($request['type']){

	case "login":
		$sessionToken=random_strings(10);
		$request['username'] = $_POST['username'];
		$request['password'] = $_POST['password'];
		$request['sessionToken']=$sessionToken;
		$username=$request['username'];

		$response = $client->send_request($request);

		if ($response == false){
		echo "this shit false";

		}

		echo "<script>
	var sessionStorage=window.sessionStorage;
	sessionStorage.setItem('username','$username');
		sessionStorage.setItem('token', '$sessionToken');					    </script>";

		header('refresh:2; url=http://127.0.0.1/Front/test.html');
		return;

	case "create-account":
		$request['username'] = $_POST['username'];
		$request['password'] = $_POST['password'];
		//$request['email'] = $_POST['email'];
		//might have JS check if passwords are equal before allowing
		//to submit if we have pw confirm.
		$response= $client->send_request($request);
		header("refresh:0; url=http://127.0.0.1/Front/index.html");
  		//if response is true aka the account create
		//redirect to another page or have them login now
		//else, tell them account already exists or (later on we
		//have to check for valid email address)

		return;	
	
	}
}

/*$request = array();
$request['type'] = "login";
$request['username'] = "mary";
$request['password'] = "steve";
$response = $client->send_request($request);
//$response = $client->publish($request)

echo "client received response: ".PHP_EOL;
print_r($response);*/
echo "<h1>hello user,</h1>";

echo $argv[0]." END".PHP_EOL;
?>
