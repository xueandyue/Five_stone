<?php

require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();
$chess_flag=$_POST['chessFlag'];
$i=$_POST['i'];
$j=$_POST['j'];
$qizivalue=$_POST['qizivalue'];
$chess_game_id=isset($_POST['id'])?$_POST['id']:'';
$me_id=isset($_POST['me_id'])?$_POST['me_id']:'';
$player_id=isset($_POST['player_id'])?$_POST['player_id']:'';
$is_xianshou=isset($_POST['is_xianshou'])?$_POST['is_xianshou']:'';

$code=isset($_POST['code'])?$_POST['code']:'';
$id=isset($_POST['id'])?$_POST['id']:'';

if($code=='0')
{
	$is_deuce='1';
}
else{
	$is_deuce='0';

}


if($is_xianshou=='true')
{
	$first_player=$me_id;
	$Later_player=$player_id;
	if($code=='1')
{
	$who_win=$me_id;
	$who_lost=$player_id;

}

	if($code=='2')
{
	$who_lost=$me_id;
	$who_win=$player_id;
}

}
else{
	$first_player=$player_id;
	$Later_player=$me_id;


		if($code=='2')
{
	$who_win=$me_id;
	$who_lost=$player_id;
	
}

	if($code=='1')
{
	$who_lost=$me_id;
	$who_win=$player_id;
}

}




$data=array(
	 'array'=>$chess_flag,
	 'i'=>$i,
	 'j'=>$j,
	 'qizivalue'=>$qizivalue,
	 'who_win'=>$who_win,
	 'who_lost'=>$who_lost,
	 'is_deuce'=>$is_deuce,
	 'gameover'=>'1'
);
$where="id='{$id}' AND gameover='0' AND first_player='{$first_player}' 
AND  Later_player='{$Later_player}' ";

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
















  