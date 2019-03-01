<?php
include '../../../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

/* Preparar fecha
$date=$_POST['date'];
//echo "fecha: $date";
$time=$_POST['time'];
//echo "tiempo: $time";

$unix_datetime = strtotime($date." ".$time);

$string_datetime=date('d/m/Y H:i:s',$unix_datetime);
//Fecha lista */

//$con=pg_query($db,"INSERT INTO derivation (cod_program,run_student,run_functionary,support) values(202,'$run','$run_f','Hola')");

if (isset($_POST["academica"]) || isset($_POST["socioEmocional"])) {
  $cod=$_SESSION["cod"];
  $run_f=$_SESSION["run_f"];
  $comment=$_POST['comment'];
  $run=$_POST['run'];
  $_SESSION["cod"]=$cod;
  $_SESSION["run_f"]=$run_f;
  $_SESSION["comment"]=$comment;
  $_SESSION["run"]=$run;

$year = date('Y', time());

$prog_e=pg_query($db,"SELECT * FROM program_student where run='$run'");
$cons=pg_fetch_assoc($prog_e);

$datosEstud=pg_query($db,"SELECT * from student where run='$run'");
$consDat=pg_fetch_assoc($datosEstud);

/* if ($cons['cod_program']==302||303||304||305){
  echo $_SESSION['prog']=201;
}else if($cons['cod_program']==301&&$consDat['income_year']==$year){
  echo $_SESSION['prog']=203;
}else if($cons['cod_program']==301&&$consDat['income_year']!=$year){
  echo $_SESSION['prog']=201;
}else if($yearC=$year-$consDat['income_year']<6){
  echo $_SESSION['prog']=202;
} */

if ($cons['cod_program']==301){ //Verifica si es PACE
  if ($consDat['income_year']==$year){
    $_SESSION['prog']=203; //Se deriva a PACE si es primer año
  }else{
    $_SESSION['prog']=201; //Se deriva a Exito Academico si no es primer Año
  }
}else if ($cons['cod_program']>=302 && $cons['cod_program']<=305){ //Verifica si pertenece a alguno de los Programas
   $_SESSION['prog']=201;
}else if($year-$consDat['income_year']<5){
  $_SESSION['prog']=202; //Se deriva al AORA
}else{
  echo 'No cumple los requisitos necesarios';
  echo '<a href="../functionaries/carrer_boss_interface.php">Regresar</a>';
  die();
}

  $criteriosArray=[];
  if (isset($_POST["academica"]) && (!isset($_POST["socioEmocional"]))){
    $criteriosArray = $_POST['academica'];
    $_SESSION["criteriosArray"]=$criteriosArray;
    header('Location: recap_derivation.php');
  }else if(isset($_POST["socioEmocional"]) && (!isset($_POST["academica"]))){
    $criteriosArray = $_POST['socioEmocional'];
    $_SESSION["criteriosArray"]=$criteriosArray;
    header('Location: recap_derivation.php');
  }else if (isset($_POST["academica"]) && isset($_POST["socioEmocional"])){
    $criteriosArray=array_merge($_POST["academica"],$_POST["socioEmocional"]);
    $_SESSION["criteriosArray"]=$criteriosArray;
    header('Location: recap_derivation.php');
  }
}else{
header('Location: noCriteria.php');
}

?>
