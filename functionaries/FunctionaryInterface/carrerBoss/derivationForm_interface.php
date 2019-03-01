<?php
include '../../../includes/db_connect.php';

session_start();
$cod=$_SESSION["cod"];
$run_f=$_SESSION["run_f"];
$_SESSION["run_f"]=$run_f;
$_SESSION["cod"]=$cod;
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

//criterios academicos
$criteriaAcad=pg_query($db,"SELECT * FROM criteria WHERE type='a'");
$criteriaSocEm=pg_query($db,"SELECT * FROM criteria WHERE type='s'");

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
<form action="carrerInterface_selection.php" method="post">
 <input type="image" src="../../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt="">
 <input type="hidden" name="cod" value="<?php echo $cod ?>">
</form>
</div>

<div class="container">
  <h2>Realizar Derivacion:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <p>Introduzca el RUT del Estudiante</p>
<form onsubmit="return false">
  <input type="text" id="buscar"><input type="submit" value="Buscar" onclick="buscarSelect()">
</form>
    <form name="derivation" action="derivationProcess/analize_derivation.php" method="POST">
      Busque estudiante manualmente: <br>
      <select id="soflow-color" name="run" required>
        <option value="">Seleccione un estudiante</option>
        <?php
        $sql="SELECT student.name, student.mail, student.academic_level, carrer_student.run, carrer_student.cod_carrer FROM carrer_student INNER JOIN student ON student.run = carrer_student.run WHERE cod_carrer='$cod' ORDER BY student.name";
        $result=pg_query($db,$sql);
        while ($mostrar=pg_fetch_assoc($result)){
              echo '<option name="run" value="'.$mostrar['run'].'">'.$mostrar['name'].'</option>';
      }
  ?>
      </select><br>

      <b>Indicadores academicos: </b><br>
      <div align="left">
      <?php while($mostrarCriteriaAcad=pg_fetch_assoc($criteriaAcad)){
        echo '<input type="checkbox" name="academica[]" value="'.$mostrarCriteriaAcad['criteria_definition'].'">'.$mostrarCriteriaAcad['criteria_definition'].' <br>';
      }
  ?>
</div>
<b>Indicadores socio-emocionales: </b><br>
<div align="left">

      <?php while($mostrarCriteriaSocEm=pg_fetch_assoc($criteriaSocEm)){
        echo '<input type="checkbox" name="academica[]" value="'.$mostrarCriteriaSocEm['criteria_definition'].'">'.$mostrarCriteriaSocEm['criteria_definition'].' <br>';
      }
      ?>
    </div>
    Comentario <br>
    <textarea id="confirmationText" class="text" cols="140" rows ="5" name="comment" required placeholder="Comentarios y Observaciones con respecto al estudiante al que se desea derivar."></textarea> <br>
    <input type="submit" value="Enviar">
    </form>
    </div>
  </div>
</div>


 </body>
 </html>
