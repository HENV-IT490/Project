<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');

function requestProcessor($request)
{ 
  $getEnv=file_get_contents($HOME.'/myenv.conf');
  echo $getEnv;
  if($getEnv != "STATUS='PRIMARY'"){
      echo"This is HSB, request not completed";
      return;
  }
  
  var_dump($request);
  switch($request['type']){
    case 'createDevRecord':
        // create record in DB,  if checks out, SCP package that SCP'd here
        return;
    case 'decideStatus'
        // if Status is approved, download/scp package onto production. Otherwise, revert test.
        return:
  }
  echo "received request".PHP_EOL;
  
  //exec("python3 testing.py " .$request,$recipes);
}
$HOME=getenv('HOME');
$server = new rabbitMQServer(__DIR__."/../ini/deploymentRabbitMQ.ini","apiListener");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
