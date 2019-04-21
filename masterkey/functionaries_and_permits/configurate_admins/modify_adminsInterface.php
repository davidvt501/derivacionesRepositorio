<?php
include '../../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$run=$_SESSION["run_f"];
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
     <form action="../mainInterface.php">
     <input type="submit" value="Regresar"></button>
   </form>
 <a href="http://www.ucn.cl/" class="image fit"><img src="../../../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
</div>


<div class="card card-1>
	<form method="post">
	</form>
	<div>
	<p>Agregar Administradores</p>
	<form name="empty" action="addAdminInterface.php">
	<img src="../../../assets/images/add_admin.png" alt="carrera" height="190" width="190">
	<br> <input type="submit" value="Acceder">
</form>
	</div>
</div>

<div class="card card-2>
	<form method="post">
	</form>
	<div>
	<p>Eliminar Administradores</p>
	<form name="empty" action="removeAdminInterface.php">
	<img src="../../../assets/images/remove_admin.png" alt="carrera" height="190" width="190">
	<br> <input type="submit" value="Acceder">
	</form>
	</div>
</div>



 </body>
 </html>
