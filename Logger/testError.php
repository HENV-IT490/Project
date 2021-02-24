#!/usr/bin/php
<?php
require('logAgent.php');

try{
	throw new Exception("Some error lol");
} catch (Exception $e){
	$message = $e -> getMessage().":".__FILE__.":".__LINE__."\n";
	sendLog($message);
}






?>
