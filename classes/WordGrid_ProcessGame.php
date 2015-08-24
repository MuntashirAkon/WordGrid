<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 8/24/2015
 * Time: 8:29 PM
 */

namespace classes;


class WordGrid_ProcessGame{
    /**
     * @var string $letter
     */
    private $letter = '';
    /**
     * @var int $position
     */
    private $position = 0;
    /**
     * @var string $active_player
     */
    private $active_player = '';
    public function __construct(){
        if(isset($_POST["store"], $_POST['position'], $_POST['player'])){
            $this->letter = strtolower(filter_input(INPUT_POST,'store',FILTER_SANITIZE_STRING));
            $this->position = (int)filter_input(INPUT_POST,'position',FILTER_SANITIZE_NUMBER_INT);
            $this->active_player = filter_input(INPUT_POST,'player',FILTER_SANITIZE_STRING);
        }
        $this->default_operations();
    }

    public function out(){
        $check_position = ($this->position < 10) ? 10 : (($this->position < 20) ? 20 : (($this->position < 30) ? 30 : (($this->position < 40) ? 40 : (($this->position < 50) ? 50 : (($this->position < 60) ? 60: (($this->position < 70) ? 70 : (($this->position < 80) ? 80 : (($this->position < 90) ? 90 : 100))))))));

        $count_before = $this->position - $check_position + 11;
        $count_after = $check_position - $this->position;
        $count = 0;
        for($i=0; $i<$count_before; $i++){ // counts the continuous number of letters to form a word from ltr before
            if(!isset($_SESSION["game"]["data"]["letters"][$this->position-$i])){
                break;
            }else{
                $count++;
                continue;
            }
        }
        $words[0] = $this->conf_word($count, true, true);

        $count = 0;
        for($i=0; $i<$count_after; $i++){ // counts the continuous number of letters to form a word from ltr after
            if(!isset($_SESSION["game"]["data"]["letters"][$this->position+$i])){
                break;
            }else{
                $count++;
                continue;
            }
        }
        $words[1] = $this->conf_word($count, true, false);

        $count = 0;
        for($i=0;$i<=$this->position;$i+=10){
            if(!isset($_SESSION["game"]["data"]["letters"][$this->position-$i])){
                break;
            }else{
                $count++;
                continue;
            }
        }
        $words[2] = $this->conf_word($count,false,true);


        $count = 0;
        for($i=0;$i<100;$i+=10){
            if(!isset($_SESSION["game"]["data"]["letters"][$this->position+$i])){
                break;
            }else{
                $count++;
                continue;
            }
        }
        $words[3] = $this->conf_word($count,false,false);

        $used_word = '';
        $temp_point = 0;
        for($i=0;$i<count($words);$i++){
            if($words[$i]['point'] > $temp_point){
                $temp_point = $words[$i]['point'];
                $used_word = $words[$i];
            }
        }


        if(!is_array($used_word)){
            $used_word['word'] = '';
            $used_word['point'] = $temp_point;
        }
        unset($temp_point,$count);

        if($used_word['word'] != '') {
            $used_word_count = count($_SESSION["game"]["data"]["used_words"]);
            $_SESSION["game"]["data"]["used_words"][$used_word_count] = $used_word['word'];
        }

        if($this->active_player == "p1"){
            $_SESSION["game"]["player1"]["points"] += $used_word['point'];
            $points = $_SESSION["game"]["player1"]["points"];
        }else{
            $_SESSION["game"]["player2"]["points"] += $used_word['point'];
            $points = $_SESSION["game"]["player2"]["points"];
        }

        echo $points." ".$this->active_player." ".$used_word['word'];
        print_r($words);
    }

    private function default_operations(){
        $_SESSION["game"]["data"]["last_player"] = ($this->active_player == 'p1') ? 'p1': 'p2';
        if(!isset($_SESSION['game']['data']['letters'][$this->position]) && strlen($this->letter)){ // store the letter only if the grid is blank (for the protection against javascript injection)
            $_SESSION["game"]["data"]["letters"][$this->position] = $this->letter;
        }
    }

    private function check_word($word){ // checks the word if it has already been used & returns points
        global $dictionary;
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

    private function conf_word($count, $is_ltr, $is_before){
        $word = '';
        $point = 0;
        for($j=$count-1;$j>=0; $j--){
            $word = '';
            if($is_ltr){
                if($is_before){
                    for($i=$j; $i>=0; $i--){
                        $word .= $_SESSION["game"]["data"]["letters"][$this->position-$i];
                    }
                }else{ // if after
                    for($i=0; $i<=$j; $i++){
                        $word .= $_SESSION["game"]["data"]["letters"][$this->position+$i];
                    }
                }
            }else{ // if top to bottom
                if($is_before){
                    for($i=$j*10; $i>=0; $i-=10){
                        $word .= $_SESSION["game"]["data"]["letters"][$this->position-$i];
                    }
                }else{ // if after
                    for($i=0; $i<=$j*10; $i+=10){
                        $word .= $_SESSION["game"]["data"]["letters"][$this->position+$i];
                    }
                }
            }
            $point = $this->check_word($word);
            if($point > 0) break;
        }
        return Array('word' => $word, 'point' => $point);
    }

}