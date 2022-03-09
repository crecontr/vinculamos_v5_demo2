<?php
	@session_start();

	unset($_SESSION["tieneError"]);
	unset($_SESSION["mensaje"]);
	$_SESSION["activo"] = 0;

  unset($_SESSION["nombre_usuario"]);
	unset($_SESSION["nombre"]);
	unset($_SESSION["apellido"]);
	unset($_SESSION["perfil"]);
	unset($_SESSION["institucion"]);

	unset($_SESSION["permiso_usuarios"]);
	unset($_SESSION["permiso_objetivos"]);
	unset($_SESSION["permiso_iniciativas"]);

	unset($_SESSION["permiso_estadisticas"]);
	unset($_SESSION["permiso_parametros"]);

	unset($_SESSION["permiso_institucion"]);

	header('Location: ../index.php');
?>
