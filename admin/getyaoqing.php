<?php

require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();




$table='chess_game';
$Later_player=isset($_POST['Later_player'])?$_POST['Later_player']:'';

$chess_game=$PdoMySQL->find($table,"Later_player='{$Later_player}' AND gameover='-1' AND laster_player_agree='0'");


if(empty($chess_game))
{
	
	$arr = array('type'=>'0');
	$jsonStr = json_encode($arr);  //将数组转为json字符串
	echo $jsonStr;
	return ;
	
}



$tabName='user';
$first_player_id=$chess_game['first_player'];
$row=$PdoMySQL->findById($tabName, $first_player_id);
$firstplayer_name=$row['username'];

$arr = array('type'=>'1','first_player'=>$firstplayer_name
);
$jsonStr = json_encode($arr);  //将数组转为json字符串
echo $jsonStr;










// echo $Later_player;s




  