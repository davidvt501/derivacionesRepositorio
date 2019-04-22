<?php
include '../../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_SESSION["cod"];
$_SESSION["cod"]=$cod;

$run=$_SESSION["run"];
$_SESSION["run"]=$run;

$action = $_POST['action'];
$cod_program=$_POST['cod_program'];
$_SESSION['cod_program']=$cod_program;

$conPermissons=pg_query($db,"SELECT * FROM permits_a WHERE run='$run'");
$rows=pg_num_rows($conPermissons);

if($action=='a'){
  if($rows==0){
  $sentence="INSERT INTO permits_a VALUES ('$run','$cod_program')";
  $addProgram=pg_query($db,$sentence);
  $_SESSION["oracion"]='Los permisos han sido asigandos de manera correcta.';
  header ('Location: success_permisson.php');
}else{
  header ('Location: fail.php');
}}else if($action=='r'){
  $sentence="DELETE FROM permits_a WHERE run='$run' AND cod_program='$cod_program'";
  $removeProgram=pg_query($db,$sentence);
  $_SESSION["oracion"]='Los permisos han sido removidos de manera correcta';
  header ('Location: success_permisson.php');
}

?>
