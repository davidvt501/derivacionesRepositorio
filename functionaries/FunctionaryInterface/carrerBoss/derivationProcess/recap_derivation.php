<?php
include '../../../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

//Recibir Datos
$criteriosArray=$_SESSION["criteriosArray"];
$cod=$_SESSION["cod"];
$run_f=$_SESSION["run_f"];
$comment=$_SESSION["comment"];
$run=$_SESSION["run"];
$prog=$_SESSION['prog'];

//Consultas Nombres
$consulta_nombre_funcionario=pg_query($db,"SELECT * FROM functionary where run='$run_f'");
$nombreFun=pg_fetch_assoc($consulta_nombre_funcionario);
$consulta_nombre_estudiante=pg_query($db,"SELECT * FROM student where run='$run'");
$nombreEs=pg_fetch_assoc($consulta_nombre_estudiante);

//Redirigir datos
$_SESSION["run"]=$run;
$_SESSION["cod"]=$cod;
$_SESSION["run_f"]=$run_f;
$_SESSION["comment"]=$comment;
$_SESSION["criteriosArray"]=$criteriosArray;
$_SESSION['prog']=$prog;

$datProg=pg_query($db,"SELECT * FROM program where cod_program='$prog'");
$nomProg=pg_fetch_assoc($datProg);
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
 <input type="hidden" name="cod" value="<?php echo $cod ?>">
 <input type="hidden" value="<?php echo $run_f; ?>" name="run_f">
</form>
</div>

<div class="container">
  <h2>Resumen Derivacion:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
    <p>Jefe / Funcionario que deriva: <?php echo $nombreFun['name']; ?> </p>
    <p>Estudiante derivado: <?php echo $nombreEs['name'];?></p>
    <p> Indicadores considerados: </p>
    <?php for($i=0; $i < count($criteriosArray); $i++){
        echo " <li>$criteriosArray[$i]</li>";
    }
     ?>
     <br>
     <p> Comentario: <?php echo $comment ?> </p>
     <p> Programa: <?php echo $nomProg['name']?> </p>
      <form>
      <button type="submit" formaction="make_derivation.php" method="post">Realizar Derivacion</button>
    </form>
    </div>
  </div>
</div>


 </body>
 </html>
