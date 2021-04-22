<?php 
session_start();
include("model/OLE.php");
$exam= new OLE();
if(isset($_SESSION['student_id']) && isset($_SESSION['paper_id'])) : ?>
<?php 
$exam->updatePaperStatus($_SESSION['student_id'],$_SESSION['paper_id'],2);
session_destroy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/exam.css">

<script type="text/javascript" src="js/prototype.js">    </script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<title>Paper Over</title>
</head>
<body>
   <table width="500" border="0" class="table-border">
      <tr>
        <td width="86">&nbsp;</td>
        <td width="400">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><h2>Papaer has finsished
Good Luck!!!</h2></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
</body>
</html>
<a href="delete_all_questions_from_paper.php" style="color:#fff">Delete Inserted Questions </a>
<?php else : ?>
<?php header("location:index.php"); ?>
<?php endif ;?>
