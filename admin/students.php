<?php
include("model/Student.php");
$std=new Student(); ?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php") ?> </div>
<div class="main">
  <form action="student.php?action=insert" method="post">
    <br>
  <br>
  <table width="500"  class="table-border">
    <tr>
      <td height="17">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="25" height="29">&nbsp;</td>
      <td colspan="2"><h2>Insert New Student</h2></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="183">Student Name </td>
      <td width="278"><input name="student_name" type="text" size="40"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Student Father's Name</td>
      <td><input name="student_fname" type="text" size="40"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Student Roll Number</td>
      <td><input name="roll_number" type="text" size="40"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" value="Insert Student"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
</form>
<table width="80%">
<tr>
  <td width="5%">&nbsp;</td>
  <td width="5%">#</td><td>Student Id </td> <td width="39%"> Student Name </td><td width="11%">Edit</td><td width="18%">Delete</td></tr>
<?php
$std->getAllStudents(); ?>
</table>

</div>
<div class="footer"> All rights reserved 2012</div>

</div>
</body>
</html>