#!/usr/bin/php
<?php
  require_once('../RabbitMQ/path.inc');
  require_once('../RabbitMQ/get_host_info.inc');
  require_once('../RabbitMQ/rabbitMQLib.inc');
  session_start();
  $id=$_GET['id'];
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  $json =$_SESSION['recipeCurrent'];
  $recipe=$json['results'][$id]['title'];
  $recipeImg=$json['results'][$id]['image'];
  $analyzedResult=$json['results'][$id]['analyzedInstructions'][0];

  echo "<h1>$recipe </h1></br>";

  echo "<img src=$recipeImg> </img></br>";
  echo "<h1>your mom gay {$json['results'][$id]['analyzedInstructions'][0]['steps']}";




  for($i=0;$i<count($analyzedResult['steps']);$i+=1)
  {
    //  
    for($j=0;$j<count($analyzedResult['steps'][$i]['ingredients']);$j+=1)
    {
      $ingredientName=$analyzedResult['steps'][$i]['ingredients'][$j]['name'];
      echo "<p> $ingredientName </p> </br>";
      /* 
        get_file_contents url . $ingredientName  ( get request and returns json format string)
        decode json file
        then do for loop for ingredients, or ONLY 1

      */
      $url="https://api.spoonacular.com/food/ingredients/substitutes?=".$ingredientName;
      /* commented out till last thing, as this cost API points
      $jsonAlt=get_file_contents($url);
      $alternative=json_decode($jsonAlt,true);
      if(alternative!=false){
        echo "<p> $ingredientName alternative: $alternative </p> </br>";

      }*/
    }
  }

/*
cooking instructions/ steps do the same sort of for loop as above

THEN custom recipe next to comments table, however we will hide then until onclick
*/
for($i=0;$i<count($analyzedResult['steps']);$i+=1){

  echo" <h1> {$analyzedResult['steps'][$i]['step']}</h1>";

}

  
?>
