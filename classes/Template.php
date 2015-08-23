<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/23/2015
 * Time: 1:35 AM
 */

namespace classes;


class Template {
    public $page;
    public function __construct($page = ""){
        $this->page = $page;
    }

    public function out(){
        return "<!DOCTYPE html>
<html>
<head>
	<title>Word Grid Game</title>
	<meta charset='UTF-8' />
	<script src=\"js/jquery.min.js\"></script>
	<style>
.page{
	width:1000px;
	height:650px;
	margin: 0 auto;
	background-repeat: no-repeat;
}
	</style>
</head>
<body onload=\"startTime();\" style=\"margin:auto;\">
 <div class=\"page\">
 {$this->page}
 </div>

 <!-- audio files should always be loaded -->
 <audio class=\"background_music\" loop>
  <source src=\"music/back.wav\" type=\"audio/wav\"/>
 </audio>
 <audio class=\"click_tone\">
  <source src=\"music/click.wav\" type=\"audio/wav\"/>
 </audio>
 <audio class=\"move_tone\">
  <source src=\"music/button-3.wav\" type=\"audio/wav\"/>
 </audio>
 <audio class=\"input_tone\">
  <source src=\"music/button-21.wav\" type=\"audio/wav\"/>
 </audio>
</body>
</html>";

    }
}