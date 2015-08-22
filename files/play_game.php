<?php
require_once __DIR__ . "/functions.php";
session_start();
?>
<style>
.fixed_input{
	position: relative;
	top: 10.22em;
	left: 14.04em;
	width: 9.68em;
	height: 2em;
	border: .05em solid #000;
	background-color: #3A1615;
	color: #fff;
	font-size: 1.563em;
	padding: 0 0.6em;
	text-align: center;
	font-family: Courier;
}
#submit{
	cursor: pointer;
	position: relative;
	top: 30em;
	left: 24.6em;
	border-radius: 100%;
	width: 6em;
	height: 6em;
	border: 0 none;
}
</style>

<?php
if(isset($_SESSION["game"]["player1"]) && isset($_SESSION["game"]["player2"])){
	 require_once __DIR__ . "/main_game.php";
}else if(isset($_SESSION["game"]["player1"]) && !isset($_SESSION["game"]["player2"])){
	if(isset($_GET["player2"]) && isset($_GET["sex"])){
		$_SESSION["game"]["player2"]["name"] = $_GET["player2"];
		$_SESSION["game"]["player2"]["sex"] = $_GET["sex"];
		$_SESSION["game"]["player2"]["points"] = 0;
		//header("Location: ../index.php");
	}
?>
<style>
.page{
	background-image: url('images/player2.bmp');
}
.sex_selector{
	display: none;
}
.sex_selector.left{
	display: inline-block;
	position: relative;
	top: -246px;
	left: -144px;
}
.sex_selector.right{
	display: inline-block;
	position: relative;
	top: -268px;
	left: 500px;
}
</style>
<script>
$(document).ready(function(){
	var player2 = 'player2';
	var sex = 'male';
	$('.sex.female').click(function(){
		sex = 'female';
		$('.sex_selector').addClass("left").removeClass("right");
	});
	$('.sex.male').click(function(){
		sex = 'male';
		$('.sex_selector').addClass("right").removeClass("left");
	});
	$(document).keyup(function(){
	if($('input#player2').val() != ""){
		player2 = $('input#player2').val();
	}
	});
	$('#submit').click(function(){
		$('.page').load("files/play_game.php?player2="+player2+"&sex="+sex);
	});
	
});

</script>
<input type="text" name="player2" class="fixed_input" id="player2" autocomplete='off' />
<div id="submit"></div>
<img src="../imagesges/character/brave1.bmp" class='sex female' style="position: relative;top: 32px;left: 86px;width: 175px;" />
<img src="../imagesges/character/gru1.bmp" class='sex male' style="top: 25px;left: 520px;width: 178px;position: relative;" />
<div class="sex_selector"><img src='../imagesges/tick.bmp' /></div>
<?php
}else{
	if(isset($_GET["player1"], $_GET['sex'])){
		$_SESSION["game"]["player1"]["name"] = $_GET["player1"];
		$_SESSION["game"]["player1"]["sex"] = $_GET["sex"];
		$_SESSION["game"]["player1"]["points"] = 0;
		//header("Location: ../index.php");
	}
?>
<style>
.page{
	background-image: url('images/player1.bmp');
}
.sex_selector{
	display: none;
}
.sex_selector.left{
	display: inline-block;
	position: relative;
	top: -268px;
	left: -120px;
}
.sex_selector.right{
	display: inline-block;
	position: relative;
	top: -268px;
	left: 500px;
}
</style>
<script>
var main = function(){
	var player1 = 'player1';
	var sex = 'male';
	$('.sex.female').click(function(){
		sex = 'female';
		$('.sex_selector').addClass("left").removeClass("right");
	});
	$('.sex.male').click(function(){
		sex = 'male';
		$('.sex_selector').addClass("right").removeClass("left");
	});
	$(document).keyup(function(event){
	if($('input#player1').val() !== "" && $('input#player1').val() !== 0){
		player1 = $('input#player1').val();
	}
	});
	$('#submit').click(function(){
        $('.page').load("files/play_game.php?player1="+player1+"&sex="+sex);
	});
	
};
$(document).ready(main);
</script>
<input type="text" name="player1" class="fixed_input" id="player1" autocomplete='off' />
<div id="submit"></div>
<img src="../imagesges/character/tinker1.bmp" class='sex female' style="position: relative;top: -4px;left: 60px;width: 175px;" />
<img src="../imagesges/character/boy.bmp" class='sex male' style="top: 0px;left: 521px;width: 178px;position: relative;" />
<div class="sex_selector"><img src='../imagesges/tick.bmp' /></div>
<?php }
?>
