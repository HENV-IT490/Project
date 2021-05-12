<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Starter Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/starter-template/">

    

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
  </head>
  <body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Recipe</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="Profile.html">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="search.html">Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="Sign-out.php">Sign Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</html>

<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');
ini_set('display_errors',1);
$host = $_SERVER['HTTP_HOST'];
$recipe=$_GET['recipe'];
echo"<h3>Submit your own recipe for $recipe!</h3>
<input type='hidden' id='recipe' value='$recipe'> </input>
<input type='textbox' id='customName' name='customName' placeholder='Custom Recipe Name *Required*'></input></br>
<h3>Ingredients List</h3></br>
<textarea name='ingredients' id='ingredients' rows='10' tabindex='4'cols='30' placeholder='500 characters max' maxlength='500' required='required'></textarea></br>
<h3>Recipe Instructions</h3></br>
<textarea name='instructions' id='instructions' rows='10' tabindex='4'cols='30' placeholder='500 characters max' maxlength='500' required='required'></textarea> </br>
<button id='submit'value='makeCustomRecipe'>submit</button>


<script src='https://code.jquery.com/jquery-3.6.0.min.js'> </script>
<script>
$('#submit').click(function(){
var customName=$('#customName').val();
var ingredients=$('#ingredients').val();
var instructions=$('#instructions').val();
var recipe=$('#recipe').val();
var submit=$('#submit').val();
var recipe=$('#recipe').val();
console.log(recipe);
$.post('https://$host/Front/dbClient.php',{customName: customName,ingredients: ingredients, recipe: recipe,submit: submit, instructions: instructions},function(data){

    alert(data);
});

});</script>";




$request=array();
$request['type']='getCustom';
$request['recipe']=$recipe;
$client = new rabbitMQClient("../ini/dbRabbitMQ.ini","dbListener");
$response = $client->send_request($request);
$wholeHTML="";
if($response!= false){
for($i=0;$i<count($response['recipes']);$i+=1){
$customName=$response['recipes'][$i]['customName'];
$instructions= $response['recipes'][$i]['instructions'];
$ingredients=$response['recipes'][$i]['ingredients'];
$wholeHTML=$wholeHTML."<label>Custom Recipe:$customName for $recipe </label></br> 
<textarea rows='10' readonly='true' style='font-size: 12pt' tabindex='4'cols='60'>Ingredients:$ingredients 



Instructions:$instructions</textarea></br>";
}
} else{echo "No comments yet! How bout you make one wink wink.";}

if(strlen($wholeHTML)!= 0){
    echo "</br>".$wholeHTML;
}

?>