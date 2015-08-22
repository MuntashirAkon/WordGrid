<?php
require_once __DIR__ . "/functions.php";
session_start();

if(isset($_SESSION["game"]["start"]) && $_GET["game"]!=="quit"){
	$req_dir = "start";
}else if(isset($_GET["game"])){
	$req_dir = $_GET["game"];
}else{
	header("Location: ../index.php");
}

if($req_dir==="start"){
	if(!isset($_SESSION["game"]["start"])) $_SESSION["game"]["start"] = true;
	require_once __DIR__ . "/play_game.php";
} else if($req_dir==="help"){?>
 <style>
  .page{background-image: url('images/help.bmp');}
 </style>
<?php
}else if($req_dir==="quit"){
	session_destroy();
	echo "<script>window.location.assign('about:blank')</script>";
	exit();
}else{
	header("Location: ../index.php");
}
