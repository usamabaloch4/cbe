<?php
 class OLE
{

 function __construct()
{
  $this::connect();
}

public static function connect()
{
$con=mysql_connect("localhost","root","");
mysql_select_db("ble");


}

 public static function getSubject($id)
    {
    $result=mysql_query("SELECT * FROM subject where subject_id=".$id);
    $row=mysql_fetch_array($result);
    return $row;
    
    }


    function login($roll)
    {
   $qry="SELECT s.student_id,s.student_name,s.roll_number,s.class_id FROM student s WHERE s.roll_number='$roll'" ;
    $result=mysql_query($qry) or die(mysql_error());
    $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
    return $row;
    }else
    {
    return false;
    }
    
    }


    public function getAvailablePapersToday($class_id,$student_id)
    {
		     $qry="SELECT * FROM question_paper WHERE class_id=$class_id AND status=1" ;
   
   $papers=array();
    $result=mysql_query($qry) or die(mysql_error());
   $i=0;
   
   // $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
 
 
  while($rs=mysql_fetch_array($result))
  { 
	
	$papers[$i]=array($rs);
	$i++;   
}
  return $papers;
    }else
    {
    return false;
    }
    
    }


    public function canAppear($class_id,$student_id)
    {
    $qry="SELECT * FROM student_class WHERE class_id=$class_id AND student_id=$student_id";
    $result=mysql_query($qry) ;
    $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
   return true;
    }else
    {
    return false;
    }
    
    }
    
 
 
    public function getClassNameById($class_id)
    {
    $qry="SELECT * FROM class WHERE class_id=$class_id";
    $result=mysql_query($qry) ;
    $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
   return $row['class_name']." ".$row['current_year'];
    }else
    {
    return "Invalid Class";
    }
    
    }
    
 
 
 public function getSubjectNameById($subject_id)
    {
    $qry="SELECT * FROM subject WHERE subject_id=$subject_id";
    $result=mysql_query($qry) ;
    $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
   return $row['subject_name'];
    }else
    {
    return "Invalid Subject";
    }
    
    }
    
 
 
    function getNumberOfQuestions($qp_id)
    {
    $result=mysql_query("SELECT * FROM question_paper WHERE question_paper_id=$qp_id");
   $row=mysql_fetch_array($result);
   $qnums=$row['number_of_questions'];
   return $qnums;
    }


    public function getExamQuestion($qp_id,$s_id)
    {
   $qss=$this->getStudentInsertedQuestions($qp_id,$s_id);
   $sks=$this->getStudentSkippedQuestions($qp_id,$s_id);
 
 $botharrays=array_merge($qss,$sks);
  
 $additional="";
  if(is_array($botharrays))
  {
 $qs=array_unique($botharrays);
   if(count($qs) !=0)
   {
    if(count($qs)==1)
    {
   $additional=" AND ( qpq.question_id NOT IN (".$qs[0]."))";
    }else
    {
   $sqs=implode($qs,",");
   $additional=" AND ( qpq.question_id NOT IN (".$sqs."))";
    }
  }
  }
  
 $qry="SELECT * FROM question_paper_question qpq WHERE qpq.question_paper_id=$qp_id $additional  order by rand() limit 1 ";
 $result=mysql_query($qry);
 $row=mysql_fetch_array($result);
 $question_id=$row['question_id'];
 $ans= array();
 
   if(mysql_num_rows($result)> 0)
    {
    $qry2="SELECT * FROM answer a WHERE a.question_id=".$question_id ;
      $result2=mysql_query($qry2) ;
     
      if(mysql_num_rows($result2)> 0)
      { 
       $question['question_id']= $question_id;
        while( $row2=mysql_fetch_array($result2))
        {
        $ans[$row2['answer_id']]=$row2['answer'];
        }
    $qs=$this->getQuestion($question_id);
    $qans= array('question_id'=>$question_id,'question'=>$qs,"answers"=>$ans);
return $qans;
      }
    }else
    {
    return false;
    }
   
    
   
     
    }


   function getQuestion($qid)
   {
   $qry="SELECT * FROM question WHERE question_id=$qid";
   $result=mysql_query($qry);
   
   if(mysql_num_rows($result) > 0)
   {
   $row=mysql_fetch_array($result);
   return $row['question'];
   
   }else
   {
   return false;
   }
   
   
   }

function addQuestionTOStudentPaper($pid,$sid,$qid,$aid,$skipped)
{
$was_skipped=0;
if($skipped=="1")
{
$was_skipped=1;
}

$qry="INSERT INTO student_question_answer(paper_id,student_id,question_id,answer_id,was_skipped,date_inserted) values($pid,$sid,$qid,$aid,$was_skipped,NOW())";
   mysql_query($qry);
   if(mysql_affected_rows() > 0)
   {
   
   if($skipped=="1")
   {
  
   $this->deleteSkippedQuestion($pid,$sid,$qid);
   }
  
   return true;
  
   }else
   {
   false;
   }
  
    
   }

   function getSameExamQuestion($p_id,$q_id)
   {
  $qry="SELECT * FROM question_paper_question qpq WHERE qpq.question_paper_id=$p_id AND qpq.question_id = $q_id order by rand() limit 1 ";
   $result=mysql_query($qry);
   $row=mysql_fetch_array($result);
   $question_id=$row['question_id'];
   $ans= array();
 
   if(mysql_num_rows($result)> 0)
    {
    $qry2="SELECT * FROM answer a WHERE a.question_id=".$question_id ;
      $result2=mysql_query($qry2) ;
     
      if(mysql_num_rows($result2)> 0)
      { 
       $question['question_id']= $question_id;
        while( $row2=mysql_fetch_array($result2))
        {
        $ans[$row2['answer_id']]=$row2['answer'];
        }
    $qs=$this->getQuestion($question_id);
    $qans= array('question_id'=>$question_id,'question'=>$qs,"answers"=>$ans);
return $qans;
      }
    }else
    {
    return false;
    }
   
   
   }
   
   
   function getStudentInsertedQuestions($p_id,$s_id)
   {
   $sql="SELECT question_id FROM student_question_answer WHERE paper_id=$p_id AND student_id=$s_id" ;
   $result =mysql_query($sql);
   $qs= array();
  
   if(mysql_num_rows($result) > 0 )
   {
      while($row=mysql_fetch_array($result))
      {
      $qs[]=$row['question_id'];

      }
   
   }
   else
   {
   
   }
   
   return $qs;
   
   }
  
     // I was here on 12/11/2012, method need to be written correctly
  
   function getStudentSkippedQuestions($p_id,$s_id)
   {
   $sql="SELECT question_id FROM skipped_questions WHERE paper_id=$p_id AND student_id=$s_id" ;
   $result =mysql_query($sql);
   $qs= array();
  
   if(mysql_num_rows($result) > 0 )
   {
      while($row=mysql_fetch_array($result))
      {
      $qs[]=$row['question_id'];
      }
   
   }
   
   return $qs;
   
   }
  
  
  
  
  function addQuestionToSkipped($paper_id,$student_id,$question_id)
  {
 $sql="INSERT INTO skipped_questions(paper_id,student_id,question_id,date_created) values($paper_id,$student_id,$question_id,NOW())";
  mysql_query($sql) or die(mysql_error()) ;
  if(mysql_affected_rows() > 0)
  {
  return true;
  }
  else
  {
  return false;
  }
  
  
  
  } 





function getSkippedQuestion($p_id,$s_id)
{

 $qry="SELECT * FROM skipped_questions WHERE paper_id=$p_id AND student_id=$s_id limit 1";
/*$qss=$this->getStudentInsertedQuestions($qp_id,$s_id);
 
 
 $additional="";
  if(is_array($qss))
  {
 $qs=array_unique($qss);
    if(count($qs)==1)
    {
   $additional=" AND ( qpq.question_id NOT IN (".$qs[0]."))";
    }else
    {
   $sqs=implode($qs,",");
   $additional=" AND ( qpq.question_id NOT IN (".$sqs."))";
    }
  }
  */
 //$qry="SELECT * FROM question_paper_question qpq WHERE qpq.question_paper_id=$qp_id $additional  order by rand() limit 1 ";
   $result=mysql_query($qry);
   $row=mysql_fetch_array($result);
   $question_id=$row['question_id'];
   $ans= array();
 
   if(mysql_num_rows($result)> 0)
    {
    $qry2="SELECT * FROM answer a WHERE a.question_id=".$question_id ;
      $result2=mysql_query($qry2) ;
     
      if(mysql_num_rows($result2)> 0)
      { 
       $question['question_id']= $question_id;
        while( $row2=mysql_fetch_array($result2))
        {
        $ans[$row2['answer_id']]=$row2['answer'];
        }
    $qs=$this->getQuestion($question_id);
    $qans= array('question_id'=>$question_id,'question'=>$qs,"answers"=>$ans);
return $qans;
      }
    }else
    {
    return false;
    }
   
    
   
     
    }
    
    
    function deleteSkippedQuestion($pid,$sid,$qid)
    {
   $sql="delete FROM skipped_questions WHERE paper_id=$pid AND student_id=$sid AND question_id=$qid";
    mysql_query($sql);
    }
 

function getAttemptedQuestions($paper_id,$student_id)
{
$result=mysql_query("SELECT q.question_id,q.question FROM student_question_answer sqa,question q where paper_id=$paper_id AND student_id=$student_id AND sqa.question_id=q.question_id") or die(mysql_error());;
$qs=array();

while($row=mysql_fetch_array($result))
{
$qs[$row['question_id']]=$row['question'];
}
return $qs;
}


function getSkippedQuestions($paper_id,$student_id)
{
$result=mysql_query("SELECT q.question_id,q.question FROM skipped_questions sqa,question q where paper_id=$paper_id AND student_id=$student_id AND sqa.question_id=q.question_id") or die(mysql_error());;
$qs=array();

while($row=mysql_fetch_array($result))
{
$qs[$row['question_id']]=$row['question'];
}
return $qs;
}
   
  



function getReviewedQuestions($paper_id,$student_id)
{
$result=mysql_query("SELECT * FROM reviewed_questions where paper_id=$paper_id AND student_id=$student_id") or die(mysql_error());;
$qs=array();

while($row=mysql_fetch_array($result))
{
$qs[]=$row['question_id'];
}
return $qs;
}
  




function getAttemptedQuestionForReview($paper_id,$student_id)
{

$already=$this->getReviewedQuestions($paper_id,$student_id);




$additional="";
if(count($already) > 0)
{
$sqs=implode(",",$already);
$additional=" ( sqa.question_id NOT IN (".$sqs.")) AND ";
}

 $qry="SELECT q.question_id,q.question,sqa.answer_id FROM student_question_answer sqa,question q where ".$additional." paper_id=$paper_id AND student_id=$student_id AND sqa.question_id=q.question_id order by date_inserted limit 1 ";
$result=mysql_query($qry) or die(mysql_error());;
$row=mysql_fetch_array($result);
$qs=array("question_id"=>$row['question_id'],"question"=>$row['question'],"answer_id"=>$row['answer_id']);
$ans=array();

$qry2="SELECT * FROM answer WHERE question_id=".$row['question_id'];
$result2=mysql_query($qry2);

while($row2=mysql_fetch_array($result2))
{
$ans[$row2['answer_id']]=$row2['answer'];
}
$itself=array("qdetail"=>$qs,"answers"=>$ans);
return $itself;
}




function addToReviewQuestions($paper_id,$student_id,$question_id,$ans,$last_answer)
{

$qry="INSERT INTO reviewed_questions(paper_id,student_id,question_id,answer_id,last_answer_id,date_created) values($paper_id,$student_id,$question_id,$ans,$last_answer,NOW())";
mysql_query($qry);

}

 


function updateQuestionTOStudentPaper($paper_id,$student_id,$question_id,$ans)
{
$qry="UPDATE student_question_answer set answer_id=$ans,date_updated=NOW() WHERE paper_id=$paper_id AND student_id=$student_id AND question_id=$question_id";
mysql_query($qry);
return true;
}

 
function cancelStudentPaper($paper_id,$student_id)
{

$qry="delete from student_question_answer where paper_id=$paper_id AND student_id=$student_id";
mysql_query($qry);
mysql_query("delete from skipped_questions where paper_id=$paper_id AND student_id=$student_id");
mysql_query("delete from reviewed_questions where paper_id=$paper_id AND student_id=$student_id");

}


function cancelPaper()
{
mysql_query("delete from student_question_answer");
mysql_query("delete from skipped_questions");
}
   


function countDown($mm,$ss)
{
echo $mm;
echo "<br>";
echo $ss;
echo "<br>";
return 0;
}
 
   
   
 function setPaperStatus($student_id,$paper_id,$status)
 {
  mysql_query("INSERT INTO paper_status(student_id,paper_id,status,start_time,date_created) values($student_id,$paper_id,$status,CURTIME(),NOW())") or die(mysql_error());
 
 }
   
    function updatePaperStatus($student_id,$paper_id,$status)
 {
  
  $sql="UPDATE paper_status set status=$status,end_time=CURTIME() WHERE student_id=$student_id AND paper_id=$paper_id";
   mysql_query($sql) or die();
 
 }
   
   
 function appearedBefore($student_id,$paper_id)
 {

$status=true;

//echo "SELECT status FROM paper_status WHERE student_id=$student_id AND paper_id=$paper_id";

$result= mysql_query("SELECT status FROM paper_status WHERE student_id=$student_id AND paper_id=$paper_id AND status=2") or die();
if(mysql_num_rows($result) > 0)
{
$row=mysql_fetch_array($result);
/*
if($row['status']==1)
{	
$status=false;
}
*/

$status=false;

}

return $status;
 }
 
 
 
 	
function questionHistory($question_id,$student_id,$paper_id)
{
$sql="INSERT INTO question_history(question_id,student_id,paper_id,date_created) values($question_id,$student_id,$paper_id,NOW())";
mysql_query($sql) or die(mysql_error());
}

 
 
   
    
}   
   
?>