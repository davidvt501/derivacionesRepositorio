<?php
/*
$host        = "host = cin.ucn.cl";
$port        = "port = 5432";
$dbname      = "dbname = derivaciones_db";
$credentials = "user = derivaciones_user password=noceejif2802oicdwkcapmcsjoicej0e2iocwocdncd";
*/

 $host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = derivaciones";
$credentials = "user = postgres password=1234";

$db = pg_connect( "$host $port $dbname $credentials"  );


error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
