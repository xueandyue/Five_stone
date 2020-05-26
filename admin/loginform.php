<?php
 
  require_once '../PdoMySQL.class.php';
  require_once '../config.php';
  $PdoMySQL=new PdoMySQL();
  $table='user';
  $act=$_GET['act'];
  
  if($act=='login')
  {
  	$username=addslashes($_POST['username']);
  	$password=$_POST['password'];
  	$row=$PdoMySQL->find($table,"username='{$username}' AND password='{$password}'",'status');
//   	var_dump($row);
//      echo $row['status'];
//   	exit();
  	if(empty($row))
  	{
  		$arr = array('type'=>'0');
  		$jsonStr = json_encode($arr);  //将数组转为json字符串
  		echo $jsonStr;
  		return ;

  	}
  	if($row['status']==0){
  		$arr =array('type'=>'2');
  		$jsonStr = json_encode($arr);  //将数组转为json字符串
  		echo $jsonStr;
  		return ;
  	}else{
  		$arr = array('type'=>'1');
  		$jsonStr = json_encode($arr);  //将数组转为json字符串
  		echo $jsonStr;
  		return ;
  		
  	}
  	
  
  }
  
  

  if($act==='reg'){
  	
  	$email=$_POST['email'];
  	
  //完成登陆的功能
  	$row=$PdoMySQL->find($table,"email='{$email}' ");
  	if(empty($row))
  	{
  		$arr = array('type'=>'1',);//可以用该邮箱注册
  		$jsonStr = json_encode($arr);  //将数组转为json字符串
  		echo $jsonStr;
  		return ;
  	}
  	else {
  		$arr = array('type'=>'0',);//不可以用该邮箱注册
  		$jsonStr = json_encode($arr);  //将数组转为json字符串
  		echo $jsonStr;
  		return ;
  		
  	}
  		
  	 
 

  	
  }