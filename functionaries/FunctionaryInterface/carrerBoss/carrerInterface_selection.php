<?php
include '../../../includes/db_connect.php';
session_start();
$cod=$_POST["cod"];
$run_f=$_SESSION["run_f"];
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$_SESSION["run_f"]=$run_f;
$_SESSION["cod"]=$cod;
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../../assets/css/boxes_<?php echo $campus ?>.css">
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
     <input type="submit" value="Regresar"></button>
   </form>
 <a href="http://www.ucn.cl/" class="image fit"><img src="../../../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
</div>


	<div class="card card-1>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="derivationForm_interface.php" method="post">
		<img src="../../../assets/images/derivation.png" alt="carrera" height="190" width="190">
		<p>Realizar una Derivacion</p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>

	<div class="card card-2>
		<form method="post">
		</form>
		<div>
		<form name="hola" action="prev_derv.php" method="post">
		<img src="../../../assets/images/derivations.png" alt="carrera" height="190" width="190">
    <p> Revisar Derivaciones Previas </p>
		<input type="submit" value="Acceder">
		</form>
		</div>
	</div>
 </body>
 </html>
