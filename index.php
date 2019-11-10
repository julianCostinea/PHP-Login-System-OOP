<?php 
	require_once 'core/init.php';
	
	$user= DB::getInstance()->get("users", array('username', '=', 'julian'));
	if (!$user->count()) {
		echo "no user";
	}else{
		echo $user->first()->username;
	}
 ?>