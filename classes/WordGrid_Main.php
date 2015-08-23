<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/23/2015
 * Time: 1:51 AM
 */

namespace classes;


class WordGrid_Main {
    private $page = "<style scoped>
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
	//$('.background_music').get(0).play(); //play background music
	$('.nav').click(function(){
		$('.click_tone').get(0).play(); //click tone
	});

	$('.start').hover(function(){
		$(this).attr(\"src\",\"images/button/lstart_game.bmp\");
	},function(){
		$(this).attr(\"src\",\"images/button/start_game.bmp\");
	});
	$('.help').hover(function(){
		$(this).attr(\"src\",\"images/button/lhelp.bmp\");
	},function(){
		$(this).attr(\"src\",\"images/button/help.bmp\");
	});
	$('.quit').hover(function(){
		$(this).attr(\"src\",\"images/button/lquit.bmp\");
	},function(){
		$(this).attr(\"src\",\"images/button/quit.bmp\");
	});

	/*$(document).keydown(function(event){
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
	});*/
});
	</script>
 <nav>
	<a href=\"?game=start\"><img class=\"nav start\" src='images/button/start_game.bmp' /></a>
	<a href=\"?game=help\"><img class=\"nav help\" src='images/button/help.bmp' /></a>
	<a href=\"?game=quit\"><img class=\"nav quit\" src='images/button/quit.bmp' /></a>
 </nav>";
    public function out(){
        require_once __DIR__."/Template.php";
        return (new Template($this->page))->out();
    }
}