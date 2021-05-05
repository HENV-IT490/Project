#!/bin/php
<?php


exec('~/change.sh');
$status=getenv('STATUS');
echo $status;




?>