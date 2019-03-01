<?php
include '../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../assets/css/boxes.css">
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
 </head>
 <body>


	 <div class="header">
 <a href="http://www.ucn.cl/" class="image fit"><img src="../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
 <form action="../login.php" method="post">
   <input type="hidden" value="<?php echo $campus;?>" name="campus">
 <input type="submit" value="Regresar"></button>
 </form>
</div>


<div class="card card-1>
	<form method="post">
	</form>
	<div>
	<p>Funcionarios y Permisos</p>
	<form name="empty" action="functionaries_and_permits/mainInterface.php">
	<img src="../assets/images/employees.png" alt="carrera" height="190" width="190">
	<br> <input type="submit" value="Acceder">
	</form>
	</div>
</div>

<div class="card card-2>
	<form method="post">
	</form>
	<div>
	<p>Carreras y Programas</p>
	<form name="empty" action="carrer_programInterface.php">
	<img src="../assets/images/university.png" alt="carrera" height="190" width="190">
	<br> <input type="submit" value="Acceder">
	</form>
	</div>
</div>

<div class="card card-3>
	<form method="post">
	</form>
	<div>
	<p>Criterios y Estudiantes</p>
	<form name="empty" action="criteria_and_studentsInterface.php">
	<img src="../assets/images/reading.png" alt="carrera" height="190" width="190">
	<br> <input type="submit" value="Acceder">
	</form>
	</div>
</div>

 </body>
 </html>
