<?php

require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();
$first_player=$_POST['first_player'];
$table='chess_game';
$chess_game=$PdoMySQL->find($table,"first_player='{$first_player}'  AND laster_player_agree='1'  
    AND gameover !='1'
	");


$tabName='user';






if(empty($chess_game))
{
	
	$arr = array('type'=>'0');
	$jsonStr = json_encode($arr);  //将数组转为json字符串
	echo $jsonStr;
	return ;
	
}
else {

	$later_player_id=$chess_game['later_player'];
$row=$PdoMySQL->findById($tabName, $later_player_id);
$later_player_name=$row['username'];
	$arr = array('type'=>'1','laterplayer'=>$later_player_name);
	$jsonStr = json_encode($arr);  //将数组转为json字符串
	echo $jsonStr;
	return ;
	
}















  