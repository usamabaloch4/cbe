<?php 
session_start();
include("model/OLE.php");
$exam= new OLE();
$exam->cancelStudentPaper($_SESSION['paper_id'],$_SESSION['student_id']);
session_destroy();
header("location:index.php");
?>
