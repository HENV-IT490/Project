#!/usr/bin/php
<?php
  require_once('../RabbitMQ/path.inc');
  require_once('../RabbitMQ/get_host_info.inc');
  require_once('../RabbitMQ/rabbitMQLib.inc');
  session_start();

  echo"<script src='https://code.jquery.com/jquery-3.6.0.min.js'> </script>";
  echo "<src='http://127.0.0.1/Front/sessionValidate.js'> </src>";

  $id=$_GET['id'];
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  $json =$_SESSION['recipeCurrent'];
  $recipe=$json['results'][$id]['title'];
  $recipeImg=$json['results'][$id]['image'];
  $analyzedResult=$json['results'][$id]['analyzedInstructions'][0];
  echo "<h1>$recipe <button type='button' name='favorite' id='favorite' value=$recipe> Favorite</button> </h1>";

  echo "<img src=$recipeImg> </img></br>";
  //echo "<h1>your mom gay {$json['results'][$id]['analyzedInstructions'][0]['steps']}";




  for($i=0;$i<count($analyzedResult['steps']);$i+=1)
  {
    //  
    for($j=0;$j<count($analyzedResult['steps'][$i]['ingredients']);$j+=1)
    {
      $ingredientName=$analyzedResult['steps'][$i]['ingredients'][$j]['name'];
      echo "<ui> $ingredientName</ul> </br> ";
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

  echo" <p> {$analyzedResult['steps'][$i]['step']}</p>";

}

echo" <script>
$('#favorite').onClick(function(){
// doing this because didn't connect sessionvalidate yet
var sessionStorage=windows.sessionStorage;
sessionStorage.setItem('username','nick123');
var username=sessionStorage.getItem('username');
var favID=$('#favorite').val();
.$post('../Front/dbClient.php', { username: username, favoriteName: favID, submit: 'favorite' }, function(data){
  if(data != true) {
    alert('Removed recipe from Favorites!');
  }
  alert('Added recipe to Favorites!');

});

});

</script>";
  
?>
