<?php 
session_start();
include("model/OLE.php");
$exam= new OLE();
$skipped=0;
$curr=0;
$current=$_SESSION['current_question'];
  if($exam->addQuestionTOStudentPaper($_POST['paper_id'],$_POST['student_id'],$_POST['question_id'],$_POST['ans'],$_POST['is_skipped']))
  { 
  $_SESSION['is_refreshed']=0; 
  $_SESSION['cnpq'][1]=$_POST['question_id'];
  $_SESSION['cnpq'][0]=$_SESSION['currq_id'];
  $_SESSION['normal_question']++;
	++$_SESSION['total_answered'];  
  if($_POST['is_skipped']=="1")
    {
    $skipped= $_SESSION['skipped']; 
    $curr=$skipped-$current;
    --$_SESSION['skipped'];
    }
    else
    {
    $curr=($current-$_SESSION['skipped'])+1; 
    }
 
    if($_SESSION['total'] == $curr)
    {
    header("location:reviewPaper.php");
    }
    else
    {
    if($_POST['is_skipped']=="1")
    {
		++$_SESSION['skipped_answered'];

    }else
    {
 		++$_SESSION['normal_answered'];
   
    }
    $_SESSION['current_question']=++$current;
    header("location:exam.php?added=1");
   }
  
  
}
else
{
echo "there is problem, contact your teacher";
}

/*}else
{
header("location:addPaper.php");
} */

?>

