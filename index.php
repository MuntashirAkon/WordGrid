<?php
/**
 * WordGrid Game
 *
 * @category WordGrid
 * @author Muntashir Al-Islam <muntashir.islam96@gmail.com>
 * @copyright Copyright (c) 2012 - 2015 Muntashir Al-Islam
 */

require_once __DIR__."/classes/Template.php";
require_once __DIR__."/classes/WordGrid_Main.php";
require_once __DIR__."/classes/WordGrid_SetupPlayers.php";

session_start();

if(isset($_GET['game'])) $req_phase = filter_input(INPUT_GET,'game',FILTER_SANITIZE_STRING);
else $req_phase = '';

if(isset($_SESSION['game']['start'])){
    if($req_phase == 'quit') goto p;
    if($_SESSION['game']['start']){
        if(isset($_SESSION["game"]["player1"])){
            if(isset($_SESSION["game"]["player2"])){
                require_once __DIR__ . "/files/main_game.php";
            }else{
                // setup player 2
                $player2 = new \classes\WordGrid_SetupPlayers('player2');

                echo $player2->out();
            }
        }else{
            $player1 = new \classes\WordGrid_SetupPlayers('player1');

            echo $player1->out();
            // setup player 1
        }
    }
}else{
    p:
    switch($req_phase){
        case 'start':
            $_SESSION['game']['start'] = true;
            break;
        case 'help':
            echo (new \classes\Template("<style>.page{background-image: url('images/help.bmp');}</style>"))->out();
            break;
        case 'quit':
            session_destroy();
            echo "<script>window.location.assign('about:blank')</script>";
            break;
        default:
            echo (new \classes\WordGrid_Main())->out();
    }
}

/*if($_SESSION['game']['task'] === "completed" AND $_SESSION['game']['start'] === false){
	include "files/completed.php";
}*/