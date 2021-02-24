#!/usr/bin/php
<?php
require_once('RabbitMQ/path.inc');
require_once('RabbitMQ/get_host_info.inc');
require_once('RabbitMQ/rabbitMQLib.inc');
ini_set('RabbitMQ/testRabbitMQ.ini','1');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = "login";
$request['username'] = "nick";
$request['password'] = "steve";
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;

