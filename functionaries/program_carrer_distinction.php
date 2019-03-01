<?php
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = db_derv";
$credentials = "user = postgres password=1234";
$db = pg_connect( "$host $port $dbname $credentials"  );
session_start();
$run=$_SESSION["run"];
$cod=$_POST["cod"];
$_SESSION["run_f"]=$run;
$sql="SELECT * FROM permits_f where run='$run' AND code='$cod'";

$exe=pg_query($db,$sql);

$mostrar=pg_fetch_assoc($exe);

$type=$mostrar['permisson_type'];

if($type=='c'){
  echo 'carrera';
  $_SESSION["cod"]=$_POST[cod];
  header('Location: ../functionaries/carrer_boss_interface.php');
}elseif($type=='p'){
  $_SESSION["cod"]=$_POST[cod];
  header('Location: ../functionaries/derivation_selection.php');
}
 ?>
