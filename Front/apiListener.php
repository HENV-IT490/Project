#!/usr/bin/php
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');
ini_set('display_errors',1);

function getRecipe($recipeID)
{
  global $apiKey;
  //exec("python3 getRecipe.py " .$recipeID,$recipe);
  $recipe=file_get_contents("https://api.spoonacular.com/recipes/$recipeID/information?$apiKey&includeNutrition=false",false);
  var_dump($recipe);
  return $recipe;
}
function getAlt($ingredient){
  global $apiKey;
  $alternative=file_get_contents("https://api.spoonacular.com/food/ingredients/substitutes?$apiKey&ingredientName=$ingredient");
  var_dump($alternative);
  $dencodeAlt=json_decode($alternative,true);
  if($dencodeAlt['status'] == "failure" ){
    echo "No alternative found";
    return "No alternative found";
  }
  echo $dencodeAlt['substitutes'][0];
  return $dencodeAlt['substitutes'][0];
}
function getSimilar($recipeID)
{
  global $apiKey;
  $similar=file_get_contents("https://api.spoonacular.com/recipes/$recipeID/similar?$apiKey");
  var_dump($similar);
  return $similar;
}
  
function getRecipeList($ingredients){
  global $apiKey;
  $ingredients=str_replace(' ', ',',$ingredients);
  $recipeList=file_get_contents("https://api.spoonacular.com/recipes/complexSearch?$apiKey&includeIngredients=$ingredients&instructionsRequired=true&addRecipeInformation=true&number=5");
  var_dump($recipeList);
  return $recipeList;
}
  

function requestProcessor($request)
{ 
  var_dump($request);
  switch($request['type']){
    case 'getName':
      return getRecipe($request['recipeID']);
    case 'getAlt':
      return getAlt($request['ingredient']);
    case 'getRecipeList':
      return getRecipeList($request['ingredients']);
    case 'getSimilarRecipe':
      return getSimilar($request['recipeID']);
  }
  echo "received request".PHP_EOL;
  
  //exec("python3 testing.py " .$request,$recipes);
}

$server = new rabbitMQServer("../ini/apiRabbitMQ.ini","apiListener");
$apiKey="apiKey=e0dfc176edf3449794fdc1aa311bc990";
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

