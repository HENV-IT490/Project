
<?php
$host = $_SERVER['HTTP_HOST'];
$recipeID="716268";
$apiKey="apiKey=e0dfc176edf3449794fdc1aa311bc990";
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  


//$test =file_get_contents("https://api.spoonacular.com/recipes/$recipeID/similar?$apiKey", false);
//var_dump($test);
$jsonSimilar = file_get_contents("https://gethatrecipe.com/Front/apiClient.php?type=getSimilar&recipeID=$recipeID",false,stream_context_create($arrContextOptions));
$similarArray = json_decode($jsonSimilar, true);
var_dump($similarArray);
var_dump($jsonSimilar);
echo ($recipeID);for($i = 0; $i < 3; $i+=1)
{
  echo "<br>";
  $id = $similarArray[$i]["id"];
  $type = $similarArray[$i]["imageType"];
  // echo "<p>ID: $id</p>";
  // echo "<p>Stuff: {$json_array[4]}</p>";
  $image_url = "https://spoonacular.com/recipeImages/$id-240x150.$type";
  var_dump($image_url);

  echo "<img src=$image_url alt='this is a test'><img>";
  echo "<br>";
  echo "<a href='https://gethatrecipe.com/Front/recipe.php?type=getName&recipeID=$id'>{$json_array[$i]['title']}</a>";
};
?>