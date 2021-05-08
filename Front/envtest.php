#!/bin/php
<?php
echo getenv('HOME');
while (true){
$getEnv=file_get_contents('/home/nickdb/myenv.conf');
echo $getEnv;
if($getEnv == "STATUS='master'"){
    echo"This is master";

}
else if ($getEnv == "STATUS='slave'"){
    echo" This is slave";
}
sleep(5);
}

?>
