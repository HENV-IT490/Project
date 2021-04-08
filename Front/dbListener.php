#!/usr/bin/php
<?php
$footer='/home/nic/midterm/Project/RabbitMQ/rabbitMQLib.inc';
require_once(__DIR__.'/../RabbitMQ/rabbitMQLib.inc');
require_once(__DIR__.'/../RabbitMQ/path.inc');
require_once(__DIR__.'/../RabbitMQ/get_host_info.inc');

require(__DIR__.'/../Logger/logAgent.php');




function doLogin($username,$password,$sessionToken)
{
    //Initiate connection with DB
    $db=dbConnect();
    if($db == false){
   	return "Connection Refused";
   	}
    $username=cleanseInput($username,$db);
    $password=cleanseInput($password,$db);

    // check Username
    $Q="select* from Authentication where username='$username'";
    $dbQuery=mysqli_query($db,$Q) or die (mysqli_error($db));
   //checks tho see
    if (mysqli_num_rows($dbQuery) == 0) {
	    echo 'No username found';
	    return false;
    }
    $record=mysqli_fetch_array($dbQuery);
    $recordPW=$record['password'];

    if (password_verify($password,$recordPW) == false ){
    	echo "Username and Password combination is invalid" . PHP_EOL;
	return false;
    }

    echo "Authentication success" .PHP_EOL;
    $checkSessionQ="select* from Session where username='$username'";
    $checkQuery=mysqli_query($db,$checkSessionQ) or sendLog(die (mysqli_error($db)));

    if(mysqli_num_rows($checkQuery) != 0){
	$deleteQ = "delete from Session where username='$username'";
	mysqli_query($db,$deleteQ) or sendLog(die (mysqli_error($db)));
	echo "'$deleteQ' was the statement just executed";
    }
    echo "preparing insert Q";
    $insertQ="INSERT into Session VALUES ('$username','$sessionToken')";
    $insertQuery=mysqli_query($db,$insertQ) or sendLog(die(mysqli_error($db)));
    echo "Insert Q worked";
    //mysqli_close($db);
    return true;
}
function createAccount($username,$password){
//Initiate connection with DB
    $db=dbConnect();
    if($db == false){
        return "Connection Refused";
    }
    $username=cleanseInput($username,$db);
    $password=cleanseInput($password,$db);
    echo $password . "is unhashed password";

    // check Username
    $Q="select* from Authentication where username='$username'";
    $dbQuery=mysqli_query($db,$Q) or sendLog(die (mysqli_error($db)));
   //checks tho see
    if (mysqli_num_rows($dbQuery) != 0) {
            echo 'Username found: aborting operation';
	    return false;
	   // use false return to reload page and say user already made
    }
   // Need to Hash password now
    $hash =  password_hash($password,PASSWORD_DEFAULT);
    $insert = "INSERT into Authentication VALUES ('$username','$hash')";

    mysqli_query($db,$insert) or sendLog(die (mysqli_error($db)));
    
    //Return true and transfer user to login page
    return true;
   



}

function doValidate($username,$sessionToken){

	$db=dbConnect();
	$Q="select* from Session where username='$username' AND sessionToken='$sessionToken'";
	$dbQuery=mysqli_query($db,$Q) or sendLog(die (mysqli_error($db)));

	if (mysqli_num_rows($dbQuery) != 1) {

		echo 'Invalid user login, destroying session token';

		$Q="delete from Session where username='$username' AND sessionToken='$sessionToken'";

		$dbQuery=mysqli_query($db,$Q) or sendLog(die (mysqli_error($db)));

     return false;
	};
	//else valid
	return true;
		
}

function makeFavorite($username, $recipe,$recipeID){

  $db=dbConnect();
    if($db == false){
        return "DB Connection Refused";
    }
  $username=cleanseInput($username,$db);
  $recipe=cleanseInput($recipe,$db);
  $recipeID=cleanseInput($recipeID,$db);
  $Q="select * from Favorites where username='$username' AND recipeName='$recipe'";
  $dbQuery=mysqli_query($db,$Q) or sendLog(die (mysqli_error($db)));

	if (mysqli_num_rows($dbQuery) != 1) {
    $insertQ="insert into Favorites VALUES('$username','$recipe','$recipeID')";
    mysqli_query($db,$insertQ) or sendLog(die (mysqli_error($db)));
    echo "adding $recipe to $username favorites";
    return true;  
  }
  $deleteQ="delete from Favorites where username='$username' and recipeName='$recipe'";
  mysqli_query($db,$deleteQ) or sendLog(die (mysqli_error($db)));
  echo "removing $recipe from $username favorites";
  return false;
}

function getFav($username){
  $db=dbConnect();
  if($db == false){
    echo "DB connection failed";
    return false;
  }
  $username=cleanseInput($username,$db);
  $sql=mysqli_query($db,"select recipeName,recipeID from Favorites where username='$username'") or die(mysqli_error($db));
  $recipe=array();
  $counter=0;
  while($get=mysqli_fetch_array($sql)){
    $recipe['Recipe'][$counter]['Title']=$get['recipeName'];
    $recipe['Recipe'][$counter]['recipeID']=$get['recipeID'];
    $counter+=1;
    
  }
  /*for($i=0; $i<count($recipe);$i=$i+1){
    echo"$recipe[$i]";
  }*/
  var_dump($recipe);
  return $recipe;
}

function doComment($username,$recipe,$comment){
  
  $db=dbConnect();
    if($db == false){
        return "DB Connection Refused";
    }
  $username=cleanseInput($username,$db);
  $recipe=cleanseInput($recipe,$db);
  $comment=cleanseInput($comment,$db);
  echo($comment."\n");
  echo($recipe);
  $Q="select* from Comments where username='$username' AND recipe='$recipe'";
  $checkQ=mysqli_query($db,$Q) or die(mysqli_error($db));

  if(mysqli_num_rows($checkQ)>5){
    $response="User:$username already has a comment for Recipe:$recipe";
    echo $response;
    return $response;
  }
  $commentQ="insert into Comments VALUES ('$username','$recipe','$comment')";
  if (mysqli_query($db,$commentQ)){
    echo "inserted $recipe comment for user: $username \n";
    return true;
  } else {
    sendLog(__FILE__.__LINE__.mysqli_error($db));
    $error="Duplicate comment: Could not submit.";
    echo ($error);
    return "$error";
  }
}
function getComment($recipe){
  $db=dbConnect();
    if($db == false){
        return "DB Connection Refused";
    }
  $recipe=cleanseInput($recipe,$db);
  $selectQ="select * from Comments where recipe='$recipe'";
  $selectQuery= mysqli_query($db,$selectQ) or die(mysqli_error($db));
  $i=0;
  if(mysqli_num_rows($selectQuery)==0){
    echo "There are no custom recipes available";
    return false;
  }
  while($get=mysqli_fetch_array($selectQuery)){
    $data['comments'][$i]['username']=$get['username'];
    $data['comments'][$i]['comment']=$get['comment'];
    $i+=1;
  }
  var_dump($data);
  return $data;
}

function makeCustom($recipe,$customName,$instructions,$ingredients){
  $db=dbConnect();
  if($db == false){
      return "DB Connection Refused";
  }
  $recipe=cleanseInput($recipe,$db);
  $customName=cleanseInput($customName,$db);
  $instructions=cleanseInput($instructions,$db);
  $ingredients=cleanseInput($ingredients,$db);
  $insertQ="insert into CustomRecipes VALUES('$recipe','$customName','$instructions','$ingredients')";
  if(mysqli_query($db,$insertQ)){
    $sucess="$customName is set as a custom recipe for $recipe";
    echo $sucess;
    return $sucess;
  } else {
    $error= mysqli_error($db);
    sendLog(__FILE__.":".__LINE__.":".$error.PHP_EOL);
    return "Could not add recipe: Duplicate instructions for $customName.";
  }
}
function getCustom($recipe){
  $db=dbConnect();
  if($db == false){
      return "DB Connection Refused";
  }
  $recipe=cleanseInput($recipe,$db);
  echo $recipe;
  $selectQ="select customName, instructions, ingredients from CustomRecipes where recipe='$recipe'";
  $selectQuery=mysqli_query($db,$selectQ) or die (mysqli_error($db));
  if(mysqli_num_rows($selectQuery)==0){
    $re="No custom recipe for $recipe found";
    echo $re;
    return false;
  }
  $i=0;
  while($get=mysqli_fetch_array($selectQuery)){
    $data['recipes'][$i]['customName']=$get['customName'];
    $data['recipes'][$i]['instructions']=$get['instructions'];
    $data['recipes'][$i]['ingredients']=$get['ingredients'];
    $i+=1;
  }
  echo$data['recipes'][0]['customName'];
  return $data;

}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password'],$request['sessionToken']);
    case "validate_session":
      return doValidate($request['username'],$request['sessionToken']);   
    case "create-account":
      return createAccount($request['username'],$request['password']);
    case "favorites":
      return makeFavorite($request['username'],$request['favoriteName'],$request['favoriteID']);
    case "getFav":
      return getFav($request['username']);
    case "comment":
      return doComment($request['username'],$request['recipe'],$request['comment']);
    case "getComment":
      return getComment($request['recipe']);
    case "makeCustomRecipe":
      return makeCustom($request['recipe'],$request['customName'],$request['instructions'],$request['ingredients']);
    case "getCustom":
      return getCustom($request['recipe']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

function cleanseInput($input,$db){
	
	$input=mysqli_real_escape_string($db,$input);
	$input= trim($input);
	return($input);

}

function dbConnect(){

	$db=mysqli_connect("127.0.0.1",'Admin','letsgetanA','projectdb');
         if(mysqli_connect_error() ){
		 echo "Data base could not be reached" .PHP_EOL;
		 //maybe add log function (make server a client)
	 }
	return $db;


}




$server = new rabbitMQServer(__DIR__."/../ini/dbRabbitMQ.ini","dbListener");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
