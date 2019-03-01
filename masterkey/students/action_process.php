<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_SESSION["cod"];
$_SESSION["cod"]=$cod;

$run=$_SESSION["run"];


$action = $_POST['action'];
$cod_program=$_POST['cod_program'];
$_SESSION['cod_program']=$cod_program;

$student_name=$_SESSION['student_name'];

$programSentence=pg_query($db,"SELECT * FROM program where cod_program='$cod_program'");
$program=pg_fetch_assoc($programSentence);
$program_name=$program['name'];

$select_pg="SELECT * FROM program_student WHERE run='$run' and cod_program='$cod_program'";
$student_pg_sentence=pg_query($db,$select_pg);
$rows=pg_num_rows($student_pg_sentence);
echo $rows;

if($action=='a'){
  if($rows==0){
  $sentence="INSERT INTO program_student VALUES ('$run','$cod_program')";
  $addProgram=pg_query($db,$sentence);
  $_SESSION["oracion"]=''.$student_name.' ha sido agregado exitosamente a '.$program_name.'';
  header ('Location: success.php');
}else{
  header ('Location: fail.php');
}}else if($action=='r'){
  $sentence="DELETE FROM program_student WHERE run='$run' AND cod_program='$cod_program'";
  $removeProgram=pg_query($db,$sentence);
  $_SESSION["oracion"]=''.$student_name.' ha sido removido exitosamente de '.$program_name.'';
  header ('Location: success.php');
}

?>
