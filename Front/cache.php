#!/usr/bin/php
<?php
$db=mysqli_connect("127.0.0.1",'Admin','letsgetanA','projectdb');
if(mysqli_connect_error() ){
echo "Data base could not be reached" .PHP_EOL;
//maybe add log function (make server a client)
}

$json=file_get_contents("top.json");
$jsona=json_decode($json,true);
echo($jsona[0][1]);
$count=0;

for($i=900;$i<1000;$i+=1){
$id=$jsona[$i][1];
$ingredient=$jsona[$i][0];
$result=file_get_contents("https://api.spoonacular.com/food/ingredients/$id/substitutes?apiKey=e0dfc176edf3449794fdc1aa311bc990");
$resultDecode=json_decode($result,true);
var_dump($resultDecode);
$count+=1;
if($resultDecode['status'] == 'failure')
    {
    $insertQ="insert into Alternatives VALUES('$ingredient','No alternative')";
    mysqli_query($db,$insertQ);
    }

    else 
    {
    $alternative=$resultDecode['substitutes'][0];
    $insertQ="insert into Alternatives VALUES ('$ingredient','$alternative')";
    mysqli_query($db,$insertQ);

    }

}
echo "$count";


?>