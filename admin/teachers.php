<?php
include("model/Teacher.php");
$tchr=new Teacher();
?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php") ?> </div>
<div class="main">
<form action="teacher.php?action=insert" method="post">
<br><br><br>
  <table width="500"  class="table-border">
    <tr>
      <td height="17">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="25" height="29">&nbsp;</td>
      <td colspan="2"><h2>Insert New Teacher</h2></td>
      </tr>
<tr><td>&nbsp;</td><td width="154">Teacher Name </td><td width="305"><input name="teacher_name" type="text" size="40"></td> 
</tr>
<tr><td>&nbsp;</td><td>Teacher Father's Name </td><td><input name="teacher_fname" type="text" size="40"></td> </tr>

<tr><td> </td><td> </td><td><input type="submit" value="Insert Teacher">
 </td> </tr>
<tr>
  <td></td>
  <td></td>
  <td>&nbsp;</td>
</tr>



  </table>
</form>


<table width="80%">
<tr><td>Teacher Id </td> <td> Teacher Name </td><td>Edit</td><td>Delete</td> </tr>

<?php
 $tchr->getAllTeachers(); 

 ?>
</table>

   <br><br><br><br>



</div>
</div>
</body>
</html>