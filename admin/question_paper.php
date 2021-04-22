<?php
 session_start();
 if(isset($_SESSION['login']) && $_SESSION['login']==true): ?>
<?php
include ("model/QuestionPaper.php");
$sub=new QuestionPaper();
$action=$_REQUEST['action'];?><?php if($action=="delete_question"): ?>
<?php $sub->deleteQuestion($_REQUEST["id"]); ?>
<?php header("location:question_paper.php?action=view_paper&id=".$_REQUEST["paper_id"]); ?>
<?php endif; ?> 
<?php if($action=="delete"): ?>
<?php $sub->deleteQuestionPaper($_REQUEST['id']); ?>
<?php header("location:question_papers.php"); ?>
<?php endif; ?> 
<?php if($action=="active"): ?>
<?php 
$sub->activeQuestionPaper($_REQUEST['id'],trim($_REQUEST['status'])); ?>
<?php 
header("location:question_papers.php"); ?>
<?php endif; ?> 
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
 <link rel="stylesheet" href="../css/calendarview.css">


<link href="view/css/styles.css" type="text/css" rel="stylesheet">
<script src="javascript/jquery.js" type="text/javascript" ></script>
 
<script type="text/javascript">
   var current=0;
function submitform(f)
{

if(total==current)
{
document.getElementById("myform").submit();
}else
{
alert("Please add more questions");
}

}



function addquestion(cc)
{

 

if(cc.checked)
{
if(current==(total-1))
{
alert("All Questions have been added");
}

document.getElementById("qnum").innerHTML=++current;
}else
{
document.getElementById("qnum").innerHTML=--current;
}

//document.getElementById("qnum").innerHTML=++current;
}

</script>


 </head><body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php") ?> </div>
<div class="main">

<?php if($action=="view"): ?>
<br><br><br>
<table width="100%">
      <tr>
    <td>#</td>
    <td>Question Paper ID</td><td>Teacher</td><td>Class</td><td>Subject</td><td>Paper Date</td>
      </tr>
    
     <?php
                      
    $sub->getQuestionPaper($_REQUEST['id']); 
    ?>                           
 </table>
 <?php elseif($action=="insert"): ?>
 <?php $qpid=$sub->insertQuestionPaper($_POST['teacher'],$_POST['subject'],$_POST['qnums'],$_POST['class'],$_POST['chours'],$_POST['cminutes'],$_POST['question_paper_date']); ?>
 QuestionPaper has been added 
 <a href="question_paper.php?action=insert_questions&id=<?php echo $qpid ?>">Add Questions Now </a>
 <a href="question_papers.php"> Go Back to QuestionPapers </a>
  <?php elseif($action=="insert_questions"): ?>
<br> <br>
 <a href="question_paper.php?action=random&qp_id=<?php echo $_REQUEST['id'] ?>"> Add Random Questions </a>
 OR Add Questions Manaually  
 <form action="question_paper.php?action=insert_selected_questions&id=<?php echo $_REQUEST['id'] ?>" method="post" id="myform">
  <table>
<?php $sub->showSubjectQuestions($_REQUEST['id']); ?>
<tr><td colspan="3" align="right" height="50"><input type="button" value="Add Questions" onclick="submitform(this)"> </td> </tr>
</table>
</form>
 <?php elseif($action=="random"): ?>
<?php $sub->addRandomQuestions($_REQUEST['qp_id']); ?>
Questions have been added to Question Paper <a href="question_papers.php"> Go back to Question Papers </a>
<?php elseif($action=="view_paper"): ?>
<br><br><br>
<table width="100%">
<?php $sub->viewQuestionPaper($_REQUEST['id']); ?>
</table>

<?php elseif($action=="insert_selected_questions"): ?>
<?php 
$pid=$_REQUEST["id"];
$sub->insertSelectedQuestion($pid,$_POST["questions"]) ?>
Questions have been added to Question Paper <a href="question_papers.php"> Go back to Question Papers </a>
<?php elseif($action=="delete_question"): ?>
<?php $sub->deleteQuestion($_REQUEST["id"]); ?>
Questions have been added to Question Paper <a href="question_papers.php"> Go back to Question Papers </a>
<?php endif; ?>
</div>
</div>
</body>
</html>
<?php else: ?>
<?php header("location:index.php");?>
<?php endif; ?>