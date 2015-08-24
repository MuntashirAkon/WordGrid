<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/24/2015
 * Time: 3:25 AM
 */

namespace classes;


class WordGrid_MainGame {
    public function __construct(){
        //set current time in milliseconds
        if(!isset($_SESSION['game']['start_time'])){
            $_SESSION['game']['start_time'] = round(microtime(true)*1000); // set UTC time
        }
        //set last player for the first time
        if(!isset($_SESSION['game']['data']['last_player'])) $_SESSION['game']['data']['last_player'] = 'p2';
    }
    public function out(){
        $tracks_count = 0;
        $keep_tracks = "";
        if(isset($_SESSION['game']['data']['letters'])){
            for($i=0;$i<100;$i++){
                if(isset($_SESSION['game']['data']['letters'][$i])){
                    $keep_tracks .= "keep_tracks[{$i}] = '{$_SESSION['game']['data']['letters'][$i]}';\n";
                    $tracks_count++;
                }
            }
        }
        $table_td = "";
        for($i=0;$i<10;$i++){
            for($j=0;$j<10;$j++){
                $table_td .= "<td class='input_holder unfilled'></td>";
            }
        }
        $page = "<script>
// setting up game time
// currently a wrong method is used
// need to repair
function startTime(){ // this function is for showing dynamic time
 var today = new Date(); // get UTC time
 var dynamic_time = today.getTime();
 var server_time = {$_SESSION['game']['start_time']};
 var count_time = dynamic_time-server_time;
 var get_seconds = toInt(count_time/1000);
 var get_minutes = toInt(get_seconds/60);
 var get_hours = toInt(get_minutes/60);
 var get_days = toInt(get_hours/24);

 var game_secs = addZero(toInt(get_seconds-(60*get_minutes)));
 var game_mins = addZero(toInt(get_minutes-(60*get_hours)));
 var game_hrs = addZero(toInt(get_hours-(24*get_days)));

 document.getElementById('time').innerHTML=game_hrs+\":\"+game_mins+\":\"+game_secs;
 t=setTimeout('startTime()',500);
}

function addZero(value){ // adds a zero, this function is for startTime()
	if(value<10){
		value = \"0\" + value;
	}
	return value;
}

function toInt(value){ // string or float to int
	return value | 0;
}

$(document).ready(function(){
    startTime();
});

//global variables
var keep_tracks = []; // this array will store letters of the grids
var tracks_count; //count the letters or filled grid(s)
var active_player = 0;
var last_user = \"{$_SESSION['game']['data']['last_player']}\";
var last_active = last_user;
var last_used_word;
var player1_points = \"{$_SESSION['game']['player1']['points']}\";
var player2_points = \"{$_SESSION['game']['player2']['points']}\";
var points1 = 0;
var points2 = 0;

// (conditional) initial values

for(var i=0;i<100;i++){
	keep_tracks[i] = 0;
}

{$keep_tracks}
tracks_count = {$tracks_count};

$(document).ready(function(){
	/* initial settings */
	for(var i=0;i<100;i++){ // if user reloads, this will fill the previously entered letters
		if(keep_tracks[i]!=0){
			$('td:eq('+i+')').addClass(\"filled\").html(\"<img src='images/level3/\"+keep_tracks[i]+\".bmp' height='58px' />\");
		}
	}
	$('td:first-child').addClass('active'); // making the initial grid active
	if(last_active === \"p2\"){
		active_player = last_active;
		$('div.player1.status').addClass('available').html(\"<img src='images/button/button_glossy_green.svg' height='25px' />\");
		$('div.player2.status').addClass('unavailable').html(\"<img src='images/button/button_glossy_lightgray.svg' height='25px' />\");
		last_active = 0;
	}else if(last_active === \"p1\"){
		active_player = last_active;
		$('div.player2.status').addClass('available').html(\"<img src='images/button/button_glossy_green.svg' height='25px' /><input type='hidden' id='player1_status' name='player1_status' value='1' />\");
		$('div.player1.status').addClass('unavailable').html(\"<img src='images/button/button_glossy_lightgray.svg' height='25px' /><input type='hidden' id='player2_status' name='player2_status' value='0' />\");
		last_active = 0;
	}
	if(player1_points.length === 1){
		$(\"img.player1.digit_right\").attr(\"src\",\"images/digit/\"+player1_points+\".bmp\");
		$(\"img.player1.digit_left\").attr(\"src\",\"images/digit/0.bmp\");
	}else{
		$(\"img.player1.digit_right\").attr(\"src\",\"images/digit/\"+player1_points[1]+\".bmp\");
		$(\"img.player1.digit_left\").attr(\"src\",\"images/digit/\"+player1_points[0]+\".bmp\");
	}
	if(player2_points.length === 1){
		$(\"img.player2.digit_right\").attr(\"src\",\"images/digit/\"+player2_points+\".bmp\");
		$(\"img.player2.digit_left\").attr(\"src\",\"images/digit/0.bmp\");
	}else{
		$(\"img.player2.digit_right\").attr(\"src\",\"images/digit/\"+player2_points[1]+\".bmp\");
		$(\"img.player2.digit_left\").attr(\"src\",\"images/digit/\"+player2_points[0]+\".bmp\");
	}

	/* mouse event(s) */
	$('.input_holder').click(function(){ // moving from one block to another using mouse
		$('.input_holder').removeClass('active');
		$(this).addClass('active');
		$('.click_tone').get(0).play();
	});

	/* keyboard events */
	$(document).keydown(function(event){ // this is the main event function
		if(event.which === 39){ // right arrow key
			if($('td.active').next().length !== 0){
				$('td.active').removeClass('active').next().addClass('active');
				$('.move_tone').get(0).play();
			}
		}else if(event.which === 37){ // left arrow key
			if($('td.active').prev().length !== 0){
				$('td.active').removeClass('active').prev().addClass('active');
				$('.move_tone').get(0).play();
			}
		}else if(event.which === 40){ // down arrow key
			var index_plus_ten = $('td.active').index() + 10; // necessary for moving from bottommost to topmost block
			if(index_plus_ten >= 100){
				index_plus_ten = index_plus_ten - 100;
			}
			$('td.active').removeClass('active').parent().find('td:eq('+index_plus_ten+')').addClass('active');
			$('.move_tone').get(0).play();
		}else if(event.which === 38){ // up arrow key
			var index_minus_ten = $('td.active').index() - 10; // necessary for moving from topmost to bottommost block
			$('td.active').removeClass('active').parent().find('td:eq('+index_minus_ten+')').addClass('active');
			$('.move_tone').get(0).play();
		}
		/* the main condition */
		else if(event.which > 64 && event.which < 91){ // output characters: only a-z is allowed
			// local variables
			var intToChar = String.fromCharCode(event.which); // convert number to character
			var index_active = $('td.active').index();

			if(keep_tracks[index_active] === 0){ // this is the main condition
				$('td.active.unfilled').removeClass('unfilled').addClass('filled').html(\"<img src='images/level3/\"+intToChar.toLowerCase()+\".bmp' height='58px' />\"); // generate image
				keep_tracks[index_active] = intToChar; // assign the char value into the array
				tracks_count++;

				//needs to repair
				if(active_player === \"p2\"){
					active_player = \"p1\";
					$('div.player1.status').removeClass('available').addClass('unavailable').html(\"<img src='images/button/button_glossy_lightgray.svg' height='25px' />\");
					$('div.player2.status').addClass('available').removeClass('unavailable').html(\"<img src='images/button/button_glossy_green.svg' height='25px' />\");
					$('.input_tone').get(0).play();
				}else if(active_player === \"p1\"){
					active_player = \"p2\";
					$('div.player1.status').addClass('available').removeClass('unavailable').html(\"<img src='images/button/button_glossy_green.svg' height='25px' />\");
					$('div.player2.status').removeClass('available').addClass('unavailable').html(\"<img src='images/button/button_glossy_lightgray.svg' height='25px' />\");
					$('.input_tone').get(0).play();
				}
				// send letters & receive information via AJAX
				$.ajax({
					type: 'post',
					url: 'files/store.php',
					data: 'store='+intToChar+'&position='+index_active+'&player='+active_player,
					success: function(response){
						var split_response = response.split(\" \");
						last_user = split_response[1];
						last_used_word = split_response[2];
						var points = split_response[0];
						// set points
						if(points.length !== 1){
							var split_point = points.split(\"\");
							points2 = split_point[0];
							points1 = split_point[1];
						}else{
							points2 = 0;
							points1 = points;
						}
						if(last_user === \"p1\"){
							$(\"img.player1.digit_right\").attr(\"src\",\"images/digit/\"+points1+\".bmp\");
							$(\"img.player1.digit_left\").attr(\"src\",\"images/digit/\"+points2+\".bmp\");
						}else if(last_user === \"p2\"){
							$(\"img.player2.digit_right\").attr(\"src\",\"images/digit/\"+points1+\".bmp\");
							$(\"img.player2.digit_left\").attr(\"src\",\"images/digit/\"+points2+\".bmp\");
						}
						$('.sample1').html(response); // script debug
					}
				});

				if(tracks_count === 100){ //if all the blocks are filled (not set)
					$.ajax({
						type: 'post',
						url: 'files/completed.php',
						data: 'task=completed',
						success: function(response){
							$('.page').html(response);
						}
					});
				}
			}
		}
	});
	/* quit events */
	$('.back_key').click(function(){
		$.ajax({
			type: 'GET',
			url: 'index.php',
			data: 'game=quit',
			beforeSend: function(){
				$('.page').html('Loading...');
			},
			success: function(response){
				location.reload(true);
			}
		});
	});

	$(document).keydown(function(event){
		if(event.which === 8){
			$.ajax({
				type: 'GET',
				url: 'index.php',
				data: 'game=quit',
				beforeSend: function(){
					$('.page').html('Loading...');
				},
				success: function(response){
					location.reload(true);
				}
			});
		}
	});
});
</script>
<style>
.page{
	background-color:rgb(55,42,30);
}
table{
	padding:0;
	margin:0;
	border-collapse:collapse;
	background-color:rgb(110,104,81);
}
.input_holder{
	height:58px;
	width:58px;
	border:1px solid rgb(35,31,29);
	display:inline-block;
	margin:0;
	padding:0;
	cursor: text;
}
.digit_right{
	margin-left:16px;
}
.back_key{
	background-color: #539bff;
	cursor: pointer;
}
.back_key:hover{
	background-color: #5368ff;
}
.active{
	border: 1px solid rgb(172,172,172);
}
</style>
<div style=\"float:left; margin:17px;height: 600px;width: 600px;border: 8px solid rgb(35,31,29)\">
 <table>
 <tr>
  {$table_td}
 </tr>
 </table>
</div>
<div style=\"float:right;width:316px;margin:17px 17px 17px 0;height: 600px;border: 8px solid rgb(35,31,29); background-image: url('images/scorboard.bmp')\">
 <div id=\"time\" style=\"position:relative; top: 12.7em; left: 7.7em; color: #fff; font-size:1.5em; width:115px;cursor: default;\"></div>
 <!-- scoreboard -->
 <div class=\"scoreboard player1\" style=\"position: relative;top: 5em;left: 9.5em; width: 141px;\">
	<img class=\"player1 digit_left\" src=\"images/digit/0.bmp\" />
	<img class=\"player1 digit_right\" src=\"images/digit/0.bmp\" />
 </div>
 <div class=\"scoreboard player2\" style=\"position: relative;top: 21.05em;left: 9.5em; width: 141px;\">
	<img class=\"player2 digit_left\" src=\"images/digit/0.bmp\" />
	<img class=\"player2 digit_right\" src=\"images/digit/0.bmp\" />
 </div>
 <!-- player name -->
 <div class=\"player1 name\" style=\"position: relative;top: -.5em;left: 5.8em;width: 153px;text-align: center;font-size: 25px; color: #fff;cursor: default;\">{$_SESSION["game"]["player1"]["name"]}</div>
 <div class=\"player2 name\" style=\"position: relative;top: 12.5em;left: 5.8em;width: 153px;text-align: center;font-size: 25px; color: #fff;cursor: default;\">{$_SESSION["game"]["player2"]["name"]}</div>
 <!-- player status -->
 <div class=\"player1 status\" style=\"position: relative;top: -13.5em;left: 8em;height: 25px;width: 25px;\"></div>
 <div class=\"player2 status\" style=\"position: relative;top: 7.2em;left: 8em;height: 25px;width: 25px;\"></div>
 <div class=\"back_key\" style=\"position: relative;top: -19.5em;left: 16.5em; border-radius: 100%; height:40px; width: 40px;\"><img src=\"images/button/BackButton.png\" title=\"Click here or Press 'backspace' to go back\" /></div>
</div>

<!-- debugging tools -->
<div class='sample1' style=\"clear:both;\"></div>
<div class='sample' style=\"clear:both;\"></div>
";
        require_once __DIR__."/Template.php";
        return (new Template($page))->out();
    }
}