<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_POST['cod'];
$_SESSION["cod"]=$cod;

$carrer_pg=pg_query($db,"SELECT * from carrer WHERE cod_carrer='$cod'");
$carrerData=pg_fetch_assoc($carrer_pg);

$student_pg="SELECT student.name,student.run,carrer_student.cod_carrer as cod_carrer FROM
student INNER JOIN carrer_student ON carrer_student.run=student.run
WHERE cod_carrer='$cod'";
$searchStudents=pg_query($db,$student_pg);

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
  <h2>Estudiantes de <?php echo  ucwords(strtolower($carrerData['name']));?>:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <?php echo '<img src="../../assets/images/'.$cod.'.png" alt="Alt" height="140" width="140">';?>
      <br>
      <b> Modificar estado de alumnos </b>
      <p> Buscar alumno por RUN: </p>
      <form onsubmit="return false">
        <input type="text" id="buscar"><input type="submit" value="Buscar" onclick="buscarSelect()">
      </form>
      <br>
        <p>
          <form method="post" action="student_summary.php">
            <br>
            <p> Buscar alumno manualmente: </p>
          <select id="soflow-color" name="run" required>
            <option value="" selected>Seleccione al Estudiante:</option>
                    <?php
                while ($mostrar=pg_fetch_assoc($searchStudents)){
                  echo '<option name="run" value="'.$mostrar['run'].'">'.$mostrar['name'].'</option>';
                }
              ?>
                  </select>
                  <br>
                  <button type="submit">Enviar</button>
                </form>
              </p>
              <b> Lista de Alumnos pertenecientes a algun programa </b>
              <p>
                <?php
                $senStudents="SELECT carrer_student.run as run,carrer.cod_carrer as cod_carrer,
                student.name as student_name,student.academic_level,
                student.income_year,student.campus,
                program.cod_program,program.name as program_name,
                carrer.name as carrer_name
                FROM carrer_student INNER JOIN student
                ON student.run=carrer_student.run
                INNER JOIN carrer ON carrer_student.cod_carrer=carrer.cod_carrer
                INNER JOIN program_student ON program_student.run=student.run
                INNER JOIN program ON program.cod_program=program_student.cod_program
                WHERE carrer.cod_carrer='$cod'";
                $conStudents=pg_query($db,$senStudents);
                while ($Students=pg_fetch_assoc($conStudents)){
                  echo ''.$Students['student_name'].' - Programa:'.$Students['program_name'].' - Run:'.$Students['run'].'';
                }
                  ?>
              </p>
    </div>
  </div>
</div>


 </body>
 </html>
