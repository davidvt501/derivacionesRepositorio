<?php

include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$cod=$_POST['cod_p'];

$delete_prog="UPDATE program SET active=false WHERE cod_program='$cod'";

$exe=pg_query($db,$delete_prog);

$name_con=pg_query($db,"SELECT * FROM program where cod_program='$cod'");

$name=pg_fetch_assoc($name_con);

$delete_permits="DELETE FROM permits_f WHERE code='$cod'";

$exe2=pg_query($db,$delete_permits);

if ($name['type']=='e'){
  $tipo='estudiantil';
}else{
  $tipo='de apoyo';
}
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
 <form action="mainInterface.php" method="post">
  <input type="image" src="../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt="">
 </form>
 </div>

 <div class="container">
  <h2>Programa Removido</h2>
  <div class="panel panel-default">
    <div class="panel-body">
      <p> El programa <?php echo $tipo ;echo ' '; echo $name['name']?> ha sido removido con sus permisos respectivos </p>
    </div>
  </div>
 </div>


 </body>
</html>
