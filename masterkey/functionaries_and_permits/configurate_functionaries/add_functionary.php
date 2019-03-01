<?php
include '../../../includes/db_connect.php';

session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;

$consulta="SELECT * FROM functionary where run='$_POST[run]'";

$con=pg_query($db,$consulta);

$rows=pg_num_rows($con);

if ($rows>0){
  header ("Location: existentFunctionary.php");

}else{
  $sql="INSERT INTO functionary values('$_POST[run]','$_POST[name]','$_POST[phone]','$_POST[mail]',123,true,'$campus')";

  $result = pg_query($db,$sql);
  header ("Location: success.php");
}


 ?>
