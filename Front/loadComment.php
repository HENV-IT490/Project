<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');

$request=array();
$request['type']="getComment";
$request['recipe']=$_POST['recipe'];
$client = new rabbitMQClient("../ini/dbRabbitMQ.ini","dbListener");
$response = $client->send_request($request);

$wholeHTML;
for($i=0;$i<count($response['comments']);$i+=1){

    $wholeHTML=$wholeHTML."<label>Comment from User:{$response['comments'][$i]['username']}</label> </br> 
<textarea rows='3' readonly='true' style='font-size: 12pt' tabindex='4'cols='30' >{$response['comments'][$i]['comment']}</textarea> </br>";
}
echo $wholeHTML;
exit();


?>