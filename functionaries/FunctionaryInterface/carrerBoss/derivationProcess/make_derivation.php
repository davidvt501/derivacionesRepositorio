<?php
include '../../../../includes/db_connect.php';
session_start();
$run_student=$_SESSION["run"];
$cod_program=$_SESSION["cod"];
$run_functionary=$_SESSION["run_f"];
$comment=$_SESSION["comment"];
$criteriosArray=$_SESSION["criteriosArray"];
$prog=$_SESSION['prog'];
date_default_timezone_set("America/Santiago");
$date = date('Y/m/d h:i:s', time());
$criteriosEncodeados=json_encode($criteriosArray);
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$derivar=pg_query($db,"INSERT INTO derivation (cod_program,run_student,run_functionary,criteria,derivation_status,datetime_derivated,comment)values('$prog','$run_student','$run_functionary','$criteriosEncodeados',0,'$date','$comment')");

$_SESSION["run_f"]=$run_functionary;
$_SESSION["cod"]=$cod_program;
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../../../assets/css/funcionarios2.css">
 <link rel="stylesheet" type="text/css" href="../../../../assets/css/boxes.css">
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

 <a href="http://www.ucn.cl/" class="image fit"><img src="../../../../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
<form action="../carrerInterface_selection.php" method="post">
 <input type="image" src="../../../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt="">
 <input type="hidden" name="cod" value="<?php echo $cod_program ?>">
 <input type="hidden" value="<?php echo $run_f; ?>" name="run_f">
</form>
</div>

<div class="container">
  <h2>Resumen Derivacion:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <p>Derivacion Realizada</p>
    </div>
  </div>
</div>


 </body>
 </html>
