#!/bin/php
<?php
echo getenv('HOME');
while (true){

    $handle=fopen('/home/nickdb/myenv.conf','r');
    $status = 'undecided';
    While (($buffer = fgets($handle)) !== false){
        if (strpos($buffer,'STATUS=slave')!== false ) {
            $status = 'slave';
            echo "status == slave";
            break;
        }
        else if (strpos($buffer,'STATUS=master')!== false ){
            $status= 'master';
            echo "status == master";
            break;

        }
    }
sleep(5);
}




?>