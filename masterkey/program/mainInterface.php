<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$sql_e="SELECT * FROM program WHERE active!=false AND campus='$campus' AND type='e' ORDER BY name";
$result_e=pg_query($db,$sql_e);
$sql_a="SELECT * FROM program WHERE active!=false AND campus='$campus' AND type='a' ORDER BY name";
$result_a=pg_query($db,$sql_a);
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../assets/css/boxes.css">
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

 <a href="http://www.ucn.cl/" class="image fit"><img src="../../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
 <a href="../carrer_programInterface.php" class="image fit"><img src="../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt=""></a>
</div>

<div class="container">
  <h2>Modificar Programa</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <b> Agregar Programa</b>
      <p> Ingrese un nombre y codigo para el programa </p>
        <form name="carrera_a" action="add_program.php" method="POST">
        	Nombre del Programa
          <input type="text" name="name" maxlength="100" required>
          Codigo del Programa
          <input type="number" name="cod" required>
          <br>
          <br>
          Tipo de Programa:
          <select id="soflow-color" name="type" required>
            <option value="" selected>Seleccione un Tipo:</option>
            <option value="e">Programa Estudiantil</option>
            <option value="a">Programa de Apoyo</option>
          </select>
          <br>
        	<input type="submit" value="Agregar">
        </form>
        <br>
      <b>Eliminar Programa de Apoyo</b>
  <p>
    <form method="post" action="remove_program.php">
    <select id="soflow-color" name="cod_p" required>
      <option value="" selected>Seleccione una Programa:</option>
              <?php
          while ($mostrar=pg_fetch_assoc($result_a)){
            echo '<option name="run" value="'.$mostrar['cod_program'].'">'.$mostrar['name'].'</option>';
          }
        ?>
            </select>
            <br>
            <button type="submit">Eliminar</button>
          </form>
  </p>
</form>
<br>
<b>Eliminar Programa Estudiantil</b>
<p>
<form method="post" action="remove_program.php">
<select id="soflow-color" name="cod_p" required>
<option value="" selected>Seleccione una Programa:</option>
      <?php
  while ($mostrar=pg_fetch_assoc($result_e)){
    echo '<option name="run" value="'.$mostrar['cod_program'].'">'.$mostrar['name'].'</option>';
  }
?>
    </select>
    <br>
    <button type="submit">Eliminar</button>
  </form>
</p>
</form>
    </div>
  </div>
</div>


 </body>
 </html>
