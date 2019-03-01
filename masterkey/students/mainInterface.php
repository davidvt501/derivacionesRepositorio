  <?php
include '../../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$sCarrer=pg_query($db,"SELECT * FROM carrer WHERE campus='$campus' AND active=true ORDER BY name");
$Carrer=pg_fetch_assoc($sCarrer);
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="utf-8">
 <title>select</title>
 <link rel="stylesheet" type="text/css" href="../../assets/css/funcionarios.css">
 <link rel="stylesheet" type="text/css" href="../../assets/css/funcionarios2.css">
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
 button{
   padding: 0;
border: none;
background: none;
 }
 </style>
 <style>
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
 <a href="../criteria_and_studentsInterface.php" class="image fit"><img src="../../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt=""></a>
</div>
    <?php
    while($Carrer=pg_fetch_assoc($sCarrer)){
      $cod=$Carrer['cod_carrer'];
      echo '<div class="car card-3">';
        echo ucwords(strtolower($Carrer['name']));
        echo '<br>';
        echo '<form action="students_search.php" method="post">';
        echo '<button type="submit" name="cod" value="'.$Carrer['cod_carrer'].'""><img src="../../assets/images/'.$cod.'.png" alt="Alt" height="100" width="100"></button>';
        echo '<br>';
      //  echo '<input type="hidden" name="cod[]" value="'.$Carrer['cod_carrer'].'">';
        echo '<br>';
      //  echo '<button type="submit">Ingresar</button>';
        echo '<form>';
      echo '</div>';
      }
      ?>

 </body>
 </html>
