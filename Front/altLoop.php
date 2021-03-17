#!/usr/bin/php
<?php


 $url="http://127.0.0.1/Front/apiClient.php?" ;
 $jsonAlt=file_get_contents($url."type=getAlt&ingredientName=yogurt",false);
 echo$jsonAlt;

?>