<?php
   class OLE
{
public static function connect()
{
$con=mysql_connect("localhost","root","");
mysql_select_db("ble");
}

 public static function getSubject($id)
    {
    $result=mysql_query("SELECT * FROM subject where subject_id=".$id) or die(mysql_error());
    $row=mysql_fetch_array($result);
    return $row;
    
    }


    public static function getSubjectsDropDown()
    {
    $result=mysql_query("SELECT * FROM subject");
    while($row=mysql_fetch_array($result))
    {
    echo "<option value='".$row['subject_id']."'> ".ucwords($row['subject_name'])."</option>";
    }
    
    
    
    }


 public static function getTeachersDropDown()
    {
    $result=mysql_query("SELECT * FROM teacher");
    while($row=mysql_fetch_array($result))
    {
    echo "<option value='".$row['teacher_id']."'> ".ucwords($row['teacher_name'])."</option>";
    }
    
    
    
    }

    public static function getClassDropDown()
    {
    $result=mysql_query("SELECT * FROM class");
    while($row=mysql_fetch_array($result))
    {
    echo "<option value='".$row['class_id']."'> ".ucwords($row['class_name'])." - ".$row['current_year']."</option>";
    }
    
    
    
    }



    function login($user,$pw)
    {
    $this::connect();
    $qry="SELECT count(*) FROM user WHERE user_name='$user' AND user_password='$pw'";
    $result=mysql_query($qry);
    $row=mysql_fetch_row($result);
    if($row[0] > 0)
    {
    return true;
    }else
    {
    return false;
    }
    
    }


}   
   
?>