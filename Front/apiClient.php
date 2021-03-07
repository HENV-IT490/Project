#!/usr/bin/php
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

//$request = $_POST['ingredient'];
$request= "chicken";
$response = $client->send_request($request);
$responseArray=json_decode($response);

echo "client received response: ".PHP_EOL;
echo "\n\n";

print_r($response);
print_r($responseArray);
?>
