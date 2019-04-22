<?php
include '../includes/db_connect.php';
session_start();
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
  <link rel="stylesheet" type="text/css" href="../assets/css/funcionarios2.css">
 <link rel="stylesheet" type="text/css" href="../assets/css/boxes_<?php echo $campus ?>.css">
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
<style>table.blueTable {
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
     <form action="program_adminInterface.php">
     <input type="submit" value="Regresar"></button>
   </form>
 <a href="http://www.ucn.cl/" class="image fit"><img src="../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
</div>


<div class="container">
  <h2>Modificar Funcionarios:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
    <!---<?php echo '<img src="../../assets/images/'.$cod.'.png" alt="Alt" height="140" width="140">';?>--->
      <?php echo $code?>
      <b> Agregar funcionarios </b>
        <br>
        <form name="insert" action="add_functionary.php" method="POST">
      			RUN:
      			<input class="input_rut" type="text" name="run" placeholder="RUN completo sin puntos" oninput="checkRut(this)" maxlength="12" required>
            <br>
           Nombre Completo
      		 <input type="text" name="name" maxlength="100" required><br>
           <br>
           Telefono
      			 <input type="text" name="phone" maxlength="20" required><br>
              <br>
             Correo
      			 <input type="text" name="mail" maxlength="50" required><br>
      		 <input type="submit" value="Agregar">
      	</form>
        <br>
        <b> Remover funcionario </b>
        <table class="blueTable">
          <thead align="center">
            <tr>
            <th>Run</th>
            <th>Nombre</th>
            <th>Remover</th>
            </tr>
          </thead>
          <tbody>
              <?php
              $conFunctionaries=pg_query($db,"SELECT permits_f.*,functionary.name as functionary_name FROM permits_f
                INNER JOIN functionary ON functionary.run=permits_f.run where code='$code'");
              while($mostrar=pg_fetch_assoc($conFunctionaries)){
                echo '<td>'.$mostrar['run'].'</td>';
                echo '<td>'.$mostrar['functionary_name'].'</td>';
                echo ' <td>
                <form action="remove_functionary.php" method="post">
                <input type="hidden"  name="run" value="'.$run.'">
                <input type="hidden"  name="code" value="'.$code.'">
                <input type="submit" value="Remover"></input>
                </form>
                </td>
                ';
              }
              ?>
            </tbody>
          </table>
    </div>
  </div>
</div>


 </body>
 </html>
