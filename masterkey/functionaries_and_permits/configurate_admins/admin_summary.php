<?php
include '../../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_SESSION["cod"];
$_SESSION["cod"]=$cod;

$run=$_POST['run'];
$_SESSION["run"]=$run;

$condataAdmin=pg_query($db,"SELECT * from program_admin WHERE run='$run'");
$dataAdmin=pg_fetch_assoc($condataAdmin);

?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../../assets/css/boxes_<?php echo $campus ?>.css">
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
<form action="../modifypermissonsInterface.php" method="post">
 <input type="image" src="../../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt="">
 <input type="hidden" value="<?php echo $cod?>" name="cod">
</form>
</div>

<div class="container">
  <h2><?php echo $dataAdmin["name"]?></h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <div>
    </div>
    <br>
    <div>
      <p> Agregar administrador a programa: </p>
      <form action="action_process.php" method="post">
      <select id="soflow-color" name="cod_program" required>
        <option value="" selected>Seleccione un programa</otpion>
          <?php
          $conProgram=pg_query($db,"SELECT * FROM program WHERE campus='$campus' AND type='a'");
          while ($program=pg_fetch_assoc($conProgram)){
            if($program['type']=='e'){
              $type=' Tipo - Estudiantil';
            }else if($program['type']=='a'){
              $type=' Tipo - Apoyo';
            }
          echo '<option name="cod" value="'.$program['cod_program'].'">'.$program['name'].'</option>';
          }
          ?>
          <input type="hidden" value="a" name="action">
      </select>
      <br>
      <button type="submit">Enviar</button>
    </form>
    </div>
    <br>
    <div>
      <p> Remover administrador de programa: </P>
        <form action="action_process.php" method="post">
          <select name="cod_program" id="soflow-color" required>
            <option value="" selected>Seleccione algun programa</P>
            <?php
            $conPermissons=pg_query($db,"SELECT program.name as program_name, program.cod_program as cod,
              program.type as type FROM
              program INNER JOIN permits_a ON program.cod_program=permits_a.cod_program
              WHERE permits_a.run='$run'");
              while ($permissons=pg_fetch_assoc($conPermissons)){

                echo '<option name="cod" value="'.$permissons['cod'].'">'.$permissons['program_name'].'</option>';
              }
            ?>
            <input type="hidden" name="action" value="r">
          </select>
          <br>
          <button type="submit">Enviar</button>
        </form>
    </div>
  </div>
</div>
</div>


 </body>
 </html>
