<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 1) {
		header('Location: ./app/pages/home/index.php');
	} else {
		header('Location: ./app/pages/login/login.php');
	}
?>
