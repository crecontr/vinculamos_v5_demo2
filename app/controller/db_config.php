<?php
	require_once("Medoo.php");

	use Medoo\Medoo;

	if(!isset($db)) {

		$db = new Medoo(array(
			'database_type' => 'mysql',
			'database_name' => 'vinculam_vinculamos_v4_demo2',
			'server' => 'localhost',
			//'server' => 'mysql',
			'username' => 'vinculam_vinculamos_user_demo',
			'password' => '+vUTSb!P&VXh',
			'charset' => 'utf8',
		));
	}
?>
