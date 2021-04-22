<?php
session_start();
include("model/OLE.php");
$exam= new OLE();
if(isset($_SESSION['student_id']) && isset($_SESSION['paper_id'])) : ?>
<?php $current=$_SESSION['current_question'];?>
<?php
$is_skipped=false;
if(!isset($_SESSION['timer']))
{
$date = date_create(date("h:i:s"));
date_add($date, date_interval_create_from_date_string($_SESSION['time_hh'].' hours '.$_SESSION['time_mm'].' minutes 05 seconds'));
//var_dump($date);
//echo $orignal=date("h:i:s",$st);
$_SESSION['timer']=$date;
$remainingHour=$_SESSION['time_hh'];
$remainingMinutes=$_SESSION['time_mm'];
$remainingSeconds=05; 
}
else
{
$actual_date=$_SESSION['timer'];
//var_dump($actual_date);
$date = date_create(date("h:i:s"));





$hh=date_format($date,"h");
$mm=date_format($date,"i");
$ss=date_format($date,"s");



$hhh=date_format($actual_date,"h");
$mmm=date_format($actual_date,"i");
$sss=date_format($actual_date,"s");


$start_date = new DateTime($hhh.":".$mmm.":".$sss);
//var_dump($start_date);

//$since_start = $start_date->diff(new DateTime());
//$time=$since_start->h.":".$since_start->i.":".$since_start->s;

//var_dump($since_start);


date_sub($start_date, date_interval_create_from_date_string($hh.' hours '.$mm.' minutes '.$ss.' seconds'));


echo "<!--";
print_r($start_date);
echo "-->";

//echo $since_start->date->h;

$remainingMinutes=date("i",strtotime($start_date->date));
$remainingHour=date("H",strtotime($start_date->date));
$remainingSeconds=date("s",strtotime($start_date->date));

}

/*echo "<br> Houses ".$remainingHour;
echo "<br> Minutes ".$remainingMinutes;
echo "<br> Seconds ".$remainingSeconds;
*/

?>
  
<?php if( ($_SESSION['normal_question']) ==$_SESSION['total'] ): ?>
<?php header("location:addPaper.php"); ?>
<?php endif; ?>

<?php //if((($current+1-$_SESSION['skipped'])== $_SESSION['total']) ): ?>
<?php if($_SESSION['total_answered']+$_SESSION['skipped']==$_SESSION['total']) : ?>
<?php if( $_SESSION['skipped'] > 0 ): ?>
<?php $q=$exam->getSkippedQuestion($_SESSION['paper_id'],$_SESSION['student_id']); ?>
<?php $is_skipped=true; ?>
<?php endif; ?>
<?php else: ?>
<?php $q=$exam->getExamQuestion($_SESSION['paper_id'],$_SESSION['student_id']); ?>
<?php $exam->questionHistory($q['question_id'],$_SESSION['student_id'],$_SESSION['paper_id']); ?>
<?php endif; ?>
<?php $_SESSION['currq_id']=$q['question_id']; ?>
<?php $_SESSION['cpnq'][0]=$_SESSION['currq_id']; ?>
<?php $refreshed=$_SESSION['is_refreshed']; ?>
<?php $_SESSION['is_refreshed']=++$refreshed; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/exam.css">

<script type="text/javascript" src="js/prototype.js">    </script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
  var days =  0 ;  
  var hours = <?php echo $remainingHour; ?>  
  var minutes = <?php echo $remainingMinutes; ?>  
  var seconds = <?php echo $remainingSeconds; ?> 
function setCountDown ()
{
  seconds--;
  if (seconds < 0){
      minutes--;
      seconds = 59
  }
  if (minutes < 0){
      hours--;
      minutes = 59
  }
  if (hours < 0){
      days--;
      hours = 23
  }
  document.getElementById("remain").innerHTML =hours+" hours, "+minutes+" minutes, "+seconds+" seconds";
  SD=window.setTimeout( "setCountDown()", 1000 );
  if (minutes == '00' && seconds == '00') { seconds = "00"; window.clearTimeout(SD);
   		window.alert("Time is up. Press OK to continue."); // change timeout message as required
  		window.location = "addPaper.php" // Add your redirect url
 	} 

}

</script>
</head>
<body onLoad="setCountDown();">
<div class="wrapper">

<table width="100%" class="header-cotainer" cellpadding="0" cellspacing="0"><tr><td valign="middle" class="header" >
<table width="100%" style="margin-top:18px"> <tr><td><h4>Question <?php echo ($_SESSION['total_answered']+1); ?> </h4> </td> <td><h4><?php if($_SESSION['skipped'] > 0): ?>
You Have Skipped : <?php echo $_SESSION['skipped'] ?> Questions 
<?php endif; ?></h4> </td> <td><h4>
 <div id="remain"><?php echo "$remainingHour hours, $remainingMinutes minutes, $remainingSeconds seconds";?></div></h4> </td> </tr> </table>


</td> <td valign="middle" class="header-light"><h4><?php echo $_SESSION['student_name']." , ".$_SESSION['roll_number'] ?> </h4> </td> </tr> </table>
<div class="main-col" >
<a href="finishPaper.php"><img src="images/cancel.jpg"> </a>
<?php if($current== ($_SESSION['total'])): ?>
<h3 class="note">Last Question </h3>
<?php endif ?>
<?php if($is_skipped): ?>
This is the question you skipped earlier
<?php endif; ?>
 <h2><?php echo ucfirst($q['question']) ?>  </h2>
<form  method="post" id="eform">
<br><br><br><br>
<h4> Select appropriate answer from following </h4>
<?php
$answers=$q['answers'];
foreach($answers as $key=>$value) : ?>
<input type="radio" value="<?php echo $key ?>" name="ans">
<?php echo $value ?><br>
<?php endforeach; ?>
<input type="hidden" name="student_id" value="<?php echo $_SESSION['student_id'] ?>">
<input type="hidden" name="paper_id" value="<?php echo $_SESSION['paper_id'] ?>">
<input type="hidden" name="question_id" value="<?php echo $q['question_id'] ?>">
<input type="hidden" name="is_skipped" value="<?php echo $is_skipped ?>">
<input type="hidden" name="mm" value="" id="mm">
<input type="hidden" name="ss" value="" id="ss">
<br><br>

<?php if(! $is_skipped) :?><input type="image" src="images/skipp.jpg" onClick="skipQuestion()" style="margin-right:12px"><?php endif; ?>
<input type="image" src="images/next.jpg"  onClick="addQuestion()">
</form>
</div>
<div class="right-col">
<?php 
$attempted_questions=$exam->getAttemptedQuestions($_SESSION['paper_id'],$_SESSION['student_id']);
if(count($attempted_questions) > 0): ?>
<div class="attempeted" >
<div class="head"><h4>Question You Attempted </h4> </div>

<ul>
<?php foreach($attempted_questions as $key=>$value) : ?>
<li> <?php echo $value; ?> </li>
<?php endforeach; ?>
</ul>

</div>
<?php endif; ?>
<?php 
$attempted_questions=$exam->getSkippedQuestions($_SESSION['paper_id'],$_SESSION['student_id']); 
if(count($attempted_questions) > 0): ?>
<div class="skipped" >
<div class="head"><h4>Question You Skipped </h4> </div>
<ul>
<?php foreach($attempted_questions as $key=>$value) : ?>
<li> <?php echo $value; ?> </li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>
</div>


<script>
 function skipQuestion()
 {
 document.forms[0].action="skip.php";
 document.forms[0].submit();
 }
function addQuestion()
{
var check=false;
$$('input').each(function(ele){
   //console.log(ele.type);
  if(ele.type=="radio")
    {
   if( $(ele).checked )
   {
   check=true;
       //checkedList.push($(ele).name);
   }
   }
});

if(check)
{
 document.forms[0].action="add_question.php";
 document.forms[0].submit();
}
else
{
alert("Please select answer");
return false;
}

 }

  


</script>
</div>
 </body> </html>
 <?php else: ?>
 Please Login again
 
<?php endif ;?> 
