#!/usr/bin/php
<?php
    require_once('../RabbitMQ/path.inc');
    require_once('../RabbitMQ/get_host_info.inc');
    require_once('../RabbitMQ/rabbitMQLib.inc');
    session_start();
    $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

    echo "<html><h1>hello {$_SESSION['recipeCurrent']['title']}</h1><html>"

?>