<?php
include("model/OLE.php");

class Question extends OLE  
{

public $question;

function Question()
{
OLE::connect();
}

 /* this method will list all available questions */
function getAllQuestions()
{
 $i=1;                      
$qry="select * from question q,subject s WHERE q.subject_id=s.subject_id order by q.subject_id";
$result=mysql_query($qry);
 while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$i++." </td> <td><a href='question.php?action=view&id="
    .$row['question_id']."&subid=".$row['subject_id']."'>".ucfirst($row['question'])."</a> </td> <td>".ucwords($row['subject_name'])." </td>
    <td><a href='#'> Edit</a> </td> 
    <td><a href=question.php?action=delete&id=".$row['question_id'].">Delete </a> </td>
     </tr>";

}
}
/* this method will show single question */
function getQuestion($id)
{

$qry="select * from question q WHERE q.question_id=".$id;
$result=mysql_query($qry);
$row=mysql_fetch_array($result);
return $row; 
}


function getQuestionAnswers($id)
{

 $qry="select a.answer_id,a.answer,ca.answer_id as correct from answer a,correct_answer ca WHERE a.question_id=ca.question_id AND a.question_id=".$id;
$result=mysql_query($qry);
while($row=mysql_fetch_array($result))
{
if($row['answer_id']==$row['correct'] )
{
echo "<li class='correctans' >".ucfirst($row['answer'])." </li>";
}else
{
echo "<li >".ucfirst($row['answer'])." </li>";
}
}

}


/* this method will delete question */

function deleteQuestion($id)
{
$qry="delete from question where question_id=$id";
mysql_query($qry);
$qry1="delete from answer where question_id=$id";
mysql_query($qry1);
$qry2="delete from correct_answer where question_id=$id";
mysql_query($qry2);
return true;
}
 /* this method will add question */
function insertQuestion($question,$subject,$answer,$correct_answer) 
{

 $question=$question;
$qry="insert into question(question,subject_id) values('$question',$subject)";
$result=mysql_query($qry) or die(mysql_error());
$last_id=mysql_insert_id();
$i=0;
$answer_id;
foreach($answer as $ans)
{
$qry="insert into answer(question_id,answer) value($last_id,'$ans')";
mysql_query($qry);
if($i==$correct_answer)
{
$answer_id=mysql_insert_id();
}
$i++;

}
$qry="INSERT INTO correct_answer(question_id,answer_id) value($last_id,$answer_id)";
mysql_query($qry);

}

}
?>