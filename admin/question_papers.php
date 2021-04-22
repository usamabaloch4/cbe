<?php
include("model/QuestionPaper.php");
$sub=new QuestionPaper();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf8">
 <link rel="stylesheet" href="view/css/styles.css">
 <link rel="stylesheet" href="../css/calendarview.css">


<link href="view/css/styles.css" type="text/css" rel="stylesheet">
 <style>
      body {
        font-family: Trebuchet MS;
      }
      div.calendar {
        max-width: 240px;
        margin-left: auto;
        margin-right: auto;
      }
      div.calendar table {
        width: 100%;
      }
      div.dateField {
        width: 140px;
        padding: 6px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        color: #555;
        background-color: white;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
      }
      div#popupDateField:hover {
        background-color: #cde;
        cursor: pointer;
      }
    </style>
 
<script src="../js/prototype.js"></script>
<script src="../js/effects.js"></script>
<script src="../js/dragdrop.js"></script>
    <script src="../js/calendarview.js"></script>
  <script>
      function setupCalendars() {
        // Embedded Calendar
        Calendar.setup(
          {
            dateField: 'embeddedDateField',
            parentElement: 'embeddedCalendar'
          }
        )

        // Popup Calendar
        Calendar.setup(
          {
            dateField: 'popupDateField',
            triggerElement: 'popupDateField'
          }
        )
     
     
      }

      Event.observe(window, 'load', function() { setupCalendars()
           new Draggable("myCal");  
      
       })
      
      
      
    </script>
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php include("view/main_navigation.php") ?> </div>
<div class="main">
<br><br><br>
 
<form action="question_paper.php?action=insert" method="post">

<table width="600" align="center" class="formTable" >
<tr >
  <td width="169" class="first">&nbsp;</td>
  <td width="419" class="first"><h4>Insert Question Paper</h4></td>
</tr>
<tr > <td class="first"> Select Teacher</td> <td class="first"><select name="teacher" id="teacher">
<option value="">--- Please Select a Teacher</option>
<?php echo $sub->getTeachersDropDown() ?>
</select> </td> </tr>
<tr> <td>Select Subject </td> <td><select name="subject">
<option value="">--- Please Select a Subject</option>
<?php echo $sub->getSubjectsDropDown() ?>
</select> </td> </tr>
<tr> <td> Select Class</td> <td>       
<select name="class">
<option value="">--- Please Select a Class</option>
<?php echo $sub->getClassDropDown() ?>
</select></td> </tr>
<tr> <td>Number Of Questions </td> <td><input type="text" name="qnums"> </td> </tr>
<tr> <td>Question Paper Date </td> <td>  <input type="text" id="embeddedDateField" name="question_paper_date" class="dateField"></td> </tr>
<tr> <td>Time Allowed </td> <td> HH <input name="chours" type="text" style="width:50px !important" class="dateField" id="embeddedDateField2" size="10" maxlength="10">
 MM <input type="text" id="cminuts" name="cminutes" style="width:50px !important" class="dateField"></td> </tr>
<tr> <td class="last"> </td> <td class="last"><input type="submit" value="Add New QuestionPaper"> </td> </tr>
</table>

 

</form>



<table width="100%">
<tr>
    <td>#</td>
    <td>ID</td><td class="bold">Teacher</td><td class="bold">Class</td><td class="bold">Subject</td><td class="bold">Paper Date</td> <td class="bold">Paper Duration</td><td class="bold">Ready </td><td class="bold">View Question Paper</td><td class="bold">Insert Questions</td><td> Status </td><td class="bold">Delete</td>
      </tr>

<?php
 $sub->getAllQuestionPapers(); 

 ?>
</table>
  <br><br><br><br>




     
   <div style="width:265px;display:none;" id="myCal" >
      <div style="height: 200px; background-color: #efefef; padding: 10px; -webkit-border-radius: 12px; -moz-border-radius: 12px; margin-right: 10px">
             <div id="embeddedExample" style="">
          <div id="embeddedCalendar" style="margin-left: auto; margin-right: auto">
          </div>
          <br />
          
       
          <br />
        </div>
      </div>
    </div>
  

   <script>
 
 function findTopPos(id) {
    var node = document.getElementById(id); 	
    var curtop = 0;
    var curtopscroll = 0;
    if (node.offsetParent) {
        do {
            curtop += node.offsetTop;
            curtopscroll += node.offsetParent ? node.offsetParent.scrollTop : 0;
        } while (node = node.offsetParent);

       return(curtop - curtopscroll);
    }
}
 
 
 function findLeftPos(id) {
    var node = document.getElementById(id); 	
    var curleft = 0;
    var curleftscroll = 0;
    if (node.offsetParent) {
        do {
            curleft += node.offsetLeft;
            curleftscroll += node.offsetParent ? node.offsetParent.scrollLeft : 0;
        } while (node = node.offsetParent);

       return(curleft - curleftscroll);
    }
}
 
 
 
 
   $("embeddedDateField").observe("focus",function()
      {
       
var currTopPos=findTopPos("embeddedDateField");
var currLeftPos=findLeftPos("embeddedDateField");
//alert(currpos);
$("myCal").setStyle({top:(currTopPos-9)+"px",left:(currLeftPos+200)+"px"});
        $("myCal").appear();
      
      });
     
$("embeddedDateField").observe("blur",function()
      {
     //  $("myCal").fade();
      
      });     
   
   </script>
</div>
</div>
</body>
</html>