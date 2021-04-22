<?php
include("model/Student.php");
$std=new Student();
if(isset($_POST['studentId']))
{
$std->assignClass($_POST['studentId'],$_POST['class']);
header("Location:students.php");
}else
{

$action=@$_REQUEST['action'];
$student_id=@$_REQUEST['id'];
?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php echo include("view/main_navigation.php"); ?>
 </div>
<div class="main"><h1> Student Detail</h1>
<?php if($action=="view"): ?>
<table width="80%">

<?php
  $std->getStudent($student_id); 
 ?>
<tr><td> </td><td ><a href="?action=assignclass&id=<?php echo $student_id ?>">Class Enrollment </a> </td></tr>

</table>
  <?php elseif($action=="delete"): ?>
    <?php $std->deleteStudent($student_id) ?>
     Record has been deleted <a href="students.php"> Go Back to Students </a>

<?php elseif($action=="insert") : ?>

<?php $std->insertStudent($_POST['student_name'],$_POST['student_fname'],$_POST['roll_number']) ?>
   Record has been added <a href="students.php"> Go Back to Students </a>
<?php elseif($action=="assignclass") : ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="studentId" value="<?php echo $_REQUEST['id'] ?>">
<select name="class"><?php $std->getClassDropDown(); ?> </select>
<br>
<br>
<input type="submit" value="Enrolle">
</form>
<?php endif; ?>
</div>
</body>
</html>
<?php } ?>
