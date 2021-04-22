<?php
include("model/Question.php");
$q=new Question();


?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php") ?> </div>
<div class="main">
<form action="question.php?action=insert" method="post">
  <br><br>
  <table width="600"  class="table-border">
    <tr>
      <td height="17">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="25" height="29">&nbsp;</td>
      <td colspan="2"><h2>Insert New Question</h2></td>
      </tr>
<tr><td>&nbsp;</td><td width="154">Question</td><td width="305"><input name="question" type="text" size="50"></td> 
</tr>
<tr><td>&nbsp;</td><td width="154">Subject</td><td width="305"><select name="subject" style="width:275px">
  <option value="0">-- Please Select Subject ---</option>
  <?php $q->getSubjectsDropDown(); ?>
</select></td> 
</tr>
<tr><td>&nbsp;</td><td width="154">Answer 1</td><td width="305"><input name="answer[0]" type="text" size="50">
    <input type="radio" name="correct_answer" value="0"></td> 
</tr>
<tr><td>&nbsp;</td><td width="154">Answer 2</td><td width="305"><input name="answer[1]" type="text" size="50">
    <input type="radio" name="correct_answer" value="1"></td> 
</tr>
<tr><td>&nbsp;</td><td width="154">Answer 3</td><td width="305"><input name="answer[2]" type="text" size="50">
    <input type="radio" name="correct_answer" value="2"></td> 
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Answer 4</td>
  <td><input name="answer[3]" type="text" size="50">
    <input type="radio" name="correct_answer" value="3"></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input type="submit" value="Add New Question"></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
  </table>

</form>

<br> <br>

<table width="100%">
<tr><td>Question Id </td> <td> Question Name </td><td>Subject</td><td>Edit</td><td>Delete</td></tr>

<?php
 $q->getAllQuestions(); 

 ?>
</table>


</div>
</div>
</body>
</html>