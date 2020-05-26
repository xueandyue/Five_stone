
<?php
require_once '../PdoMySQL.class.php';
require_once '../config.php';
//3.得到连接对象
$PdoMySQL=new PdoMySQL();
$table='user';
$id=$_POST['id'];

$row=$PdoMySQL->find($table,"is_online='1'","id,username,online_last_time");//查找在线玩家
$b=date('y-m-d h:i:s',time());
$data1=array('online_last_time'=>$b);
$update=$PdoMySQL->update($data1, $table,"id='{$id}'");
$data=array();

foreach ($row as $value) {

	if($value['online_last_time']!='null')
	{
		$a=$value['online_last_time'];
		$aa = strtotime($b)-strtotime($a);
		if($aa<600)
		{
			$data[]=$value;

		}
		
	}


		

}


// $data=$row;
$jsonStr = json_encode($data);  //将数组转为json字符串
echo $jsonStr;





        
  