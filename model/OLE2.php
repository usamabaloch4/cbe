<?php
 class OLE
{

 function __construct()
{
  $this::connect();
}

public static function connect()
{
//$con=mysql_connect("localhost","root","");
//mysql_select_db("exams");

mysql_connect("localhost","gmuqtada","kamran421");
mysql_select_db("gmuqtada_exam");
}

 public static function getSubject($id)
    {
    $result=mysql_query("SELECT * FROM subject where subject_id=".$id);
    $row=mysql_fetch_array($result);
    return $row;
    
    }


    function login($roll)
    {
   $qry="SELECT * FROM student WHERE roll_number='$roll'" ;
    $result=mysql_query($qry);
    $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
    return $row;
    }else
    {
    return false;
    }
    
    }


    public function getAvailablePapersToday()
    {
     $qry="SELECT * FROM question_paper WHERE question_paper_date=CURDATE()" ;
    $result=mysql_query($qry);
    $row=mysql_fetch_array($result);
    if(mysql_num_rows($result)> 0)
    {
    return $row;
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
    
    function getNumberOfQuestions($qp_id)
    {
    $result=mysql_query("SELECT * FROM question_paper WHERE question_paper_id=$qp_id");
   $row=mysql_fetch_array($result);
   $qnums=$row['number_of_questions'];
   return $qnums;
    }


    public function getExamQuestion($cat_id)
    {
   $qsss=$_SESSION['answeredSoFar'];
   $sks=$_SESSION['skippedSoFar'];
   $qss=array();
 $i=0;
 foreach($qss as $qid)
 {
 
 $qss[$i++]=$qid['question_id'];
 }
 
$botharrays=array_merge($qss,$sks);
 $additional="";
  if(is_array($botharrays))
  {
 $qs=array_unique($botharrays);
   if(count($qs) !=0)
   {
    if(count($qs)==1)
    {


  $additional=" AND ( qpq.id NOT IN (".$qs[0]."))";
    }else
    {
   $sqs=implode($qs,",");
   $additional=" AND ( qpq.id NOT IN (".$sqs."))";
    }
  }
  }
  if(count($additional) == 0)
  {
  $additional="";
  }
  
  
 $qry="SELECT * FROM qbank qpq WHERE qpq.cat_id=$cat_id  $additional order by rand() limit 1 ";
 $result=mysql_query($qry) or die(mysql_error()." ".$qry);
 $row=mysql_fetch_array($result);
 $question_id=$row['id'];
 $ans= array();
 
   if(mysql_num_rows($result)> 0)
    {
    $qry2="SELECT * FROM answers a WHERE a.question_id=".$question_id ;
      $result2=mysql_query($qry2) ;
     
      if(mysql_num_rows($result2)> 0)
      { 
       $question['question_id']= $question_id;
         $row2=mysql_fetch_array($result2);
        $ans[1]=$row2['ans1'];
$ans[2]=$row2['ans2'];
$ans[3]=$row2['ans3'];
$ans[4]=$row2['ans4'];
       
    $qs=$row['question'];
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
   $qry="SELECT * FROM qbank WHERE id=$qid";
   $result=mysql_query($qry) or die(mysql_error());
   
   if(mysql_num_rows($result) > 0)
   {
   $row=mysql_fetch_array($result);
   return $row['question'];
   
   }else
   {
   return false;
   }
   
   
   }


  function getSubjectNameById($sid)
   {
   $qry="SELECT * FROM categories WHERE id=$sid";
   $result=mysql_query($qry) or die(mysql_error());
   
   if(mysql_num_rows($result) > 0)
   {
   $row=mysql_fetch_array($result);
   return $row['name'];
   
   }else
   {
   return false;
   }
   
   
   }



function addQuestionTOStudentPaper($pid,$qid,$aid,$skipped)
{
$was_skipped=0;
if($skipped=="1")
{
$was_skipped=1;
}

$_SESSION['answeredSoFar'][]=array("question_id"=>$qid,"answer_id"=>$aid);
   if($skipped=="1" || $skipped==1 )
   {
//$_SESSION['skipped'][]=$qid;  
$skipped=$_SESSION['skippedSoFar'];



$key = array_search($qid,$skipped);
if($key!==false){
    unset($skipped[$key]);
}
$_SESSION['skippedSoFar']=$skipped;



	}
  //$key = array_search($needle,$array);
//if($key!==false){
   // unset($array[$key]);
    return true;
      
   }

   function getSameExamQuestion($p_id,$q_id)
   {
  $qry="SELECT * FROM question_paper_question qpq WHERE qpq.question_paper_id=$p_id AND qpq.question_id = $q_id order by rand() limit 1 ";
   $result=mysql_query($qry) or die(mysql_error());
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
  
  
  
  
  function addQuestionToSkipped($qid)
  {
 $_SESSION['skippedSoFar'][]=$qid;

  return true;
  
  
  
  } 





function getSkippedQuestion()
{

 //$qry="SELECT * FROM skipped_questions WHERE paper_id=$p_id AND student_id=$s_id limit 1";
$qss=$_SESSION['skippedSoFar'];
$rq=$qss[array_rand($qss)];
$_SESSION['skippedSoFar']=$qss;
   $ans= array();
 
   if($rq!="")
    {
    $qry2="SELECT * FROM answers a WHERE a.question_id=".$rq ;
      $result2=mysql_query($qry2) or die(mysql_error()) ;
     
      if(mysql_num_rows($result2)> 0)
      { 
      
         $row2=mysql_fetch_array($result2);
       
        $ans[1]=$row2['ans1'];
		$ans[2]=$row2['ans2'];
		$ans[3]=$row2['ans3'];
		$ans[4]=$row2['ans4'];
       
    $qs=$this->getQuestion($rq);
    $qans= array('question_id'=>$rq,'question'=>$qs,"answers"=>$ans);
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
 

function getAttemptedQuestions()
{
return $_SESSION['answeredSoFar'];
}


function getSkippedQuestions()
{

return $_SESSION['skippedSoFar'];

}
   
  



function getReviewedQuestions()
{
$asf=$_SESSION['answeredSoFar'];
$qs=array();

foreach($asf as $row)
{
$qs[]=$row['question_id'];
}
return $qs;
}
  




function getAttemptedQuestionForReview()
{

$attempted=$_SESSION['answeredSoFar'];

  $already=array();
 $i=0;
 foreach($attempted as $qss)
 {
  $already[$i++]=$qid['question_id'];
 }


$additional="";
if(count($already) > 0)
{
$sqs=implode(",",$already);
$additional=" ( sqa.id NOT IN (".$sqs.")) AND ";
}

echo $qry="SELECT q.id,q.question,sqa.answer_id FROM student_question_answer sqa,question q where ".$additional." paper_id=$paper_id AND student_id=$student_id AND sqa.question_id=q.question_id order by date_inserted limit 1 ";
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
 
 
function getRightAnswer($qid)
{
$qry="SELECT * FROM right_answers WHERE question=".$qid;
$result=mysql_query($qry);
$row= mysql_fetch_array($result);
return $row['answer'];
}
    

function getRightAnswers()
{
$qs=$_SESSION['answeredSoFar'];
$i=0;
$html="";
foreach($qs as $qw)
{
$q=$qw['question_id'];
$w=$qw['answer_id'];
$html.= "<p class='question'>".$question=$this->getQuestion($q)."</p>";
$answer=$this->getRightAnswer($q);
$html.= "<br>";
//echo $this->getQuestion($question);


	if($w==$answer)
	{
$html.= "<img src='images/correct.png' />";
	++$i;

}else
{
$html.= "<img src='images/wrong.png' />";



}
$html.= "<span class='green'>".$this->getAnswer($q,$w)."</span>";
$html.= "<br>";
$html.="<br>";
}

echo "<h4>You Got ".$i." Out of ".$_SESSION['total']."</h4>";
echo $html;
}
	
	function getAnswer($q,$key)
	{
	
		 $qry="select ans".$key." from answers where question_id=".$q;
		
			$result=mysql_query($qry) ;
			//var_dump(mysql_fetch_array($result));
			$ansr=mysql_fetch_array($result);
			 
		
	
	return $ansr[0];
	//$rows=mysql_fetch_array($result);
	}
	
	
	function smartdate($timestamp) {
	$diff = time() - $timestamp;
 
	if ($diff <= 0) {
		return '0 second(s) ago';
	}
	else if ($diff < 60) {
		return $this->grammar_date(floor($diff), ' second(s) ago');
	}
	else if ($diff < 60*60) {
		return $this->grammar_date(floor($diff/60), ' minute(s) ago');
	}
	else if ($diff < 60*60*24) {
		return $this->grammar_date(floor($diff/(60*60)), ' hour(s) ago');
	}
	else if ($diff < 60*60*24*30) {
		return $this->grammar_date(floor($diff/(60*60*24)), ' day(s) ago');
	}
	else if ($diff < 60*60*24*30*12) {
		return $this->grammar_date(floor($diff/(60*60*24*30)), ' month(s) ago');
	}
	else {
		return $this->grammar_date(floor($diff/(60*60*24*30*12)), ' year(s) ago');
	}
}
 
 
function grammar_date($val, $sentence) {
	if ($val > 1) {
		return $val.str_replace('(s)', 's', $sentence);
	} else {
		return $val.str_replace('(s)', '', $sentence);
	}
}
	
}   
   
?>