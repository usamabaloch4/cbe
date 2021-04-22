<?php 
session_start();
include("../model/OLE2.php");
$exam= new OLE();
$current=$_SESSION['current_question'];
$skip=$_SESSION['skipped'];
$_SESSION['skipped']=++$skip;
$exam->addQuestionToSkipped($_POST['question_id']) ;
$_SESSION['current_question']=++$current;
header("location:computer-test.php");
?>

