<?php
include("model/Result.php");
$rs=new Result();
?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php"); ?></div>
<div class="main"><h1 style="font-size:30">Results</h1>

<table width="100%" class="table-border">

<?php
 echo $rs-> getLatestResults(); 

 ?>
</table>
  <br><br><br><br>



</div>

</body>
</html>