<?php
session_start();
session_name("admin");

if(isset($_POST['user'])) :?>
<?php
include ("model/OLE.php");
$ole=new OLE();
if($ole->login($_POST['user'],$_POST['password']))
{
$_SESSION['login']=true;
header("location:main.php");
}
else
{
header("location:index.php?error=1");

unset($_SESSION);
session_destroy();
}

?>
<?php else: ?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>

<form action="index.php" method="post">
<table width="400" class="login-table" cellpadding="0" cellspacing="0">
<tr style="background:#093B6D; height:30px"><td height="21"> </td>
  <td height="21" colspan="2" style="color:#fff; font-weight:bold">Administration Login</td>
  </tr>

<tr>
  <td height="29">&nbsp;</td>
  <td colspan="2"><div class="error">
<?php
$error="";
if(isset($_REQUEST['error']))
{
if($_REQUEST['error']=="1")
{
$error="Incorrect Login OR Password";
}elseif($_REQUEST['error']=="2")
{
$error="Please login first";
}
}
 echo $error;
?>

 </div></td>
  </tr>
<tr>
  <td width="38" height="29">&nbsp;</td>
  <td width="90">User Name </td> <td width="268"><input type="text" name="user"> </td> </tr>
<tr>
  <td height="37">&nbsp;</td>
  <td>Password</td>
  <td><input type="password" name="password"></td>
</tr>
<tr>
  <td height="24">&nbsp;</td>
  <td>&nbsp;</td> <td><input type="submit" value="Login"></td> </tr>
<tr>
  <td height="24">&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>  
</form>
</body>
</html>
<?php endif; ?>                          