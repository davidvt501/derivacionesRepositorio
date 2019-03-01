  <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>select</title>
<meta name="description" content="If we want to fetch all rows from the actor table the following PostgreSQL SELECT statement can be used.">
</head>
<body>
<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$run=$_SESSION["run"];
$_SESSION["run"]=$run;
$_SESSION["campus"]=$campus;


$permits=$_POST['permits_c'];

$sql="SELECT * FROM functionary where run='$run'";
$result = pg_query($db,$sql);
$rows = pg_num_rows($result);

if($rows>0){
	$result2 = pg_query($db,"SELECT * FROM program where cod_program='$permits'");
	$rows2 = pg_num_rows($result2);
	if ($rows2>0){
		$v_p=pg_query($db,"SELECT * FROM permits_f where run='$run' AND code='$permits'");
		$rows_p=pg_num_rows($v_p);
		if ($rows_p>0){
			header('Location: exsistingPermit.php');
		}else{
			$mostrar=pg_fetch_assoc($result2);
			$name=$mostrar['name'];
			$type='p';
			$r2=pg_query($db,"INSERT INTO permits_f VALUES ('$run','$_POST[permits_c]','$name','$type',true)");
			header('Location: success.php');

		}
	}else{
		$result3 = pg_query($db,"SELECT * from carrer where cod_carrer='$permits'");
		$rows3=pg_num_rows($result3);
		if ($rows3>0){
			$v_c=pg_query($db,"SELECT * FROM permits_f where run='$run' AND code='$permits'");
			$rows_c=pg_num_rows($v_c);
			if($rows_c>0){
				header('Location: exsistingPermit.php');
			}else{
			$mostrar2=pg_fetch_assoc($result3);
			$name=$mostrar2['name'];
			$type='c';
			$r3=pg_query($db,"INSERT INTO permits_f VALUES ('$run','$_POST[permits_c]','$name','$type',true)");
			header('Location: success.php');

		}
		}else{
			echo 'No se encontraron programas o carreras para asignar';
		}
	}
}else{
	echo 'No se encontraron funcionarios';
}







?>
</div>
</body>
</html>
