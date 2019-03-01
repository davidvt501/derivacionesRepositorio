<?php
include '../../../includes/db_connect.php';
session_start();
$run=$_SESSION["run"];
$_SESSION['run']=$run;
$pass=$_POST['pass'];
$new_pass=$_POST['new_pass'];
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$consulta_pass=pg_query($db,"SELECT * FROM functionary WHERE run='$run' and pass='$pass'");

$pass_db=pg_fetch_assoc($consulta_pass);



?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../../assets/css/funcionarios2.css">
 <link rel="stylesheet" type="text/css" href="../../../assets/css/boxes.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
 <style>
br {
display: block;
margin: 2px 0;
}
 </style>
 <style>
body {
margin: 0;
}

.header {
text-align: center;
background: #1abc9c;
color: white;
font-size: 5px;
}
</style>
<script>
function buscarSelect()
{	// creamos un variable que hace referencia al select
	var select=document.getElementById("soflow-color");
	// obtenemos el valor a buscar
	var buscar=document.getElementById("buscar").value;
	// recorremos todos los valores del select
	for(var i=1;i<select.length;i++)
	{
		if(select.options[i].value==buscar)
		{
			// seleccionamos el valor que coincide
			select.selectedIndex=i;
		}
	}
}
</script>

 </head>
 <body>


	 <div class="header">

 <a href="http://www.ucn.cl/" class="image fit"><img src="../../../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
</div>

<div class="container">
  <h2></h2>
  <div class="panel panel-default">
    <div class="panel-body">
			<?php
			if($pass==$pass_db['pass']){
				$cambio_pass=pg_query($db,"UPDATE functionary SET pass='$new_pass' WHERE run='$run'");
				echo 'Contraseña Cambiada exitosamente';
				echo '<br>';
				echo '<form>';
				echo '<button formaction="../functionaryInterface_selection.php">Regresar</button>';
				echo '</form>';
			}else{
				echo 'Contraseña erronea, intentelo nuevamente.';
				echo '<br>';
				echo '<form>';
				echo '<button formaction="../functionaryInterface_selection.php">Regresar</button>';
				echo '</form>';
			} ?>
    </div>
  </div>
</div>


 </body>
 </html>
