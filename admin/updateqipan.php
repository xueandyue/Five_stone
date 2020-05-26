<?php
require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();

$id=$_POST['id'];
$table='chess_game';
$chess_game=$PdoMySQL->findById($table, $id);
if($chess_game['is_querenover']=='1'&&$chess_game['gameover']=='1')
{
	$data=array(
		'i'=>$chess_game['i'],
		'j'=>$chess_game['j'],
		'qizivalue'=>$chess_game['qizivalue'],
		'code'=>'400'
		
);

	$jsonStr = json_encode($data);  //将数组转为json字符串
echo $jsonStr;
	return;


}


$data=array(
		'i'=>$chess_game['i'],
		'j'=>$chess_game['j'],
		'qizivalue'=>$chess_game['qizivalue'],
		'code'=>'200'
		
);
$jsonStr = json_encode($data);  //将数组转为json字符串
echo $jsonStr;





