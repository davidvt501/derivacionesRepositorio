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

$program=pg_query($db,"SELECT * FROM program where cod_program='$cod_program'");
echo $program['name'];

if($action=='a'){
  $sentence="INSERT INTO program_student VALUES ('$run','$cod_program')";
  $addProgram=pg_query($db,$sentence);
  header ('Location: success.php');
}else if($action=='r'){

}

?>
