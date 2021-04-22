<?php
include("OLE.php");
class Result extends OLE {

    
    function __construct()
    {
    OLE::connect();
    }
    
   
   function getLatestResults()
   {
   
    $str="<tr><td>#  </td><td class='bold'> Teacher </td><td class='bold'>Subject </td>  <td class='bold'>Date </td><td class='bold'> View Paper  </td> <td class='bold'> Results  </td><td class='bold'> Statistics  </td>";
  
   $qry="SELECT qp.question_paper_id FROM question_paper qp,student_question_answer sqa WHERE qp.question_paper_id=sqa.paper_id group by sqa.paper_id ";
   $result=mysql_query($qry);
   
   while($row=mysql_fetch_array($result))
   {
   
  $str.= $this->getResultByPaper($row[0]);
   
   }
   
   return $str;
   }
   
   
 function loadResult($pid)
 {
 $sql="SELECT sqa.paper_id,sqa.student_id,s.student_name,s.roll_number FROM student_question_answer sqa,student s WHERE sqa.paper_id=$pid AND sqa.student_id=s.student_id  GROUP BY sqa.student_id";
$result=mysql_query($sql);
$html="";
while($row=mysql_fetch_array($result))
{
$corrected=$this->loadStudentResult($row['paper_id'],$row['student_id']);
//$html.="<tr><td>". $row['student_name']."</td> <td>". $row['roll_number']."</td> <td>".$corrected."</td><td><a href='result.php?action=student_paper_detail&student_id=".$row['student_id']."&paper_id=$pid'> Detail </a></td></tr>";
$pct=$this->getPaperCompletionTime($row['student_id'],$row['paper_id']);
$st=$pct['start_time'];
$et=$pct['end_time'];
$start_date = new DateTime($st);
$since_start = $start_date->diff(new DateTime($et));
 $time=$since_start->h.":".$since_start->i.":".$since_start->s;
$html.="<tr><td>". $row['student_name']."</td> <td>". $row['roll_number']."</td> <td>".$corrected."</td><td>".$time."</td><td><a href='result.php?action=student_paper_detail&student_id=".$row['student_id']."&paper_id=$pid'> Detail </a></tr>";



}
     
return $html; 
 }  
  
  
  function loadStudentResult($pid,$sid) 
  {
  $qry="SELECT count(ca.answer_id) FROM student_question_answer sqa,correct_answer ca WHERE sqa.paper_id=$pid AND sqa.student_id=$sid AND sqa.question_id=ca.question_id AND sqa.answer_id=ca.answer_id";
  $result=mysql_query($qry);
  $row=mysql_fetch_row($result);
  return $row[0];
  
  
  }
   
   
    function getResultByPaper($paper_id){
    $i=1;
  $str=""; 
    $qry="select q.*,t.teacher_name,s.subject_name from question_paper q,teacher t,subject s WHERE q.question_paper_id=$paper_id AND q.teacher_id=t.teacher_id AND q.subject_id=s.subject_id";
    $result=mysql_query($qry) or die(mysql_error());
    $status="";
    $link="";
    while ($row=mysql_fetch_array($result))
    {
    
    $status="Complete";
    $link="result.php?action=view_result&paper_id=".$row['question_paper_id'];
    
    $str.= "<tr><td height='30'>".$i++." </td><td>".ucfirst($row['teacher_name'])." </td><td>".ucfirst($row['subject_name'])." </td><td>".$row['question_paper_date']." </td><td><a href='question_paper.php?action=view_paper&id=".$row['question_paper_id']."'>View Question Paper</a> </td><td><a href='".$link."' class='".$status."'>View Result</a> </td><td><a href='result.php?action=paper_statistics&paper_id=$paper_id'>Statistics </a> </td></tr>";
    
    }
   
   return $str;
    }
    
   
    
    
   
    
    
    
    function viewQuestionPaper($id){
    $i=1;
    $qry="SELECT * FROM question q,question_paper_question qp WHERE q.question_id=qp.question_id AND qp.question_paper_id=$id";
    $result=mysql_query($qry) or die(mysql_error());
    while ($row=mysql_fetch_array($result))
    {
    echo "<tr><td width='50'>".$i++." </td> <td>".ucfirst($row['question'])." </td><td><a href='http://localhost/test/question.php?action=view&id=".$row['question_id']."&subid=".$row['subject_id']."' target='_blank'>view </a></td><td><a href='http://localhost/test/question_paper.php?action=delete_question&id=".$row['question_id']."&paper_id=".$id."' >Delete </a> </td></tr>";
    
    }
    } 


 function showSubjectQuestions($pid){
   $result=mysql_query("SELECT * FROM question_paper WHERE question_paper_id=$pid");
   $row=mysql_fetch_array($result);
   $sub_id=$row['subject_id'];
   $qnums=$row['number_of_questions']; 
   echo "<tr><td height='100'><script type='text/javascript'> var total=".($qnums-$this->getInsertedQuestions($pid))." </script> </td><td> </td><td><strong>Number Of questions ".$qnums."</strong> | Questions already added:".$this->getInsertedQuestions($pid)." <div id='qadded' style='position:fixed;right:-10px;padding-right:20px'>Questions Added <div id='qnum'>0 </div> </div> </td> </tr>";
   
   if($this->getInsertedQuestions($pid) > 0 )
   {


    $i=1;
    //$qry="SELECT * FROM question q,question_paper_question qp WHERE q.subject_id=$sub_id AND q.question_id NOT IN qp.question_id";
    
   $qry="SELECT *
FROM question q
WHERE q.subject_id =$sub_id
AND q.question_id NOT
IN (

SELECT qp.question_id
FROM question_paper_question qp
WHERE qp.`question_paper_id` =$pid
)

";
    
    $result=mysql_query($qry) or die(mysql_error());
    while ($row=mysql_fetch_array($result))
    {
    echo "<tr><td width='50'>".$i++." </td><td><input type='checkbox' name='questions[]' value='".$row['question_id']."' onclick='addquestion(this)' > </td> <td><a href='http://localhost/test/question.php?action=view&id=".$row['question_id']."&subid=".$row['subject_id']."'>".ucfirst($row['question'])." </td></tr>";
    
    }

 
  
   }else
   {
   
    $i=1;
    $qry="SELECT * FROM question q WHERE q.subject_id=$sub_id";
    $result=mysql_query($qry) or die(mysql_error());
    while ($row=mysql_fetch_array($result))
    {
    echo "<tr><td width='50'>".$i++." </td><td><input type='checkbox' name='questions[]' value='".$row['question_id']."' onclick='addquestion(this)' > </td> <td><a href='http://localhost/test/question.php?action=view&id=".$row['question_id']."&subid=".$row['subject_id']."'>".ucfirst($row['question'])." </td></tr>";
    
    }
    }
    } 

    function insertSelectedQuestion($pid,$qs)
    {
   
      foreach($qs as $q)
      {
    $qry="INSERT INTO question_paper_question(question_paper_id,question_id) values($pid,$q)";
      mysql_query($qry);
      }
    
    }
     
     
function deleteQuestion($qid)
{
$qry="DELETE FROM question_paper_question WHERE question_id=$qid";
mysql_query($qry);
}     

function getInsertedQuestions($pid)
{
$qry="SELECT count( question_id )
FROM `question_paper_question`
WHERE `question_paper_id` =$pid";

$result=mysql_query($qry);
$row=mysql_fetch_row($result);
return $row[0];


}


function showDetailedStudentResult($student_id,$paper_id)
{

$answer="";
$str="";
$i=1;
$result=mysql_query("SELECT * FROM student_question_answer WHERE student_id=$student_id AND paper_id=$paper_id");
if(mysql_num_rows($result) > 0)
{
while($rs=mysql_fetch_array($result))
{

if($this->isCorrectAnswer($rs['question_id'],$rs['answer_id']))
{
$answer=" <img src='../images/correct.png' > ";
}
else
{
$answer=" <img src='../images/wrong.png' > ";
}
$str.="<tr><td height='25'>".$i." </td> <td><a target='_blank' href='question.php?action=view&id=".$rs['question_id']. "&subid=0'> ".$this->getQuestion($rs['question_id'])."</a></td> <td> ".$answer."</td></tr>";

$i++;
}

return $str;

}


//echo $date = date_create(date("h:i:s",$st_time));




}


function getPaperCompletionTime($student_id,$paper_id)
{
$sql="SELECT * FROM paper_status WHERE student_id=$student_id AND paper_id=$paper_id";
$result=mysql_query($sql) or die();
$row=mysql_fetch_array($result);
return $row;
}


function getPaperCompletionTimeByPaper($paper_id)
{
$sql="SELECT * FROM paper_status WHERE paper_id=$paper_id AND status=2 GROUP BY student_id,paper_id";
$result=mysql_query($sql) or die();
$time_array=array();
$i=0;
while($row=mysql_fetch_array($result))
{
$st=$row['start_time'];
$et=$row['end_time'];
$start_date = new DateTime($st);
$since_start = $start_date->diff(new DateTime($et));
$time=$since_start->h.":".$since_start->i.":".$since_start->s;	
$time_array[$i++]=$time;

}

return date('H:i:s', array_sum(array_map('strtotime', $time_array)) / count($time_array));


}

function showResultStatistics($paper_id)
{
$avg_time=$this->getPaperCompletionTimeByPaper($paper_id);
$top_students=$this->getPaperStudentsStatistics($paper_id);
$student_appeared=$this->studentAppearedInPaper($paper_id);

$str="<tr><td width='120' class='bold'> Student Appeared   </td><td> ".$student_appeared." </td></tr>";
$str.="<tr><td class='bold'>Top Students </td><td> ".$top_students['top']." </td></tr>";
$str.="<tr><td class='bold'>Avg Marks </td><td> ".number_format($top_students['avg'],2)." </td></tr>";
$str.="<tr><td class='bold'> Avg Time  </td><td > ".$avg_time." </td></tr>";


return $str;
}


function studentAppearedInPaper($paper_id)
{
$rs1=mysql_query("SELECT count(distinct(student_id)) FROM paper_status WHERE paper_id=$paper_id AND status=2") or die(mysql_error());
$row1=mysql_fetch_row($rs1);
$appeared=$row1[0];
return $appeared;
}

function getQuestion($question_id)
{
$rs1=mysql_query("SELECT question FROM question WHERE question_id=$question_id") or die(mysql_error());
$row1=mysql_fetch_row($rs1);
$appeared=$row1[0];
return $appeared;
}



function getPaperStudentsStatistics($paper_id)
{

$st_results=array();
$i=0;
$str="";
$result=mysql_query("SELECT * FROM paper_status WHERE paper_id=$paper_id AND status=2");

while($rs=mysql_fetch_array($result))
{

$corrected=$this->loadStudentResult($rs['paper_id'],$rs['student_id']);
$st_results[$rs['student_id']]=$corrected;
}

arsort($st_results);

$marks=0;
foreach($st_results as $key=>$val)
{
$i++;
$marks+=$val;
if($i==1)
{
$str.="First Position : ".ucwords($this->getStudentById($key))." Marks ,  ".$val;
}
if($i==2)
{
$str.=" ; Second Position : ".ucwords($this->getStudentById($key))." Marks , ".$val;
}
if($i==3)
{
$str.=" ; Third Position : ".ucwords($this->getStudentById($key))." Marks , ".$val;
}



}
$avg_marks=($marks/(count($st_results)));
$return_array= array("top"=>$str,"avg"=>$avg_marks);

//$html.= $str."</td> </tr> <tr><td> Avg Marks</td><td>".($marks/(count($st_results)))."</td></tr></table>";

//$str="First " $st_results[0];

//print_r($new_array);
return $return_array;
}


function getStudentById($student_id)
{
$result=mysql_query("SELECT * FROM student WHERE student_id=$student_id") or die(mysql_error());
$row=mysql_fetch_array($result);
return $row['student_name'];


}



function isCorrectAnswer($question_id,$anwer_id)
{

$result=mysql_query("SELECT * FROM correct_answer WHERE question_id=$question_id AND answer_id=$anwer_id");
if(mysql_num_rows($result) > 0)
return true;
else
return false;
}



     
    }
?>