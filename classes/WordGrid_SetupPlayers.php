<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/23/2015
 * Time: 11:01 AM
 */

namespace classes;


class WordGrid_SetupPlayers{
    private $player;
    public function __construct($which_player){
        $this->player = $which_player;
        //
		if(isset($_GET[$this->player], $_GET['sex'])){
			$player = filter_input(INPUT_GET,'player1',FILTER_SANITIZE_STRING);
			$_SESSION["game"][$this->player]["name"] = $player != "" ? $player : $this->player;
			$_SESSION["game"][$this->player]["sex"] = $_GET['sex'] == "female" ? "female" : "male";
			$_SESSION["game"][$this->player]["points"] = 0;
		}
    }
    public function out(){
		/** @var array $player1 */
		$player1 = Array(
			"background" => "player1.bmp",
			"male" => "boy.bmp",
			"female" => "tinker1.bmp",
			"css_sex_selector_left_fix" => "top: -268px;left: -120px;",
			"css_sex_male_fix" => "top: 0px;left: 521px;",
			"css_sex_female_fix" => "top: -4px;left: 60px;"
		);
		/** @var array $player2 */
		$player2 = Array(
			"background" => "player2.bmp",
			"male" => "gru1.bmp",
			"female" => "brave1.bmp",
			"css_sex_selector_left_fix" => "top: -246px;left: -144px;",
			"css_sex_male_fix" => "top: 25px;left: 520px;",
			"css_sex_female_fix" => "top: 32px;left: 86px;"
		);
        $page = <<< EOF
<style>
.page{
	background-image: url('images/{${$this->player}['background']}');
}

.sex_selector{
	display: none;
}

.sex_selector.right{
	display: inline-block;
	position: relative;
	top: -268px;
	left: 500px;
}

.sex_selector.left{
	display: inline-block;
	position: relative;
	{${$this->player}['css_sex_selector_left_fix']}
}

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
	font-family: Courier, monospace;
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
<script>
    var sex = "male";
    $(document).ready(function(){
        $('.sex.female').click(function(){
            sex = 'female';
            $('.sex_selector').addClass("left").removeClass("right");
        });
        $('.sex.male').click(function(){
            sex = 'male';
            $('.sex_selector').addClass("right").removeClass("left");
        });
    });
    function setup_player_info(){
        var player = $('input#{$this->player}');
        if(player.val() == ""){
            player.val("{$this->player}");
        }
        $('input#sex').val(sex);
        player_info.submit();
        return true;
    }
</script>
<form id="player_info" name="player_info" method="get" action="" onsubmit="setup_player_info()">
    <label><input type="text" name="{$this->player}" class="fixed_input" id="{$this->player}" autocomplete='off' /></label>
    <input type="hidden" name="sex" class="fixed_input" id="sex" value="male" autocomplete='off' />
    <div id="submit" onclick="setup_player_info()"></div>
    <img src="images/character/{${$this->player}['female']}" class='sex female' style="width: 175px;position: relative;{${$this->player}['css_sex_female_fix']}" />
    <img src="images/character/{${$this->player}['male']}" class='sex male' style="width: 178px;position: relative;{${$this->player}['css_sex_male_fix']}" />
    <div class="sex_selector"><img src='images/tick.bmp' /></div>
</form>
EOF;
		require_once __DIR__."/Template.php";
        return (new Template($page))->out();
    }
}