<?php
session_start();
include("model/OLE.php");
$std=new OLE();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <title> Online Examination System </title>
  <link href="css/styles.css" rel="stylesheet" type="text/css">
  </head>
  <body>
<?php
if(isset($_POST['roll'])) : ?>
<?php
 $student=$std->login($_POST['roll']);
 
 
    if(! $student)
   {
   echo "<br><br><br><br><br><br><br><center><h2>no student found with this roll number, Please check your roll number again, Or confirm paper date from your examiner</h2></center>";
   }
   else
   {
  $papertoday=$std->getAvailablePapersToday($student['class_id'],$student['student_id']);
  // print_r($papertoday);
    if(!$papertoday)
     {
     echo "<br><br><center><h2>No paper is scheduled today</h2> </center>";
     }else
     {
 
// echo count($papertoday);
 
  if(count($papertoday) >1 ){
 header("location:index2.php");
 exit(0);
  }
  
  $papertoday=$papertoday[0][0]; 
 // print_r($papertoday); 
       if($std->canAppear($student['class_id'],$student['student_id']))
       {
 
       
	   	if($std->appearedBefore($student['student_id'],$papertoday['question_paper_id']))
		{
	   
	  $std->setPaperStatus($student['student_id'],$papertoday['question_paper_id'],1,time());
	    
	   $total=$std->getNumberOfQuestions($papertoday['question_paper_id']);
       $_SESSION['student_id']= $student['student_id'];
	   $_SESSION['student_name']=$student['student_name'];
	   $_SESSION['time_allowed']= strtotime($papertoday['time_hours'].":".$papertoday['time_minutes'].":"."00");
	   $_SESSION['time_hh']= $papertoday['time_hours'];
	   $_SESSION['time_mm']= $papertoday['time_minutes'];
	   $_SESSION['roll_number']=$student['roll_number'];
       $_SESSION['paper_id']= $papertoday['question_paper_id'];
	   $_SESSION['subject_id']= $papertoday['subject_id'];
       $_SESSION['total']= $total;
       $_SESSION['current_question']= 0;
       $_SESSION['normal_question']= 0;
       $_SESSION['skipped']= 0;
       $_SESSION['is_refreshed']= 0;
	   $_SESSION['normal_answered']= 0;
	   $_SESSION['skipped_answered']= 0;
	   $_SESSION['total_answered']= 0;
       $_SESSION['currq_id']=0; //current question id
       $_SESSION['cnpq']=array();
	   $_SESSION['review_question']=0;
     
     echo "<div class='center-content'><h2>Logged in Student:  ".$_SESSION['student_name']." , Roll Number: ".$student['roll_number']." </h2><h1>Total questions in this paper: ".$total."</h1><h3>Class : ".$std->getClassNameById($student['class_id']).", Subject ".$std->getSubjectNameById($papertoday['subject_id'])." </h3>";
echo "<h4>Test Consist of Multiple Choice Questions, Total Time allowed is ".$papertoday['time_hours']." : ".$papertoday['time_minutes']." </h4>";
     echo "<br> <a href='exam.php' ><img src='images/start.jpg'> </a> </div>";
		}
		else
		{
			echo "<br><br><br><br><br><br><br><center><h2> You Have already appreared in this paper </h2>";
		}
       }else
       {
       echo "<br><br><br><br><br><br><br><center><h2> You can not appear in todays paper </h2>";
       }
     
     } 
  
  
  // print_r($student);
   }

?>
<?php else : ?>

  <form action="index.php" method="post">
    <table width="500" border="0" class="table-border">
      <tr>
        <td width="192">&nbsp;</td>
        <td width="294">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Enter Your Roll Number</td>
        <td><input name="roll" type="text" size="35"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" value="Login"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  </body>
</html>
<?php endif;?>

