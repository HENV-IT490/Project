#!/usr/bin/php
<?php
require_once('../RabbitMQ/path.inc');
require_once('../RabbitMQ/get_host_info.inc');
require_once('../RabbitMQ/rabbitMQLib.inc');
ini_set('frontRabbitMQ.ini','1');



function doLogin($username,$password,$sessionToken)
{
    //Initiate connection with DB
    $db=dbConnect();
    if($db == FALSE){
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
	    return FALSE;
    }
    $record=mysqli_fetch_array($dbQuery);
    $recordPW=$record['password'];

    if (password_verify($password,$recordPW) == FALSE ){
    	echo "Username and Password combination is invalid" . PHP_EOL;
	return FALSE;
    }

    echo "Authentication success" .PHP_EOL;
    $checkSessionQ="select* from Session where username='$username'";
    $checkQuery=mysqli_query($db,$checkSessionQ) or die (mysqli_error($db));

    if(mysqli_num_rows($checkQuery) != 0){
	$deleteQ = "delete from Session where username='$username'";
	mysqli_query($db,$deleteQ) or die (mysqli_error($db));
	echo "'$deleteQ' was the statement just executed";
    }
    echo "preparing insert Q";
    $insertQ="INSERT into Session VALUES ('$username','$sessionToken')";
    $insertQuery=mysqli_query($db,$insertQ) or die (mysqli_error($db));
    echo "Insert Q worked";
    //mysqli_close($db);
    return TRUE;
}
function createAccount($username,$password){
//Initiate connection with DB
    $db=dbConnect();
    if($db == FALSE){
        return "Connection Refused";
    }
    $username=cleanseInput($username,$db);
    $password=cleanseInput($password,$db);
    echo $password . "is unhashed password";

    // check Username
    $Q="select* from Authentication where username='$username'";
    $dbQuery=mysqli_query($db,$Q) or die (mysqli_error($db));
   //checks tho see
    if (mysqli_num_rows($dbQuery) != 0) {
            echo 'Username found: aborting operation';
	    return FALSE;
	   // use false return to reload page and say user already made
    }
   // Need to Hash password now
    $hash =  password_hash($password,PASSWORD_DEFAULT);
    $insert = "INSERT into Authentication VALUES ('$username','$hash')";

    mysqli_query($db,$insert) or die (mysqli_error($db));
    
    //Return TRUE and transfer user to login page
    return TRUE;
   



}

function doValidate($username,$sessionToken){

	$db=dbConnect();
	$Q="select* from Session where username='$username' AND sessionToken='$sessionToken'";
	$dbQuery=mysqli_query($db,$Q) or die (mysqli_error($db));

	if (mysqli_num_rows($dbQuery) != 1) {

		echo 'Invalid user login, destroying session token';

		$Q="delete from Session where username='$username' AND sessionToken='$sessionToken'";

		$dbQuery=mysqli_query($db,$Q) or die (mysqli_error($db));

           	 return FALSE;
	};
	//else valid
	return TRUE;
		
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
$server = new rabbitMQServer("frontRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

