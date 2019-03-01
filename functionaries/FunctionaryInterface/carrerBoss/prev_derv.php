<?php
include '../../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_SESSION["cod"];
$run_f=$_SESSION["run_f"];
$_SESSION["run_f"]=$run_f;
$_SESSION["cod"]=$cod;

$consultaderivaciones="SELECT derivation.*,carrer_student.cod_carrer as cod_carrer, program.name as program_name,student.name as student_name,functionary.name as functionary_name
FROM derivation
INNER JOIN program ON derivation.cod_program=program.cod_program
INNER JOIN student ON student.run = derivation.run_student
INNER JOIN functionary ON derivation.run_functionary = functionary.run
INNER JOIN carrer_student ON derivation.run_student = carrer_student.run
WHERE carrer_student.cod_carrer='$cod'
ORDER BY derivation_status ASC, datetime_programmed";

$exe=pg_query($db,$consultaderivaciones);

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
<style>
table.blueTable {
  border: 1px solid #33A452;
  background-color: #EEEEEE;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #47433F;
  background: -moz-linear-gradient(top, #75726f 0%, #595552 66%, #47433F 100%);
  background: -webkit-linear-gradient(top, #75726f 0%, #595552 66%, #47433F 100%);
  background: linear-gradient(to bottom, #75726f 0%, #595552 66%, #47433F 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}
</style>
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
  <h2>Derivaciones Previas:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <b>Derivaciones sin Programar </b>
<div class="pendientes">
  <table class="blueTable">
    <thead align="center">
      <tr>
      <th>Nombre</th>
      <th>Funcionario que Deriva</th>
      <th>Estado</th>
      <th>Fecha de la Derivacion</th>
      <th>Fecha Programada</th>
      <th>Fecha Realizada</th>
      <th border="0"></th>
      </tr>
    </thead>
    <tbody>
      <?php while($mostrar=pg_fetch_assoc($exe)){
        $conCarrerName=pg_query($db,"SELECT * FROM carrer WHERE cod_carrer='$mostrar[cod_carrer]'");
        $mostrarName=pg_fetch_assoc($conCarrerName);
        ?>
      <tr>
        <td><?php echo $mostrar['student_name']?></td>
        <td><?php echo $mostrar['functionary_name']?></td>
        <td><?php if($mostrar['derivation_status']==0){
          echo 'Pendiente';
        }else if($mostrar['derivation_status']==1){
          echo 'Programada';
        }else if($mostrar['derivation_status']==2){
          echo 'Finalizada';
        }
        ?></td>
        <td><?php echo $mostrar['datetime_derivated']?></td>
        <td><?php if (empty($mostrar['datetime_programmed'])) {
  echo 'Pendiente';
  }else{
  echo $mostrar['datetime_programmed'];
  }

    ?></td>
    <td><?php if (empty($mostrar['datetime_done'])) {
echo 'Pendiente';
}else{
echo $mostrar['datetime_done'];
}

?></td>
        <?php echo '<input type="hidden" name="id" value="'.$mostrar['cod_derivation'].'">'; ?>
        <td><?php echo'<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal'.$mostrar['cod_derivation'].'">Revisar Detalle</button>'?></td>
      </tr>
  <!-- Modal -->
  <?php echo '<div class="modal fade" id="myModal'.$mostrar['cod_derivation'].'" role="dialog">'?>
  <?php echo '<div class="modal-dialog">'?>

    <!-- Modal content-->
    <?php echo '<div class="modal-content">';
      echo '<div class="modal-header">';
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button> ';
      echo '<h4 class="modal-title">Derivacion N°:'.$mostrar['cod_derivation'].'</h4>';
      echo '</div>';
      echo '<div class="modal-body">';
  echo'<p>Alumno derivado: '.$mostrar['student_name'].'';
      echo'<p>Funcionario que Deriva: '.$mostrar['functionary_name'].'';
  echo'<p>Funcionario que Deriva: '.$mostrarName['name'].'';
  echo'<p>Fecha de la Derivacion: '.$mostrar['datetime_derivated'].'';
  $criteria = $mostrar['criteria'];
  $criteria_lista=json_decode($criteria);
  echo "<p>Criterios considerados:</p>";
    for($i=0; $i < count($criteria_lista); $i++){
      echo "<ul>";
      echo " <li>$criteria_lista[$i]</li>";
      echo "</ul>";
  }
  echo '<p>Comentario: '.$mostrar['comment'].' <br>';
  echo '<br>';
  echo'</div>';
      echo'<div class="modal-footer">';
      echo'<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>';
      echo'</div>';
  echo'</div>';

  echo'</div>';
  echo '</div>';
  } ?>
    </tbody>
  </table>
</div>
    </div>
  </div>


 </body>
 </html>
