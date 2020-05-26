<?php
header('content-type:text/html;charset=utf-8');
$id=isset($_GET['id'])?$_GET['id']: '';
require_once 'PdoMySQL.class.php';
require_once 'config.php';
//3.得到连接对象
$PdoMySQL=new PdoMySQL();
$table='user';
$data=array('is_online'=>'0');
$res=$PdoMySQL->update($data,$table,"id='{$id}'");
session_start();
unset($_SESSION['username']);
session_destroy();
echo '<meta http-equiv="refresh" content="1;url=login.php"/>';







