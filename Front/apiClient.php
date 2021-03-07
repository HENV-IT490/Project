#!/usr/bin/php
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

$request = $_POST['ingredient'];
$response = $client->send_request($request);

$responseArray=json_decode($response);
echo "client received response: ".PHP_EOL;
print_r($responseArray);
echo "\n\n";

echo $responseArray;
?>
