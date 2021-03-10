#!/usr/bin/php
<?php
    require_once('../RabbitMQ/path.inc');
    require_once('../RabbitMQ/get_host_info.inc');
    require_once('../RabbitMQ/rabbitMQLib.inc');
    session_start();
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

    //$request = $_POST['ingredient'];
    // $request= "chicken";
    // $response = $client->send_request($request);
    // $responseArray=json_decode($response);

    // echo "client received response: ".PHP_EOL;
    // echo "\n\n";

    // print_r($response);
    // print_r($responseArray);

    $string = file_get_contents("./data.json");
    $json_a = json_decode($string, true);
    function onClickHyper()
    {
        $_SESSION['recipeCurrent'] = $json_a['results'][0];
    }
    for($i =0; $i < 10; $i+=1)
    {
        echo "<html><a href='recipe.php' onClick='onClickHyper()'>{$json_a['results'][$i]['title']}</a></br><img></img><html>";
    }

    echo "<html><h1>{$json_a['results'][0]['title']}</h1><html>";
    print_r($json_a['results'][0]);

    // foreach($json_a as $k => $v)
    // {
    //     echo "<h1>{$k}</h1></br><h1>{$v}</h1>"; 
    // }

    //$name = "GeeksforGeeks"; 
    //echo "<html><h1>Hello User, </h1> <p>Welcome to {$name}</p></html>";

    // $htmlFile = file_get_html("index.html");
    // echo $htmlFile;

?>
