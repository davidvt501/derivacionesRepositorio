<?php
include '../includes/db_connect.php';
session_start();
$run=$_SESSION["run_f"];
$_SESSION["run"]=$run;
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$code=$_SESSION["code"];
$_SESSION["code"]=$code;

?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../assets/css/boxes_<?php echo $campus ?>.css">
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
		 <form action="../login.php" method="post">
			 <input type="hidden" value="<?php echo $campus;?>" name="campus">
     <input type="submit" value="Regresar"></button>
   </form>
 <a href="http://www.ucn.cl/" class="image fit"><img src="../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
</div>

	<div class="card card-1>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="modify_studentsInterface.php" method="post">
		<img src="../assets/images/students.png" alt="carrera" height="190" width="190">
		<p>Modificar estudiantes del programa</p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>

  <div class="card card-2>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="modify_functionariesInterface.php" method="post">
		<img src="../assets/images/modify_employees.png" alt="carrera" height="190" width="190">
		<p>Modificar funcionarios del programa</p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>

 </body>
 </html>
