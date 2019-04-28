
<?php
include '../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$code=$_SESSION["code"];
$_SESSION["code"]=$code;

$run=$_POST["run"];
$cod_program=$_POST["cod_program"];

$conProgram=pg_query($db,"SELECT * FROM program_student WHERE run='$run' AND cod_program='$cod_program'");
$numRows=pg_num_rows($conProgram);

if($numRows==0){
  $add_to_program=pg_query($db,"INSERT INTO program_student VALUES('$run','$cod_program')");
  $_SESSION["run"]=$run;
  header('Location: success_adding_student.php');
}else{
  $_SESSION["run"]=$run;
  header('Location: already.php');
}

 ?>
