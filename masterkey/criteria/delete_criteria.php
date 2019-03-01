<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_POST['cod'];

$pg=pg_query($db,"DELETE FROM criteria WHERE cod='$cod'");


header ('Location: success_deleting.php');
 ?>
