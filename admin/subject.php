<?php
include ("model/Subject.php");
$sub=new Subject();
$action=$_REQUEST['action'];
 ?>
<html>
<body>
<?php if($action=="view"): ?>

<table width="80%">
      <tr>
    <td>#</td>
    <td>Subject Name</td>
      </tr>
    
     <?php
                      
    $sub->getSubject($_REQUEST['id']); 
    ?>                           
 </table>
 <?php elseif($action=="insert"): ?>
 <?php $sub->insertSubject($_POST['subject_name']); ?>
 Subject has been added <a href="subjects.php"> Go Back to Subjects </a>
 <?php elseif($action=="delete"): ?>
 <?php $sub->deleteSubject($_REQUEST['id']); ?>
 Record has been deleted <a href="subjects.php"> Go back to Subjects </a>
 
 
 
 <?php endif; ?>
</body>
</html>