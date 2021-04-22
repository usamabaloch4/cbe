<?php
 session_start();
 if(isset($_SESSION['login']) && $_SESSION['login']==true): ?>
<html>
<head>
<link href="view/css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
<div class="header"><span style="font-size:12px;font-weight:bold">Welcome Admin </span> <a href="logout.php">Logout </a> </div>
<div class="left"><?php echo include("view/main_navigation.php"); ?>
 </div>
<div class="main"><h1 style="font-size:30">Online Examination System Administration Panel </h1>
</div> 
</body>
</html>
<?php else : ?>
<?php header("location:index.php?error=2"); ?>
<?php endif; ?>