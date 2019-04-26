<?php
include '../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$code=$_SESSION["code"];
$_SESSION["code"]=$code;

$run=$_POST["run"];
$code_remove=$_POST["code_remove"];

$desactivateFunctionary=pg_query($db,"DELETE FROM permits_f WHERE run='$run' AND code='$code_remove'");
header('Location: success.php');
?>
