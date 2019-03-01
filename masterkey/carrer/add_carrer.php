<?php
include '../../includes/db_connect.php';
session_start();
$name=$_POST['name'];
$cod=$_POST['cod'];
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$consulta_carrera="SELECT * FROM carrer WHERE name='$name' or cod_carrer='$cod' AND campus='$campus'";

$execute=pg_query($db,$consulta_carrera);

$rows=pg_num_rows($execute);

if ($rows>0){
	header('Location: exsistingCarrer.php');
}else{

$nueva_carrera="INSERT INTO carrer values('$cod','$name',true,'$campus')";

$exe=pg_query($db,$nueva_carrera);
header('Location: success.php');
}


 ?>
