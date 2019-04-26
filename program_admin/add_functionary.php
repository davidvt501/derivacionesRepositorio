<?php
include '../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$code=$_SESSION["code"];
$_SESSION["code"]=$code;
$run=$_POST["run"];
$name=$_POST["name"];
$phone=$_POST["phone"];
$mail=$_POST["mail"];

$addFunctionary=pg_query($db,"INSERT INTO functionary values('$run','$name','$phone','$mail',true,'$campus')");
$addtoProgram=pg_query($db,"INSERT INTO permits_f values('$run','$code','$name','p',true)");

header('Location: success_adding.php');
 ?>
