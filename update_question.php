<?php 
session_start();
include("model/OLE.php");
$exam= new OLE();
$skipped=0;
$curr=0;

if($_POST['last_answer']==$_POST['ans'])
{
$exam->addToReviewQuestions($_SESSION['paper_id'],$_SESSION['student_id'],$_POST['question_id'],$_POST['ans'],$_POST['last_answer']);
++$_SESSION['review_question'];
 header("location:reviewPaper.php?added=1");

}
else
{
$exam->addToReviewQuestions($_SESSION['paper_id'],$_SESSION['student_id'],$_POST['question_id'],$_POST['ans'],$_POST['last_answer']);
 

 if($exam->updateQuestionTOStudentPaper($_POST['paper_id'],$_POST['student_id'],$_POST['question_id'],$_POST['ans']))
  { 
 ++$_SESSION['review_question'];

    if($_SESSION['total'] == $_SESSION['review_question'])
    {
    header("location:addPaper.php");
    }
    else
    {
 	   
    header("location:reviewPaper.php?added=1");
   }
  
  
}
else
{
echo "there is problem, contact your teacher";
}
}
/*}else
{
header("location:addPaper.php");
} */

?>

