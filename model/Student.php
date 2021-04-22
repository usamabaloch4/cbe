<?php
include("model/OLE.php");

class Student extends OLE  
{

function Student()
{
OLE::connect();
}

 /* this method will list all available students */
function getAllStudents()
{
 $i=1;                      
$qry="select * from student ";
$result=mysql_query($qry);
 while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$i++." </td> <td><a href='student.php?action=view&id="
    .$row['student_id']."'>".$row['student_name']."</a> </td>
    <td><a href='#'> Edit</a> </td> 
    <td><a href=student.php?action=delete&id=".$row['student_id'].">Delete </a> </td>
     </tr>";

}
}
/* this method will show single student */
function getStudent($id)
{

$qry="select * from student WHERE student_id=".$id;
$result=mysql_query($qry);

while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$row['student_id']." </td> <td>".$row['student_name']." </td><td>".$row['fathers_name']." </td><td>".$row['roll_number']." </td><td>".$row['enrollment_date']." </td> </tr>";
}

}
/* this method will delete student */

function deleteStudent($id)
{
$qry="delete from student where student_id=$id";
mysql_query($qry);
return true;
}
 /* this method will add student */
function insertStudent($name,$fname,$roll)
{

$qry="insert into student(student_name,fathers_name,roll_number,enrollment_date) values('$name','$fname','$roll',CURRENT_DATE())" ;
mysql_query($qry);


}

}
?>