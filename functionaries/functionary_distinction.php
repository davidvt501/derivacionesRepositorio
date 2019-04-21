<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>select</title>
<meta name="description" content="If we want to fetch all rows from the actor table the following PostgreSQL SELECT statement can be used.">
</head>
<body>
<h1>Permisos</h1>
<?php
include '../includes/db_connect.php';
include '../includes/function_ucn.php';
session_start();
$_SESSION["run_f"]=$_POST['run'];
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$run=$_POST['run'];
$pass=$_POST['pass'];

online_ucn($run,$pass);

$result = pg_query($db,"SELECT * FROM functionary where run='$run' AND campus='$campus'");
$rows = pg_num_rows($result);
$res2=pg_query($db,"SELECT * FROM master_key where run='$run' AND campus='$campus'");
$rows2 = pg_num_rows($res2);
$res3=pg_query($db,"SELECT * FROM program_admin where='$run' AND campus='$campus'");

if (online_ucn($run,$pass)==true){ //Comprueba si existe en el sistema de la UCN
if ($rows!=0){
	$result_e = pg_query($db,"SELECT functionality_state FROM functionary where run='$_POST[run]'");
	$mostrar_e=pg_fetch_assoc($result_e);
	if($mostrar_e['functionality_state']===t){
		echo 'active';
		header('Location: ../functionaries/FunctionaryInterface/functionaryInterface_selection.php');
	}else{
		echo 'unactive';
		header('Location: ../functionaries/unactive_functionary.php');
	}
}else if($rows2!=0){
	echo 'master-key';
	header('Location: ../masterkey/masterkeyInterface_selection.php');
}else{
	echo 'no master-key';
	header('Location: ../functionaries/inexistent_functionary.php');
}
}else{
	echo 'no funcionario en general';
	header('Location: ../functionaries/inexistent_functionary.php');
}

?>
</div>
</body>
</html>
