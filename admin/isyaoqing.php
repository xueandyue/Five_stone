<?php

require_once '../PdoMySQL.class.php';
require_once '../config.php';
$PdoMySQL=new PdoMySQL();
$table='chess_game';
$first_player=$_POST['first_player'];
$later_player=$_POST['Later_player'];





$data=array(
	 'first_player'=>$first_player,
	 'later_player'=>$later_player
	 );
$PdoMySQL->add($data, $table);




  