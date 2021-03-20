
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');
ini_set('display_errors',1);
$recipe=$_GET['recipe'];
echo"<h3>Submit your own recipe for $recipe;?!</h3>
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
$.post('http://127.0.0.1/Front/dbClient.php',{customName: customName,ingredients: ingredients, recipe: recipe,submit: submit, instructions: instructions},function(data){

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