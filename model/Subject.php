<?php
include("OLE.php");
class Subject extends OLE {

    
    function __construct()
    {
    OLE::connect();
    }
    
    function getAllSubjects(){
    $i=1;
    $qry="select * from subject";
    $result=mysql_query($qry) or die(mysql_error());
    while ($row=mysql_fetch_array($result))
    {
    echo "<tr><td>".$i++." </td> <td>".$row['subject_name']." </td><td><a href='#'>Edit</a> </td><td><a href='subject.php?action=delete&id=".$row['subject_id']."'>Delete</a> </td></tr>";
    
    }
    }
    
    public function  insertSubject($subject_name)
    {
    $sql="INSERT INTO subject(subject_name) values('$subject_name')";
    mysql_query($sql);
    return true;
    }
    
    
   
    
    
    public function deleteSubject($id)
    {
    
    $sql="delete from subject where subject_id=$id";
    mysql_query($sql);
    return true;
    }
     
    }
?>