<?php
include("model/OLE.php");
$exam= new OLE();
$exam->cancelPaper();
header("location:index.php");
?>