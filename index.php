<?php
/**
 * WordGrid Game
 *
 * @author Muntashir Al-Islam <muntashir.islam96@gmail.com>
 * @copyright 2012-2015
 */
session_start();
?><!DOCTYPE html>
<html>
<head>
	<title>Word Grid Game</title>
	<script src="js/jquery.min.js"></script>
	<style>
.page{
	width:1000px;
	height:650px;
	margin: 0 auto;
	background-repeat: no-repeat;
}
	</style>
</head>
<body onload="startTime();">
 <div class='page'>
<?php
     if(!isset($_SESSION["game"]["start"])){
         ?>
<style scoped>
.page{
	background-image: url('images/pic3.bmp');
}
nav{
	float: right;
	position: relative;
	top: 5em;
	left: 0;
	width: 210px;
	overflow: hidden;
}
.nav{
	display: block;
	height: 50px;
	margin-bottom: 0.3em;
	cursor: pointer;
	float: right;
}
</style>
	<script>
    $(document).ready(function(){
	$('.background_music').get(0).play(); //play background music
	$('.nav').click(function(){
		$('.click_tone').get(0).play(); //click tone
	});
	
	$('.start').click(function(){
		$('.page').load("files/index.php?game=start");
	});
	$('.help').click(function(){
		$('.page').load("files/index.php?game=help");
	});
	$('.quit').click(function(){
		$('.page').load("files/index.php?game=quit");
	});
	
	$('.start').hover(function(){
		$(this).attr("src","images/button/lstart_game.bmp");
	},function(){
		$(this).attr("src","images/button/start_game.bmp");
	});
	$('.help').hover(function(){
		$(this).attr("src","images/button/lhelp.bmp");
	},function(){
		$(this).attr("src","images/button/help.bmp");
	});
	$('.quit').hover(function(){
		$(this).attr("src","images/button/lquit.bmp");
	},function(){
		$(this).attr("src","images/button/quit.bmp");
	});
	
	/*$(document).keydown(function(event){
		if(event.which === 8){
			$.ajax({
				type: 'GET',
				url: 'files/index.php',
				data: 'game=quit',
				beforeSend: function(){
					$('.page').html('Loading...');
				},
				success: function(response){
					location.reload(true);
				}
			});
		}
	});*/
});
	</script>
 <nav>
	<img class="nav start" src='images/button/start_game.bmp' />
	<img class="nav help" src='images/button/help.bmp' />
	<img class="nav quit" src='images/button/quit.bmp' />
 </nav>
<?php
}else if($_SESSION['game']['task'] === "completed" AND $_SESSION['game']['start'] === false){
	include "files/completed.php";
}else if($_SESSION['game']['start'] === true){
	include "files/index.php";
}?>
 </div>
 <!-- audio files -->
 <audio class="background_music" loop>
  <source src="music/back.wav" type="audio/wav"/>
 </audio>
 <audio class="click_tone">
  <source src="music/click.wav" type="audio/wav"/>
 </audio>
 <audio class="move_tone">
  <source src="music/button-3.wav" type="audio/wav"/>
 </audio>
 <audio class="input_tone">
  <source src="music/button-21.wav" type="audio/wav"/>
 </audio>
</body>
</html>
