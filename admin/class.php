<?php
include("model/Classes.php");
$tchr=new Classes();
$action=$_REQUEST['action'];
$class_id=@$_REQUEST['id'];
?>
<html>
<body>
<?php if($action=="view"): ?>
<table width="80%">
<tr><td>Class Id </td> <td> Class Name </td><td> Father's Name </td>
 </tr>

<?php
 
 
 $tchr->getClass($class_id); 

 ?>
</table>
  <?php elseif($action=="delete"): ?>
    <?php $tchr->deleteClass($class_id) ?>
     Record has been deleted <a href="classes.php"> Go Back to Classs </a>

<?php elseif($action=="insert") : ?>

<?php $tchr->insertClass($_POST['class_name'],$_POST['current_year']) ?>
   Record has been added <a href="classes.php"> Go Back to classs </a>
<?php endif; ?>

</body>
</html>