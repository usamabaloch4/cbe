<?php 
session_start();
include("model/OLE.php");
$exam= new OLE();
$current=$_SESSION['current_question'];
$skip=$_SESSION['skipped'];
$_SESSION['skipped']=++$skip;
$exam->addQuestionToSkipped($_POST['paper_id'],$_POST['student_id'],$_POST['question_id']) ;
$_SESSION['current_question']=++$current;
header("location:exam.php");
?>

