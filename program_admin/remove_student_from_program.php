<?php
include '../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$code=$_SESSION["code"];
$_SESSION["code"]=$code;

$run=$_POST["run"];
$code_remove=$_POST["code_remove"];

$removeStudent=pg_query($db,"DELETE FROM program_student WHERE run='$run' AND cod_program='$code_remove'");

$_SESSION["run"]=$run;
header('Location: success_student.php');
?>
