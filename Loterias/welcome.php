<?php

include('lock.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="/cssmenu/styles.css">
<!--   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script> -->
   <script src="/cssmenu/jquery-latest.min.js" type="text/javascript"></script> 
   <script src="/cssmenu/script.js"></script>
<title>Welcome </title>
</head>

<body>

<div id='cssmenu'>
<ul>
   <li class='active'><a href='#'>Home</a></li>
   <li><a href='#'>Products</a></li>
   <li><a href='#'>Company</a></li>
   <li><a href='#'>Contact</a></li>
   <li><a href='logout.php'>Logout</a></li>
</ul>
</div>

<h1>Welcome <?php echo $login_session; ?></h1> 
<h2><a href="http://onlinewebapplication.com">onlinewebapplication.com</a></h2>

<h2><a href="logout.php">Sign Out</a></h2>

</body>
</html>
