<?php
include '../../../includes/db_connect.php';

session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$consulta="SELECT * FROM program_admin where run='$_POST[run]'";

$con=pg_query($db,$consulta);

$rows=pg_num_rows($con);

if ($rows>0){
  header ("Location: existentAdmin.php");

}else{
  $sql="INSERT INTO program_admin values('$_POST[run]','$campus','$_POST[name]')";

  $result = pg_query($db,$sql);
  header ("Location: success.php");
}


 ?>
