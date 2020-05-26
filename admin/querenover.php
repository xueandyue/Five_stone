<?php

require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();
$me_id=isset($_POST['me_id'])?$_POST['me_id']:'';
$player_id=isset($_POST['player_id'])?$_POST['player_id']:'';
$id=isset($_POST['id'])?$_POST['id']:'';
$data=array(

	
	 'is_querenover'=>'1'
);
$where="id='{$id}' AND gameover='1' ";

$table='chess_game';
$chess_game=$PdoMySQL->update($data, $table,$where);

if($chess_game>0)
{
	$arr = array('type'=>'1');
$jsonStr = json_encode($arr);  //将数组转为json字符串
echo $jsonStr;

}
else{
		$arr = array('type'=>'0');
$jsonStr = json_encode($arr);  //将数组转为json字符串
echo $jsonStr;
}
















  
