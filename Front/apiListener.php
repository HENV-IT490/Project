#!/usr/bin/php
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');

function getRecipe($recipeID)
{
  //exec("python3 getRecipe.py " .$recipeID,$recipe);
  $recipe=file_get_contents("https://api.spoonacular.com/recipes/$recipeID/information?apiKey=e0dfc176edf3449794fdc1aa311bc990&includeNutrition=false",false);
  file_put_contents('/home/nic/test.json',$recipe);
  return $recipe;
}
function getAlt($ingredient){
  $alternative=popen("python3 testing.py " .$ingredient,$alternative);
  echo"returned alternative";
  return $alternative;
}

function requestProcessor($request)
{ 
  var_dump($request);
  switch($request['type']){
    case 'getName':
      return getRecipe($request['recipeID']);
    case 'getAlt':
      return getAlt($request['ingredient']);
  }
  echo "received request".PHP_EOL;
  
  //exec("python3 testing.py " .$request,$recipes);
  echo"\n\n\n\n\n\n\n\n\n\n";
  var_dump($recipes);


  return $recipes;
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

