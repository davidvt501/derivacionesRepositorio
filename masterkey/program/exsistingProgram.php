<?php
session_start();

$campus=$_SESSION["campus"];
$_SESSION["campus"]=$campus;
?>
<head>
</head>
<body>
  <p>Este programa ya existe</p>
<form action="mainInterface" method="post">
  <button>Regresar</button>
</form>
</body>
</html>
