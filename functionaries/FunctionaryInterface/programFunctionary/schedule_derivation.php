<?php
include '../../../includes/db_connect.php';
session_start();
date_default_timezone_set("America/Santiago");

$date=$_POST['date'];

$time=$_POST['time'];

$unix_datetime = strtotime($date." ".$time);

$datetime=date('d/m/Y H:i:s',$unix_datetime);
$cod=$_POST["cod"];
$cod_program=$_POST["cod_program"];

$schedule=pg_query($db,"UPDATE derivation SET datetime_programmed='$datetime' WHERE cod_derivation='$cod'");

$changeStatus=pg_query($db,"UPDATE derivation SET derivation_status=1 WHERE cod_derivation='$cod'");
$_SESSION["cod"]=$cod_program;
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
<form action="pendingDerivations_Interface.php" method="post">
 <input type="image" src="../../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt="">
 <input type="hidden" name="cod" value="<?php echo $cod ?>">
</form>
</div>

<div class="container">
  <h2>Derivacion Programada:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      La derivacion ha sido programa con exito.
    </div>
  </div>
</div>


 </body>
 </html>
