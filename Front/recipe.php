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
    $analyzedResult=$json['results'][$id]['analyzedInstructions'][0];

    echo "<h1>hello $recipe </h1></br>";
    echo "<h1>maybe {$analyzedResult['steps']} </h1></br>";
    echo "<h1>your mom gay {$json['results'][$id]['analyzedInstructions'][0]['steps']}";

   


    for($i=0;$i<count($analyzedResult['steps']);$i+=1){

	  //  echo" <h1> {$analyzedResult['steps'][$i]['step']}</h1>";

	for($j=0;$j<count($analyzedResult['steps'][$i]['ingredients']);$j+=1){

		echo "<p> {$analyzedResult['steps'][$i]['ingredients'][$j]['name']} </p> </br>";

    }s
    }



?>
