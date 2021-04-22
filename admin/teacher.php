<?php
include("model/Teacher.php");
$tchr=new Teacher();
$action=$_REQUEST['action'];
$teacher_id=@$_REQUEST['id'];
?>
<html>
<body>
<?php if($action=="view"): ?>
<table width="80%">
<tr><td>Teacher Id </td> <td> Teacher Name </td><td> Father's Name </td>
 </tr>

<?php
 
 
 $tchr->getTeacher($teacher_id); 

 ?>
</table>
  <?php elseif($action=="delete"): ?>
    <?php $tchr->deleteTeacher($teacher_id) ?>
     Record has been deleted <a href="teachers.php"> Go Back to Teachers </a>

<?php elseif($action=="insert") : ?>

<?php $tchr->insertTeacher($_POST['teacher_name'],$_POST['teacher_fname']) ?>
   Record has been added <a href="teachers.php"> Go Back to teachers </a>
<?php endif; ?>

</body>
</html>