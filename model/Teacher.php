<?php
include("model/OLE.php");

class Teacher extends OLE  
{

function Teacher()
{
OLE::connect();
}
 /* this method will list all available teachers */

function getAllTeachers()
{

 $i=1;                         
$qry="select * from teacher ";
$result=mysql_query($qry);
 while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$i++." </td> <td><a href='teacher.php?action=view&id="
    .$row['teacher_id']."'>".$row['teacher_name']."</a> </td><td><a href='#'> Edit</a> </td> 
    <td><a href=teacher.php?action=delete&id=".$row['teacher_id'].">Delete </a> </td> </tr>";

}
}
 /* this method will show single teacher */
 
function getTeacher($id)
{
$qry="select * from teacher WHERE teacher_id=".$id;
$result=mysql_query($qry);

while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$row['teacher_id']." </td> <td>".$row['teacher_name']." </td><td>".$row['fathers_name']." </td> </tr>";
}

}


     /* this method will delete teacher */

function deleteTeacher($id)
{
$qry="delete from teacher where teacher_id=$id";
mysql_query($qry);
return true;
}
 /* this method will add teacher */
function insertTeacher($name,$fname)
{

$qry="insert into teacher(teacher_name,fathers_name) values('$name','$fname')";
mysql_query($qry);


}

}
?>