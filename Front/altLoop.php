<?php

 $url="http://127.0.0.1/Front/apiClient.php?type=getAlt&ingredientName=butter";
 $jsonAlt=get_file_contents($url,false);
 echo$jsonAlt;

?>