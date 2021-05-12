<?php
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
    case 'putTar':
        return;
  }
  echo "received request".PHP_EOL;
  
  //exec("python3 testing.py " .$request,$recipes);
}
$HOME=getenv('HOME');
$server = new rabbitMQServer(__DIR__."/../ini/apiRabbitMQ.ini","apiListener");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

