<?php
 session_start();
 if(isset($_SESSION['login']) && $_SESSION['login']==true): ?>
<?php
include ("model/Result.php");
$rs=new Result();
?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php  include("view/main_navigation.php"); ?>
 </div>
<div class="main"><h1 style="font-size:30">Results </h1>
<?php if($_REQUEST['action']=="view_result"): ?>
<?php 
$pid=$_REQUEST["paper_id"];
?>
<table width="800" class="table-border" >
<tr><td class="bold">Student Name </td> <td class="bold">Roll Number </td><td class="bold">Marks </td> <td class="bold">Total Paper Time  </td> <td> Detail </td></tr>
<?php
echo $rs->loadResult($pid) ?>
</table>
<?php endif; ?>
<?php if($_REQUEST['action']=="student_paper_detail"): ?>
<?php 
$pid=$_REQUEST["paper_id"];
?>
<table width="800" class="table-border" >
<tr><td>#  </td> <td>Question  </td><td>Student's Answer </td> </tr>
<?php
echo $rs->showDetailedStudentResult($_REQUEST['student_id'],$pid) ?>
</table>
<?php endif; ?>

<?php if($_REQUEST['action']=="paper_statistics"): ?>
<?php 
$pid=$_REQUEST["paper_id"];
?>
<table width="800" ><tr><td colspan="2"><h2>Paper Statistics </h2> </td></tr>
<?php
echo $rs->showResultStatistics($pid) ?>
</table>
<?php endif; ?>

</div>
</body>
</html>
<?php else: ?>
<?php header("location:index.php");?>
<?php endif; ?>