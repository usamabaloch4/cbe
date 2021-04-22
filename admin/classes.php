<?php
include("model/Classes.php");
$tchr=new Classes();
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
<form action="class.php?action=insert" method="post">
<br><br><br>
  <table width="500"  class="table-border">
    <tr>
      <td height="17">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="25" height="29">&nbsp;</td>
      <td colspan="2"><h2>Insert New Class</h2></td>
      </tr>
<tr><td>&nbsp;</td><td width="154">Class Name </td><td width="305"><input name="class_name" type="text" size="40"></td> 
</tr>
<tr><td>&nbsp;</td>
<td>Year</td><td><input name="current_year" type="text" size="40"></td> </tr>

<tr><td> </td><td> </td><td><input type="submit" value="Insert Class">
 </td> </tr>
<tr>
  <td></td>
  <td></td>
  <td>&nbsp;</td>
</tr>



  </table>
</form>


<table width="50%">
<tr>
 <td width="5%"># </td>  <td>Class </td> <td>Year</td><td>Edit</td><td>Delete</td> </tr>

<?php
 $tchr->getAllClasss(); 

 ?>
</table>

   <br><br><br><br>



</div>
</div>
</body>
</html>