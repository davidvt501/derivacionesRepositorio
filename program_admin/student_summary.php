<?php
include '../includes/db_connect.php';
session_start();
$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
$code=$_SESSION["code"];
$_SESSION["code"]=$code;

$run=$_POST["run"];

if ($campus=='a'){
  if ($code==402){
    $code_student_pre[1]=502;
    $code_student=implode(", ", $code_student_pre);
  }else if($code==401){
    $code_student_pre[1]=503;
    $code_student_pre[2]=504;
    $code_student_pre[3]=505;
    $code_student=implode(", ", $code_student_pre);
  }
}else if ($campus=='c'){
  if ($code==201){
    $code_student_pre[1]=302;
    $code_student_pre[2]=303;
    $code_student_pre[3]=304;
    $code_student_pre[4]=305;
    $code_student=implode(", ", $code_student_pre);
  }else if($code=203){
    $code_student_pre[1]=301;
    $code_student=implode(", ", $code_student_pre);
  }
}

$student_pg="SELECT student.name as student_name,student.run,student.income_year,carrer.name,carrer_student.cod_carrer as cod_carrer FROM
student INNER JOIN carrer_student ON carrer_student.run=student.run INNER JOIN carrer ON carrer.cod_carrer=carrer_student.cod_carrer
WHERE student.run='$run'";
$searchStudents=pg_query($db,$student_pg);
$mostrar=pg_fetch_assoc($searchStudents);
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

  <a href="http://www.ucn.cl/" class="image fit"><img src="../images/ucnlogo.png" align="right" style="width:100px; height:100px"; alt=""></a>
  <a href="modify_studentsInterface.php" class="image fit"><img src="../assets/images/back-arrow.png" align="left" style="width:90px; height:90px"; alt=""></a>
  </div>


<div class="container">
  <h2><?php echo $mostrar['student_name']?>:</h2>
  <div class="panel panel-default">
    <div class="panel-body">
        Carrera: <?php echo $mostrar['name'];?> <br>
        Año de Ingreso: <?php echo $mostrar['income_year'];?>
        <br>
        <b> Programas a los que pertenece </b>
        <br>
        <?php
        $searchStudents=pg_query($db,"SELECT student.*,carrer.name as carrer_name,program.name as program_name,program.cod_program as cod_program
        FROM student INNER JOIN carrer_student ON carrer_student.run=student.run
        INNER JOIN carrer ON carrer_student.cod_carrer
        =carrer.cod_carrer INNER JOIN program_student ON program_student.run=student.run
        INNER JOIN program ON program.cod_program=program_student.cod_program
        WHERE program_student.cod_program IN ($code_student) AND student.run='$run'");
        while($mostrar2=pg_fetch_assoc($searchStudents)){
          echo $mostrar2['program_name'];
 }
        ?>
    </div>
  </div>
</div>


 </body>
 </html>
