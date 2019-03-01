<?php
include '../../../includes/db_connect.php';
session_start();
$run=$_SESSION["run"];
$_SESSION['run']=$run;
$pass=$_POST['pass'];
$new_pass=$_POST['new_pass'];

$consulta_pass=pg_query($db,"SELECT * FROM functionary WHERE run='$run' and pass='$pass'");

$pass_db=pg_fetch_assoc($consulta_pass);

if($pass==$pass_db['pass']){
	$cambio_pass=pg_query($db,"UPDATE functionary SET pass='$new_pass' WHERE run='$run'");
	echo 'Contraseña Cambiada exitosamente';
	echo '<br>';
	echo '<a href="../functionaryInterface_selection.php">Regresar</a>';
}else{
	echo 'Contraseña erronea, intentelo nuevamente.';
	echo '<br>';
	echo '<a href="../functionaryInterface_selection.php">Regresar</a>';
}

?>
