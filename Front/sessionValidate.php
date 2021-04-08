
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');
// session storage will have username and key , send this using ?=
$request=array();
$request['type']= 'validate_session';
$request['sessionToken'] = $_POST['token'];
$request['username'] = $_POST['username'];
$client = new rabbitMQClient("../ini/dbRabbitMQ.ini","dbListener");


$response = $client->send_request($request);

echo "$response";
exit();

echo "$response";

?>
