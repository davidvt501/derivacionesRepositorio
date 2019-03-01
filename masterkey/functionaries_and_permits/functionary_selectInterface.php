<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$sql="SELECT * FROM functionary WHERE functionality_state!=false AND campus='$campus' ORDER BY name";
$result=pg_query($db,$sql);
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
 <a href="mainInterface.php" class="image fit"><img src="../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt=""></a>
</div>

<div class="container">
  <h2>Seleccione un funcionario:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <p>Introduzca el RUT del Funcionario</p>
<form onsubmit="return false">
  <input type="text" id="buscar"><input type="submit" value="Buscar" onclick="buscarSelect()">
</form>
  <p>
    <form method="post" action="functionary_and_permits.php">
    <select id="soflow-color" name="run" required>
      <option value="" selected>Seleccione al Funcionario:</option>
              <?php
          while ($mostrar=pg_fetch_assoc($result)){
            echo '<option name="run" value="'.$mostrar['run'].'">'.$mostrar['name'].'</option>';
          }
        ?>
            </select>
            <br>
            <button type="submit">Enviar</button>
          </form>
  </p>
</form>
    </div>
  </div>
</div>


 </body>
 </html>
