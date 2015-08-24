<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/24/2015
 * Time: 11:16 PM
 */
session_start();
require_once __DIR__."/files/dictionary.php";
require_once __DIR__."/classes/WordGrid_ProcessGame.php";

(new \classes\WordGrid_ProcessGame())->out();