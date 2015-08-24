<!DOCTYPE html>
<html>
 <head>
  <title>Admin Panel</title>
 </head>
 <body>
<?php
session_start();

print "<pre>".print_r($_SESSION, true)."</pre>";
//print "<pre>".print_r($_SESSION["game"]["data"]["letters"], true)."</pre>";
//echo count($_SESSION["game"]["data"]["used_words"]);
?>
<style scoped>
body{
	color: #fff;
	background-color: #000;
}
</style>

 </body>
</html>