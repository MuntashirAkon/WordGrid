<?php
// not working for ltr
session_start();

if(isset($_POST["store"], $_POST['position'], $_POST['player'])){ // get info [not secured!]
	/** @var string $store */
	$store = strtolower(filter_input(INPUT_POST,'store',FILTER_SANITIZE_STRING));
	/** @var int $position */
	$position = (int)filter_input(INPUT_POST,'position',FILTER_SANITIZE_NUMBER_INT);
	/** @var string $active_player */
	$active_player = filter_input(INPUT_POST,'player',FILTER_SANITIZE_STRING);
}else{
	$store = '';
	$position = -1;
	$active_player = '';
}
require_once "dictionary.php";

$_SESSION["game"]["data"]["last_player"] = ($active_player == 'p1') ? 'p1': 'p2';

if(!isset($_SESSION['game']['data']['letters'][$position])){ // store the letter only if the grid is blank (for the protection against javascript injection)
$_SESSION["game"]["data"]["letters"][$position] = $store;
}


function checkWord($word, $dictionary){ // checks the word if it has already been used & returns points
	$is_used = false;
	$point = 0;
	for($i=0;$i<count($_SESSION["game"]["data"]["used_words"]);$i++){
		if($word === $_SESSION["game"]["data"]["used_words"][$i]){
			$is_used = true;
			break;
		}else{
			continue;
		}
	}
	if(!$is_used){
		for($i=0;$i<count($dictionary);$i++){
			if($dictionary[$i] === $word){
				$point = strlen($word);
				break;
			}else{
				continue;
			}
		}
	}
	return $point;
}


/*==== Checking Out The Rows ====*/
/*
if($position < 10){ // indexing positions
	$check_pos = 10;
}else if($position >= 10 && $position < 20){
	$check_pos = 20;
}else if($position >= 20 && $position < 30){
	$check_pos = 30;
}else if($position >= 30 && $position < 40){
	$check_pos = 40;
}else if($position >= 40 && $position < 50){
	$check_pos = 50;
}else if($position >= 50 && $position < 60){
	$check_pos = 60;
}else if($position >= 60 && $position < 70){
	$check_pos = 70;
}else if($position >= 70 && $position < 80){
	$check_pos = 80;
}else if($position >= 80 && $position < 90){
	$check_pos = 90;
}else if($position >= 90 && $position < 100){
	$check_pos = 100;
}*/

$check_position = ($position < 10) ? 10 : (($position < 20) ? 20 : (($position < 30) ? 30 : (($position < 40) ? 40 : (($position < 50) ? 50 : (($position < 60) ? 60: (($position < 70) ? 70 : (($position < 80) ? 80 : (($position < 90) ? 90 : 100))))))));

$count_before = $position - $check_position + 11;
$count_after = $check_position - $position;

$word1 = "";
$point1 = 0;
$count = 0;
$used_word_count = count($_SESSION["game"]["data"]["used_words"]);
for($i=0; $i<$count_before; $i++){ // counts the continuous number of letters to form a word from ltr before
	if(!isset($_SESSION["game"]["data"]["letters"][$position-$i])){
		break;
	}else{
		$count++;
		continue;
	}
}

for($j=$count-1;$j>=0; $j--){ // checks ltr before
	$word1 = "";
	for($i=$j; $i>=0; $i--){
		$word1 .= $_SESSION["game"]["data"]["letters"][$position-$i];
	}
	$point1 = checkWord($word1, $dictionary);
	//echo $word1." ".$point1." ";
	if($point1 > 0) break;
}

$word2 = "";
$point2 = 0;
$count = 0;
for($i=0; $i<$count_after; $i++){ // counts the continuous number of letters to form a word from ltr after
	if(!isset($_SESSION["game"]["data"]["letters"][$position+$i])){
		break;
	}else{
		$count++;
		continue;
	}
}

for($j=$count-1;$j>=0; $j--){ // checks ltr after
	$word2 = "";
	for($i=0; $i<=$j; $i++){
		$word2 .= $_SESSION["game"]["data"]["letters"][$position+$i];
	}
	$point2 = checkWord($word2, $dictionary);
	//$word2." ".$point2." ";
	if($point2 > 0) break;
}

/*==== Checking out the Columns ====*/
$word3 = "";
$point3 = 0;
$count = 0;
for($i=0;$i<=$position;$i+=10){
	if(!isset($_SESSION["game"]["data"]["letters"][$position-$i])){
		break;
	}else{
		$count++;
		continue;
	}
}
for($j=$count-1;$j>=0; $j--){ // count ttb before
	$word3 = "";
	for($i=$j*10; $i>=0; $i-=10){
		$word3 .= $_SESSION["game"]["data"]["letters"][$position-$i];
	}
	$point3 = checkWord($word3, $dictionary);
	//echo $word3." ".$point3." ";
	if($point3 > 0) break;
}

$word4 = "";
$point4 = 0;
$count = 0;
for($i=0;$i<100;$i+=10){
	if(!isset($_SESSION["game"]["data"]["letters"][$position+$i])){
		break;
	}else{
		$count++;
		continue;
	}
}
for($j=$count-1;$j>=0; $j--){ // count ttb after
	$word4 = "";
	for($i=0; $i<=$j*10; $i+=10){
		$word4 .= $_SESSION["game"]["data"]["letters"][$position+$i];
	}
	$point4 = checkWord($word4, $dictionary);
	//echo $word4." ".$point4." ";
	if($point4 > 0) break;
}

$point = 0;
$used_word = "";

$temp_point1 = 0;
$temp_point2 = 0;
$temp_word1 = "";
$temp_word2 = "";
if($point1 > $point2){
	$temp_point1 = $point1;
	$temp_word1 = $word1;
}else if($point2 > $point1){
	$temp_point1 = $point2;
	$temp_word1 = $word2;
}else{
	if($point1 !== 0){
		$temp_point1 = $point1;
		$temp_word1 = $word1;
	}
}

if($point3 > $point4){
	$temp_point2 = $point3;
	$temp_word2 = $word3;
}else if($point4 > $point3){
	$temp_point2 = $point4;
	$temp_word2 = $word4;
}else{
	if($point3 !== 0){
		$temp_point2 = $point3;
		$temp_word2 = $word3;
	}
}

if($temp_point1 >= $temp_point2){
	$point = $temp_point1;
	$used_word = $temp_word1;
}else{
	$point = $temp_point2;
	$used_word = $temp_word2;
}

if($used_word !== ""){
	$_SESSION["game"]["data"]["used_words"][$used_word_count] = $used_word;
}else{
	$point = 0;
}

if($active_player == "p1"){
	$_SESSION["game"]["player1"]["points"] += $point;
	$points = $_SESSION["game"]["player1"]["points"];
}else{
	$_SESSION["game"]["player2"]["points"] += $point;
	$points = $_SESSION["game"]["player2"]["points"];
}

echo $points." ".$active_player." ".$used_word;
/*
$points = (string)$points;

echo "<br />".$point1." ".$point2." ".$point3." ".$point4."<br />";
echo "<br />".$point." ".$used_word."<br />";

if(strlen($points)==1){
	echo "<input type='text' name='points2' class='points2' id='points2' value='0' />";
	echo "<input type='text' name='points1' class='points1' id='points1' value='".$points[0]."' />";
}else if(strlen($points)==2){
	echo "<input type='text' name='points2' class='points2' id='points2' value='".$points[0]."' />";
	echo "<input type='text' name='points1' class='points1' id='points1' value='".$points[1]."' />";
}
echo "<input type='text' name='last_user' class='last_user' id='last_user' value='".$active_player."' />";
echo "<input type='text' name='used_word' class='used_word' id='used_word' value='".$used_word."' />";
*/
