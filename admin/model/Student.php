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
$qry="select * from student order by student_id DESC ";
$result=mysql_query($qry);
 while($row=mysql_fetch_array($result))
{
echo "<tr><td> </td><td>".$i++." </td> <td>".$row['student_id']." </td> <td><a href='student.php?action=view&id="
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
echo "<tr><td>Student Id </td><td>".$row['student_id']." </td></tr><tr><td>Student Name </td> <td>".$row['student_name']." </td></tr><tr><td>Fathers Name </td><td>".$row['fathers_name']." </td></tr><tr><td>Roll Number </td><td>".$row['roll_number']." </td></tr><tr><td>Admission Date </td><td>".$row['enrollment_date']." </td> </tr><tr><td>Class </td> <td>".$this->getClassName($row['student_id'])." </td> </tr>";
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

function assignClass($id,$class)
{
$qry="insert into student_class(student_id,class_id) values($id,$class)" ;
mysql_query($qry) or die(mysql_error());


}
function getClassName($id)
{
$qry="SELECT * FROM class as c,student_class as sc WHERE c.class_id=sc.class_id AND sc.student_id=$id LIMIT 0,1" ;
$row=mysql_query($qry) or die(mysql_error());
if(mysql_num_rows($row) > 0)
{

$rec=mysql_fetch_array($row);
return $rec['class_name']." ".$rec['current_year'];
}
else
{
return "";
}
}

}
?>