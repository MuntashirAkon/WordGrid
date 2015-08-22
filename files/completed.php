<?php
session_start();

if(isset($_REQUEST["task"])){
	$task = $_REQUEST["task"];
}else{
	$task = "";
}
if($task === "completed"){
	$_SESSION['game']['task'] = "completed";
	$_SESSION['game']['start'] = false;
}else{
	$_SESSION['game']['task'] = false;
	session_destroy();
	header("Location: ../index.php");
}
if($_SESSION['game']['task'] === "completed"){
	echo "<div style='margin:10em auto;width:30em;'>";
	if($_SESSION['game']['player1']['points'] > $_SESSION['game']['player2']['points']) echo "<h1>".$_SESSION['game']['player1']['name']." wins!</h1>";
	if($_SESSION['game']['player2']['points'] > $_SESSION['game']['player1']['points']) echo "<h1>".$_SESSION['game']['player2']['name']." wins!</h1>";
	if($_SESSION['game']['player1']['points'] === $_SESSION['game']['player2']['points']) echo "<h1 style='text-align:center;'>Draw Match :)</h1>";
	echo "<table style='width:30em'>";
	echo "<tr>";
	echo "<th>Name</th>";
	echo "<td>".$_SESSION['game']['player1']['name']."</td>";
	echo "<td>".$_SESSION['game']['player2']['name']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Sex</th>";
	echo "<td>".$_SESSION['game']['player1']['sex']."</td>";
	echo "<td>".$_SESSION['game']['player2']['sex']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Points</th>";
	echo "<td>".$_SESSION['game']['player1']['points']."</td>";
	echo "<td>".$_SESSION['game']['player2']['points']."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Used words</th>";
	echo "<td colspan='2'>";
	for($i=0;$i<count($_SESSION['game']['data']['used_words'])-1;$i++){
		echo $_SESSION['game']['data']['used_words'][$i].", ";
	}
	echo $_SESSION['game']['data']['used_words'][$i].".";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<a href='/completed.php?task=0'>play again</a>";
}else{
	include "../404error.php";
}
