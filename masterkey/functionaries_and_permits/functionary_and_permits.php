<?php
include '../../includes/db_connect.php';
session_start();

$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$run=$_POST["run"];
$_SESSION["run"]=$run;

$conFuncionario="SELECT * FROM functionary WHERE run='$run'";
$exe=pg_query($db,$conFuncionario);
$resultado=pg_fetch_assoc($exe);

$conPermisos="SELECT * FROM permits_f WHERE run='$run'";
$exe2=pg_query($db,$conPermisos);

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
  <h2><?php echo $resultado["name"];?></h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <b>Permisos Actuales:</b> <br>
      <?php
      while ($resultadoP=pg_fetch_assoc($exe2)){
            echo ''.$resultadoP["name"].'<br>';
      }
      ?>
      <br>
      <p><b>Asignar permisos</b></p>
      <form name="give" action="give_permits.php" method="POST" >
      						Carrera:
      <select id="xd" name="permits_c" required>
      						              <option value="" selected>Seleccione una carrera</option>
      						              <?php
      													$sql2="SELECT * FROM carrer WHERE active!=false AND campus='$campus' ORDER BY name";
      													$result2=pg_query($db,$sql2);
      						          while ($mostrar=pg_fetch_assoc($result2)){
      						            echo '<option name="cod_carrer" value="'.$mostrar['cod_carrer'].'">'.$mostrar['name'].'</option>';
      						          }
      						        ?>
      						            </select>
                              <input type="submit" value="Asignar" />
                            </form>
                              <br>
                              <form name="give" action="give_permits.php" method="POST">
                                Programa:
                              <select id="xd" name="permits_c" required>
                              						              <option value="" selected>Seleccione un programa</option>
                              						              <?php
                              													$sql3="SELECT * from program WHERE active!=false AND type='a' AND campus='$campus' ORDER BY name";
                              													$result3=pg_query($db,$sql3);
                              													while ($mostrar=pg_fetch_assoc($result3)){
                              														echo '<option name="cod_program" value="'.$mostrar['cod_program'].'">'.$mostrar['name'].'</option>';
                              													}
                              						        ?>
                              						            </select>
<input type="submit" value="Asignar" />
      </form>
      <br>
      <p><b>Revocar Permisos</b></p>
      <form action="revoke_permits.php" method="POST">
        Carrera:
        <select name="cod" required>
          <option value="" selected>Seleccione una carrera</option>
          <?php
          $carrer_con="SELECT * FROM permits_f WHERE permisson_state!=false AND run='$run' AND permisson_type='c'";
          $result4=pg_query($db,$carrer_con);
          while($mostrar=pg_fetch_assoc($result4)){
            echo '<option name="code" value="'.$mostrar['code'].'">'.$mostrar['name'].'</option>';
          }
          ?>
        </select>
        <input type="submit" value="Revocar" />
      </form>
      <form action="revoke_permits.php" method="POST">
        Programa:
        <select name="cod" required>
          <option value="" selected>Seleccione un programa</option>
          <?php
          $carrer_con="SELECT * FROM permits_f WHERE permisson_state!=false AND run='$run' AND permisson_type='p'";
          $result4=pg_query($db,$carrer_con);
          while($mostrar=pg_fetch_assoc($result4)){
            echo '<option name="code" value="'.$mostrar['code'].'">'.$mostrar['name'].'</option>';
          }
          ?>
        </select>
        <input type="submit" value="Revocar" />
      </form>
    </div>
  </div>
</div>


 </body>
 </html>
