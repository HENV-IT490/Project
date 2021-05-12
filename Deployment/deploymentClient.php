<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');


$client = new rabbitMQClient("../ini/deploymentRabbitMQ.ini","deploymentListener");
if(isset($_GET['type'])){
  
  $request=Array();
  $request['type']=$_GET['type'];
  
  switch($request['type']){
  case "getName":
    $request['recipeID']=$_GET['recipeID'];
    $response=$client->send_request($request);
    echo $response;
    exit();
}

?>