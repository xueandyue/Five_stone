<?php
require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();
$table='chess_game';
$laster_player_agree=isset($_POST['later_player_agree'])?$_POST['later_player_agree']:'';
$Later_player=$_POST['Later_player'];
$chess_game=$PdoMySQL->find($table,"Later_player='{$Later_player}' AND gameover='-1' AND laster_player_agree='0'");
$data=array(
	 'laster_player_agree'=>'1',
	 'gameover'=>'0'
);
$where="Later_player='{$Later_player}' AND gameover='-1' AND laster_player_agree='0'";
$chess_game=$PdoMySQL->update($data, $table,$where);

if(empty($chess_game))
{
	
	$arr = array('type'=>'0');
	$jsonStr = json_encode($arr);  //将数组转为json字符串
	echo $jsonStr;
	return ;
	
}
else {
	$arr = array('type'=>'1');
	$jsonStr = json_encode($arr);  //将数组转为json字符串
	echo $jsonStr;
	return ;
	
}












// echo $Later_player;s




  