<?php
include("model/OLE.php");
class Classes extends OLE  
{

function Classes()
{
OLE::connect();
}
 /* this method will list all available classs */

function getAllClasss()
{

 $i=1;                         
$qry="select * from class ";
$result=mysql_query($qry);
 while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$i++." </td> <td>".$row['class_name']."</td><td>".$row['current_year']."</a> </td><td><a href='#'> Edit</a> </td> 
    <td><a href=class.php?action=delete&id=".$row['class_id'].">Delete </a> </td> </tr>";

}
}
 /* this method will show single class */
 
function getClass($id)
{
$qry="select * from class WHERE class_id=".$id;
$result=mysql_query($qry);

while($row=mysql_fetch_array($result))
{
echo "<tr><td>".$row['class_id']." </td> <td>".$row['class_name']." </td><td>".$row['fathers_name']." </td> </tr>";
}

}


     /* this method will delete class */

function deleteClass($id)
{
$qry="delete from class where class_id=$id";
mysql_query($qry);
return true;
}
 /* this method will add class */
function insertClass($name,$cyear)
{
$qry="insert into class(class_name,current_year) values('$name','$cyear')";
mysql_query($qry);
}

}
?>