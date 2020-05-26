<?php
require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();
$chess_flag=$_POST['chessFlag'];
$i=$_POST['i'];
$j=$_POST['j'];
$qizivalue=$_POST['qizivalue'];
$id=$_POST['id'];


$data=array(
	 'array'=>$chess_flag,
	 'i'=>$i,
	 'j'=>$j,
	 'qizivalue'=>$qizivalue
);

$table='chess_game';
$chess_game=$PdoMySQL->update($data, $table,"id='{$id}'");
$arr = array('type'=>'1');
$jsonStr = json_encode($arr);  //将数组转为json字符串
echo $jsonStr;











//  echo $_POST['i'];

