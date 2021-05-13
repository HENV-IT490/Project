
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Recipe</title>

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
  session_start();


  echo"<script src='https://code.jquery.com/jquery-3.6.0.min.js'> </script>";
  $id=$_GET['id'];
  $type=$_GET['type'];
  if($type=='getName'){
    $recipeID=$_GET['recipeID'];
    echo ("$recipeID");
    $getdata = http_build_query(
      array(
        'type' => $type,
        'recipeID' => $recipeID
      )
   );
    $request=file_get_contents('https://gethatrecipe.com/Front/apiClient.php?'.$getdata,false);
    $json=json_decode($request,true);
    $recipe=$json['title'];
    $analyzedResult=$json['analyzedInstructions'][0];
    $recipeImg=$json['image'];
  }
  else{
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  $json =$_SESSION['recipeCurrent'];
  $recipe=$json['results'][$id]['title'];
  $recipeID=$json['results'][$id]['id'];
  $recipeImg=$json['results'][$id]['image'];
  $analyzedResult=$json['results'][$id]['analyzedInstructions'][0];
}
  echo "<h1 id='favoriteID' hidden='true'>$recipeID</h1>";
  echo "<h1>$recipe <button type='button' name='favorite' id='favorite' value='$recipe'> Favorite</button> </h1>";

  echo "<img src=$recipeImg> </img></br>";
  //echo "<h1>your {$json['results'][$id]['analyzedInstructions'][0]['steps']}";



  echo"<h3>Ingredient list:</h3>";
  for($i=0;$i<count($analyzedResult['steps']);$i+=1)
  {
    
    for($j=0;$j<count($analyzedResult['steps'][$i]['ingredients']);$j+=1)
    {
      $ingredientName=$analyzedResult['steps'][$i]['ingredients'][$j]['name'];
      echo "<li style='line-height:70%'>$ingredientName</li>";
     //  commenting this out as it will take alot of api calls
      $urlIngredient=str_replace(' ', '%20',$ingredientName);
      $getdata = http_build_query(
        array(
          'type' => 'getAlt',
          'ingredientName' => $urlIngredient
        )
     );
     $url="https://gethatrecipe.com/Front/apiClient.php?" ;
     $jsonAlt=file_get_contents($url.$getdata,false);
        echo "<ul style='line-height:10%'><li> $ingredientName alternative: $jsonAlt </li></ul>";
      }
    }

/*
cooking instructions/ steps do the same sort of for loop as above

THEN custom recipe next to comments table, however we will hide then until onclick
*/
echo"<h3>Instructions </h3>";
for($i=0;$i<count($analyzedResult['steps']);$i+=1){
  $k=$i+1;
  echo" <p>$k. {$analyzedResult['steps'][$i]['step']}</p>";

}

// Similar Recipe information:
$jsonSimilar = file_get_contents("https://gethatrecipe.com/Front/apiClient.php?type=getSimilar&recipeID=$recipeID", false);
$similarArray = json_decode($jsonSimilar, true);
for($i = 0; $i < 3; $i+=1)
{
  echo "<br>";
  $id = $similarArray[$i]["id"];
  $type = $similarArray[$i]["imageType"];
  // echo "<p>ID: $id</p>";
  // echo "<p>Stuff: {$json_array[4]}</p>";
  $image_url = "https://spoonacular.com/recipeImages/$id-240x150.$type";
  echo "<img src=$image_url alt='this is a test'><img>";
  echo "<br>";
  echo "<a href='https://gethatrecipe.com/Front/recipe.php?type=getName&recipeID=$id'>{$json_array[$i]['title']}</a>";
}


echo"<a href='https://gethatrecipe.com/Front/customRecipe.php?recipe=$recipe'>Click to view/submit custom recipes</a>";
echo"<div id='respond'>
<h3>Leave a Comment</h3> <p>Show comments: <input type='button' id='getComment' value='show'></input></p>

<form action='postComment id='commentform'>
    <br>
  <textarea name='Comment' id='Comment' rows='10' tabindex='4'cols='30' placeholder='500 characters max' maxlength='500' required='required'></textarea>
   </br> 
   <input type='hidden' id='recipe' name='recipe' value='$recipe'></input>
  <input name='submit' id='submit' type='button' value='submit'> </input>
     </form>
  </div>

  <div id=showComment>
  </div>
";


echo" <script> 

$('#favorite').click(function(){
// doing this because didn't connect sessionvalidate yet
var username=sessionStorage.getItem('username');
var favName=$('#favorite').val();
var favID=document.getElementById('favoriteID').textContent;
$.post('https://gethatrecipe.com/Front/dbClient.php', { username: username, favoriteID: favID, favoriteName: favName, submit: 'favorites'},function(data){

  if(data!=false){ alert('added dish to favorites');}
  else{ 
    alert('removed dish from favorites');
  }
});

});

</script>";

//adding to history
echo "<script>

var username=sessionStorage.getItem('username');

$.post('https://gethatrecipe.com/Front/dbClient.php',{ username: username, recipeID: $recipeID, recipeName: '$recipe', type: 'addHistory'}, function(data){
  console.log(username);
  alert(username);
}
);

</script>";

echo"<script>

$('#submit').click(function(){
  var username=sessionStorage.getItem('username');
  var comment=$('#Comment').val();
  var recipe= $('#recipe').val();
  console.log(username);
  console.log(recipe);
  console.log(comment);
  $.post('https://gethatrecipe.com/Front/dbClient.php', {username: username, comment: comment, submit: 'comment', recipe: recipe}, function(data){
  if(data != true){
    alert(data);
  }
  else{
  alert('added comment');
  }
  });

});
</script>";

echo"<script>
  var recipe= $('#recipe').val();
  $('#getComment').click(function(){
    $('#showComment').load('https://gethatrecipe.com/Front/loadComment.php',{recipe: recipe},function(){
      alert('loaded comments');
    });

  });

</script>";

/*session_unset();
$_SESSION=array();
session_destroy();*/
?>
