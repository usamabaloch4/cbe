<?php
include("model/Subject.php");
$sub=new Subject();


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
<br><br><br>


<form action="subject.php?action=insert" method="post">

 <table width="500"  class="table-border">
    <tr>
      <td height="17">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="25" height="29">&nbsp;</td>
      <td colspan="2"><h2>Insert New Subject</h2></td>
      </tr>
<tr><td>&nbsp;</td><td width="154">Subject Name </td><td width="305"><input type="text" name="subject_name"> </td> 
</tr>

<tr><td>&nbsp;</td><td width="154"> </td><td width="305"><input type="submit" value="Add New Subject"> </td> 
</tr>
<tr>
  <td>&nbsp;</td>
  <td></td>
  <td>&nbsp;</td>
</tr>
 </table>


 <br>


</form>


<table width="80%">
<tr><td>Subject Id </td> <td> Subject Name </td><td>Edit</td><td>Delete</td></tr>

<?php
 $sub->getAllSubjects(); 

 ?>
</table>
  <br>


</div>
</div>

</body>
</html>