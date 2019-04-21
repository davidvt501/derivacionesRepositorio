<?php
include '../../../includes/db_connect.php';

session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$consulta="SELECT * FROM master_key where run='$_POST[run]'";

$con=pg_query($db,$consulta);

$rows=pg_num_rows($con);

if ($rows>0){
  header ("Location: existentSuperadmin.php");

}else{
  $sql="INSERT INTO master_key values('$_POST[run]','$campus','$_POST[name]')";

  $result = pg_query($db,$sql);
  header ("Location: success.php");
}


 ?>
