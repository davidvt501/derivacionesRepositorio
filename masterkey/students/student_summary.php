<?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_SESSION["cod"];
$_SESSION["cod"]=$cod;

$run=$_POST['run'];
$_SESSION["run"]=$run;
$senStudentP="SELECT carrer_student.run as run,carrer.cod_carrer as cod_carrer,
student.name as student_name,student.academic_level,
student.income_year,student.campus,
program.cod_program,program.name as program_name,
carrer.name as carrer_name
FROM carrer_student INNER JOIN student
ON student.run=carrer_student.run
INNER JOIN carrer ON carrer_student.cod_carrer=carrer.cod_carrer
INNER JOIN program_student ON program_student.run=student.run
INNER JOIN program ON program.cod_program=program_student.cod_program
WHERE student.run='$run'";
$conStudentP=pg_query($db,$senStudentP);

$senStudentP2="SELECT carrer_student.run as run,carrer.cod_carrer as cod_carrer,
student.name as student_name,student.academic_level,
student.income_year,student.campus,
program.cod_program,program.name as program_name,
carrer.name as carrer_name
FROM carrer_student INNER JOIN student
ON student.run=carrer_student.run
INNER JOIN carrer ON carrer_student.cod_carrer=carrer.cod_carrer
INNER JOIN program_student ON program_student.run=student.run
INNER JOIN program ON program.cod_program=program_student.cod_program
WHERE student.run='$run'";
$conStudentP2=pg_query($db,$senStudentP2);


$conStudent=pg_query($db,"SELECT * FROM student WHERE run='$run'");
$Student=pg_fetch_assoc($conStudent);

$conProgram=pg_query($db,"SELECT * from program WHERE campus='$campus' AND type='e' ORDER BY name");

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
<form action="students_search.php" method="post">
 <input type="image" src="../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt="">
 <input type="hidden" value="<?php echo $cod?>" name="cod">
</form>
</div>

<div class="container">
  <h2><?php echo $Student['name']?></h2>
  <?php $_SESSION['student_name']=$Student['name'];?>
  <div class="panel panel-default">
    <div class="panel-body">
      <div>
          <p>Año de Ingreso: <?php echo $Student['income_year']?></p>
          <p>Correo: <?php echo $Student['mail']?></p>
          <p>Nivel Academico: <?php echo $Student['academic_level']?></p>
          <b>Programas a los que pertenece</B>
          <?php while($StudentP=pg_fetch_assoc($conStudentP)){
            echo '<div align="center">';
            echo '<li>';
            echo $StudentP['program_name'];
            echo '</li>';
            echo '</div>';
          } ?>
    </div>
    <br>
    <div>
      <p> Agregar alumno a programa: </p>
      <form action="action_process.php" method="post">
      <select id="soflow-color" name="cod_program" required>
        <option value="" selected>Seleccione un programa</otpion>
          <?php
            while ($program=pg_fetch_assoc($conProgram)){
              echo '<option value="'.$program['cod_program'].'">'.$program['name'].'</option>';
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
      <p> Remover alumno de programa: </P>
        <form action="action_process.php" method="post">
          <select name="cod_program" id="soflow-color" required>
            <option value="" selected>Seleccione algun programa</P>
            <?php while($StudentP2=pg_fetch_assoc($conStudentP2)){
              echo '<option name="cod_program"value="'.$StudentP2['cod_program'].'">'.$StudentP2['program_name'].'</option>';
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
