<?php
include("OLE.php");
class QuestionPaper extends OLE {

    
    function __construct()
    {
    OLE::connect();
    }
    
    function getAllQuestionPapers(){
    $i=1;
    $qry="select q.*,t.teacher_name,s.subject_name,c.class_name,c.current_year from question_paper q,teacher t,subject s,class c WHERE q.teacher_id=t.teacher_id AND q.subject_id=s.subject_id AND q.class_id=c.class_id";
    $result=mysql_query($qry) or die(mysql_error());
    $status="";
	$enable=0;
    $link="";
$link2="";

    while ($row=mysql_fetch_array($result))
    {
    if($row['number_of_questions']==$this->getInsertedQuestions($row['question_paper_id']))
    {
    $status="Yes";
    $link="#";
      }else
    {
    $status="No";
    $link="question_paper.php?action=insert_questions&id=".$row['question_paper_id'];
    }
	
	
	
	if($row['status']==0 || $row['status']=="")
    {
    $enable="De Active";
$link2="question_paper.php?action=active&id=".$row['question_paper_id']."&status=1";      }
else
    {
    $enable="Active";
    $link2="question_paper.php?action=active&id=".$row['question_paper_id']."&status=0";
    }
	
	
	
	
	
    echo "<tr><td>".$i++." </td> <td>".$row['question_paper_id']." </td><td>".ucfirst($row['teacher_name'])." </td><td>".$row['class_name']." ".$row['current_year']."</td><td>".ucfirst($row['subject_name'])." </td><td>".$row['question_paper_date']." </td><td>".$row['time_hours'].":".$row['time_minutes']." </td><td>".$status."</td><td><a href='question_paper.php?action=view_paper&id=".$row['question_paper_id']."'>View Question Paper</a> </td><td><a href='".$link."' class='".$status."'>Insert Questions</a> </td><td><a href='".$link2."'> ".$enable." </a></td><td><a href='question_paper.php?action=delete&id=".$row['question_paper_id']."'>Delete</a> </td></tr>";
    
    }
    }
	
	public function activeQuestionPaper($qp_id,$status)
	{
	
	
	$sql="UPDATE question_paper set status=$status WHERE question_paper_id=$qp_id";
	mysql_query($sql) or die(mysql_error()) ;
	return true;
	
	}
	
	
    public function  insertQuestionPaper($teacher_id,$subject_id,$qnum,$class,$hh,$mm,$question_paper_date)
    {
  $sql="INSERT INTO question_paper(teacher_id,subject_id,number_of_questions,class_id,question_paper_date,time_hours,time_minutes,date_created) values($teacher_id,$subject_id,$qnum,$class,'$question_paper_date',$hh,$mm,NOW())";
    mysql_query($sql) or die(mysql_error());
    return mysql_insert_id();
    }
    
    
   
    
    
    public function deleteQuestionPaper($id)
    {
    
    $sql="delete from question_paper where question_paper_id=$id";
    mysql_query($sql);
    $sql2="delete from question_paper_question where question_paper_id=$id";
    mysql_query($sql2);

    
    return true;
    
    
    
    }
     
    function addRandomQuestions($qp_id)
    {
   $result=mysql_query("SELECT * FROM question_paper WHERE question_paper_id=$qp_id");
   $row=mysql_fetch_array($result);
   $sub_id=$row['subject_id'];
   $qnums=$row['number_of_questions'];
   
   $qry2="SELECT * FROM `question`  WHERE `subject_id`=$sub_id ORDER BY RAND() LIMIT $qnums";
   $result2=mysql_query($qry2) or die(mysql_error());
   
   while($row2=mysql_fetch_array($result2) )
   {
     mysql_query("INSERT INTO question_paper_question (question_paper_id,question_id) values($qp_id,".$row2['question_id'].")")or die(mysql_error());
   
   }
   
    }
    
    function viewQuestionPaper($id){
    $i=1;
    $qry="SELECT * FROM question q,question_paper_question qp WHERE q.question_id=qp.question_id AND qp.question_paper_id=$id";
    $result=mysql_query($qry) or die(mysql_error());
    while ($row=mysql_fetch_array($result))
    {
    echo "<tr><td width='50'>".$i++." </td> <td>".ucfirst($row['question'])." </td><td><a href=question.php?action=view&id=".$row['question_id']."&subid=".$row['subject_id']." target='_blank'>view </a></td><td><a href='http://localhost/test/question_paper.php?action=delete_question&id=".$row['question_id']."&paper_id=".$id."' >Delete </a> </td></tr>";
    
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

     
    }
?>