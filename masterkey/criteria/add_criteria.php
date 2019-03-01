<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$criteria=$_POST["criteria_definition"];
$type=$_POST["type"];

$pg=pg_query($db,"INSERT INTO criteria (criteria_definition,type) VALUES ('$criteria','$type')");


header ('Location: success.php');
 ?>
