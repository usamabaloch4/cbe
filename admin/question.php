

<?php
include ("model/Question.php");
$q=new Question();

$action="";
if(isset($_REQUEST['action']))
{
$action=$_REQUEST['action'];
}
 ?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
<style>
.correctans
{
color:blue;
font-weight: bold;
}
</style>
 </head>
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php") ?> </div>
<div class="main">


<?php if($action=="view"): ?>                  
 <h3>
 <?php if($_REQUEST['subid'] !="0") : ?>
 <?php $myarray=Question::getSubject($_REQUEST['subid']) ;
 echo ucwords($myarray['subject_name']);
  ?> </h3>
<?php endif ; ?>
<?php  $qarray=$q->getQuestion($_REQUEST['id']); ?>

 <br>
 <h4><?php echo ucfirst($qarray['question']); ?> </h4>
 <br>
 <b>Answers </b>
 <ol>
<?php $q->getQuestionAnswers($_REQUEST['id']); ?>
 </ol>
 <?php elseif($action=="insert"): ?>
 <?php 
$q->insertQuestion($_POST['question'],$_POST['subject'],$_POST['answer'],$_POST['correct_answer']) ?>
 
 Question has been added <a href="questions.php"> G Back to Questions </a>
 <?php elseif($action=="delete"): ?>
 <?php $q->deleteQuestion($_REQUEST['id']); ?>
 Record has been deleted <a href="questions.php"> Go back to Questions </a>
  <?php endif; ?>
</div>
</div>
</body>
</html>