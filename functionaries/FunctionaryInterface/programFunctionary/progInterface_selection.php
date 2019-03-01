<?php
include '../../../includes/db_connect.php';
session_start();
$cod_program=$_POST["cod"];
$_SESSION["cod"]=$cod_program;
$run=$_SESSION["run"];
$_SESSION["run"]=$run;
 ?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../../assets/css/boxes.css">
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
		 <form action="../functionaryInterface_selection.php" method="post">
			 <input type="hidden" value="<?php echo $campus;?>" name="campus">
       <input type="hidden" value="<?php echo $cod_program ?>" name="cod">
     <input type="submit" value="Regresar"></button>
   </form>
 <a href="http://www.ucn.cl/" class="image fit"><img src="../../../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
</div>


	<div class="card card-1>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="pendingDerivations_Interface.php" method="post">
		<img src="../../../assets/images/derivation.png" alt="carrera" height="190" width="190">
		<p>Derivaciones Pendientes</p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>

	<div class="card card-2>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="programmedDerivations_Interface.php" method="post">
		<img src="../../../assets/images/derivation_schedule.png" alt="carrera" height="190" width="190">
    <p> Derivaciones Programadas </p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>

  <div class="card card-3>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="completedDerivations_Interface.php" method="post">
		<img src="../../../assets/images/derivation_completed.png" alt="carrera" height="190" width="190">
    <p> Derivaciones Realizadas </p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>
 </body>
 </html>
