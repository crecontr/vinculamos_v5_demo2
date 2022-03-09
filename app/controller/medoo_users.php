<?php

	function getUser($username = null) {
		include("db_config.php");

		$datas = $db->select("viga_usuarios",
		[
			"[><]viga_perfiles" => ["id_perfil" => "id_perfil"]
		],[
			"viga_usuarios.nombre",
			"viga_usuarios.nombre_usuario",
			"viga_usuarios.apellido",
			"viga_usuarios.correo_electronico",
			"viga_usuarios.telefono",
			"viga_usuarios.estado",
			"viga_perfiles.id_perfil(id_perfil)",
			"viga_perfiles.nombre(perfil)"
		],[
			"nombre_usuario" => $username
		]);
		//echo "<br>query: " . $db->last();

		return $datas;
	}

	function addUser($nombre = null, $apellido = null, $correo = null, $telefono = null,
		$perfil = null, $username = null, $contrasenia = null, $estado = null, $autor = null) {
		include_once("db_config.php");

		$datas = $db->select("viga_usuarios",["nombre_usuario"],["nombre_usuario" => $username]);
		if(sizeof($datas) > 0) return null;

		$db->insert("viga_usuarios",
			[
				"nombre_usuario" => $username,
				"nombre" => $nombre,
				"apellido" => $apellido,
				"correo_electronico" => $correo,
				"telefono" => $telefono,
				"contrasenia" => hash("sha256", $contrasenia),
				"id_perfil" => $perfil,
				"estado" => $estado
			]
		);
		$datas = $db->select("viga_usuarios",["nombre_usuario"],["nombre_usuario" => $username]);

		if(sizeof($datas) == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "usuario", 0, "Nuevo registro con valores {nombre_usuario => $username, nombre => $nombre, apellido => $apellido, correo_electronico => $correo, telefono => $telefono, id_perfil => $perfil}");
			return $datas;
		}return null;
	}

	function editUser($nombre = null, $apellido = null, $correo = null, $telefono = null,
		$perfil = null, $username = null, $estado = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_usuarios",
			[
				"nombre" => $nombre,
				"apellido" => $apellido,
				"correo_electronico" => $correo,
				"telefono" => $telefono,
				"id_perfil" => $perfil,
				"estado" => $estado
			],
			[
				"nombre_usuario" => $username
			]
		);
		//echo "<br>query: " . $db->last();
		$datas = $db->select("viga_usuarios", "*", ["nombre_usuario" => $username]);

		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["apellido"] == $apellido) $verificator++;
		if($datas[0]["correo_electronico"] == $correo) $verificator++;
		if($datas[0]["telefono"] == $telefono) $verificator++;
		if($datas[0]["id_perfil"] == $perfil) $verificator++;

		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "usuario", 0, "Modificación en registro con valores {nombre_usuario => $username, nombre => $nombre, apellido => $apellido, correo_electronico => $correo, telefono => $telefono, id_perfil => $perfil}");
			return $datas;
		}return null;
	}

	function editUserInstitutionInformation($username = null, $id_tipo_institucion = null, $id_sede = null, $id_unidad = null) {
		include("db_config.php");

		$db->update("viga_usuarios",
			[
				"id_tipo_institucion" => $id_tipo_institucion,
				"id_sede" => $id_sede,
				"id_unidad" => $id_unidad
			],
			[
				"nombre_usuario" => $username
			]
		);
		//echo "<br>query: " . $db->last();
		$datas = $db->select("viga_usuarios", "*", ["nombre_usuario" => $username]);

		$verificator = 0;
		if($datas[0]["id_tipo_institucion"] == $id_tipo_institucion) $verificator++;
		if($datas[0]["id_sede"] == $id_sede) $verificator++;
		if($datas[0]["id_unidad"] == $id_unidad) $verificator++;

		if($verificator == 3) return $datas;
		return null;
	}

	function deleteUser($codigo = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_usuarios",
			[
				"visible" => "-1",
			],
			[
				"nombre_usuario" => $codigo
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		$datas = $db->select("viga_usuarios", "*", ["nombre_usuario" => $codigo]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "usuario", 0, "Eliminación de registro con valores {nombre_usuario => $codigo, visible => -1}");
			return $datas;
		}return null;
	}

	function changePassword($username = null, $contrasenia = null, $autor = null) {
		include("db_config.php");
		$db->update("viga_usuarios",
			[
				"contrasenia" => hash("sha256", $contrasenia)
			],
			[
				"nombre_usuario" => $username
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		$datas = $db->select("viga_usuarios","*",["nombre_usuario" => $username]);
		$verificator = 0;
		if($datas[0]["contrasenia"] == hash("sha256", $contrasenia)) $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "usuario", 0, "Modificación de contraseña para usuario {nombre_usuario => $username}");
			return $datas;
		}return null;
	}

	function getVisibleUsersByInstitution($institucion = null) {
		include_once("db_config.php");

		$datas = $db->select("viga_usuarios",
		[
			"[><]viga_perfiles" => ["id_perfil" => "id_perfil"]
		],
		[
			"viga_usuarios.nombre",
			"viga_usuarios.nombre_usuario",
			"viga_usuarios.apellido",
			"viga_usuarios.correo_electronico",
			"viga_usuarios.telefono",
			"viga_usuarios.estado",
			"viga_perfiles.id_perfil(id_perfil)",
			"viga_perfiles.nombre(perfil)"
		],
		[
			"visible" => "1",
			"viga_perfiles.institucion" => $institucion
		]);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		return $datas;
	}

	function getVisibleUsers() {
		include_once("db_config.php");

		$datas = $db->select("viga_usuarios",
		[
			"[><]viga_perfiles" => ["id_perfil" => "id_perfil"]
		],
		[
			"viga_usuarios.nombre",
			"viga_usuarios.nombre_usuario",
			"viga_usuarios.apellido",
			"viga_usuarios.correo_electronico",
			"viga_usuarios.telefono",
			"viga_usuarios.estado",
			"viga_perfiles.id_perfil(id_perfil)",
			"viga_perfiles.nombre(perfil)"
		],
		[
			"visible" => "1"
		]);

		return $datas;
	}

	function validateUser($username = null, $contrasenia = null) {
		include_once("db_config.php");

		$datas = $db->select("viga_usuarios",
		[
			"[><]viga_perfiles" => ["id_perfil" => "id_perfil"]
		],
		[
			"viga_usuarios.nombre_usuario",
			"viga_usuarios.nombre",
			"viga_usuarios.apellido",
			"viga_usuarios.correo_electronico",
			"viga_usuarios.telefono",
			"viga_perfiles.nombre(perfil)",
			"viga_perfiles.permiso_usuarios(permiso_usuarios)",
			"viga_perfiles.permiso_objetivos(permiso_objetivos)",
			"viga_perfiles.permiso_iniciativas(permiso_iniciativas)",
			"viga_perfiles.permiso_desafios(permiso_desafios)",
			"viga_perfiles.permiso_estadisticas(permiso_estadisticas)",
			"viga_perfiles.permiso_parametros(permiso_parametros)",
			"viga_perfiles.institucion(permiso_institucion)",
		], [
			"nombre_usuario" => $username,
			"contrasenia" => hash("sha256", $contrasenia),
			"estado" => "1"
		]);

		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}




?>
