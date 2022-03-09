<?php

	/*
		SELECT `id`, `id_iniciativa`, `rut`, `nombre`, `correo_electronico`, `telefono`, `visible`, `autor`, `fecha_creacion`
		FROM `viga_lista_asistencia` WHERE 1
	*/

	function getAttendance($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_lista_asistencia",
			[
				"id",
				"id_iniciativa",
				"tipo",
				"rut",
				"nombre",
				"correo_electronico",
				"visible",
				"fecha_creacion"
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function addAttendance($id_iniciativa = null, $tipo = null, $rut = null, $nombre = null, $correo = null, $telefono = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_lista_asistencia",
			[
				"id_iniciativa" => $id_iniciativa,
				"tipo" => $tipo,
				"rut" => $rut,
				"nombre" => $nombre,
				"correo_electronico" => $correo,
				"telefono" => $telefono,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_lista_asistencia", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["tipo"] == $tipo) $verificator++;
		if($datas[0]["rut"] == $rut) $verificator++;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["correo_electronico"] == $correo) $verificator++;
		if($datas[0]["telefono"] == $telefono) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;

		if($verificator == 7) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "lista_asistencia", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa, rut => $rut, nombre => $nombre, correo_electronico => $correo, telefono => $telefono, autor => $autor}");
			return $datas;
		}return null;
	}

	function answerSurvey($id_iniciativa = null, $correo = null, $pregunta1 = null, $pregunta2 = null, $pregunta3 = null, $pregunta4 = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_lista_asistencia",
			[
				"estado" => "Respondido",
				"pregunta1" => $pregunta1,
				"pregunta2" => $pregunta2,
				"pregunta3" => $pregunta3,
				"pregunta4" => $pregunta4
			],
			[
				"id_iniciativa" => $id_iniciativa,
				"correo_electronico" => $correo
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_lista_asistencia", "*", ["id_iniciativa" => $id_iniciativa, "correo_electronico" => $correo]);

		$verificator = 0;
		if($datas[0]["estado"] == "Respondido") $verificator++;
		if($datas[0]["pregunta1"] == $pregunta1) $verificator++;
		if($datas[0]["pregunta2"] == $pregunta2) $verificator++;
		if($datas[0]["pregunta3"] == $pregunta3) $verificator++;
		if($datas[0]["pregunta4"] == $pregunta4) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "lista_asistencia", $id, "Modificación de registro con valores {id_iniciativa => $id_iniciativa, pregunta1 => $pregunta1, pregunta2 => $pregunta2, pregunta3 => $pregunta3, pregunta4 => $pregunta4}");
			return $datas;
		}return null;
	}

	function deleteAttendance($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_lista_asistencia",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_lista_asistencia", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "lista_asistencia", $id, "Eliminación de registro con valores {id => $id, id_iniciativa => $id_iniciativa, visible => -1}");
			return $datas;
		}return null;
	}

	function getVisibleAttendanceByInitiative($id_iniciativa = null) {
		include("db_config.php");

		$datas = $db->select("viga_lista_asistencia",
			[
				"id", "id_iniciativa", "tipo", "rut", "nombre", "correo_electronico", "telefono",
				"estado", "pregunta1", "pregunta2", "pregunta3", "pregunta4", "visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleAttendanceByInitiativeType($id_iniciativa = null, $type = null) {
		include("db_config.php");

		$datas = $db->select("viga_lista_asistencia",
			[
				"id", "id_iniciativa", "tipo", "rut", "nombre", "correo_electronico", "telefono",
				"estado", "pregunta1", "pregunta2", "pregunta3", "pregunta4", "visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa,
				"tipo" => $type
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleAttendanceByInitiativeAttendanceType($id_iniciativa = null, $correo = null, $tipo = null) {
		include("db_config.php");

		$datas = $db->select("viga_lista_asistencia",
			[
				"id", "id_iniciativa", "tipo", "rut", "nombre", "correo_electronico", "telefono",
				"estado", "visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa,
				"correo_electronico" => $correo,
				"tipo" => $tipo
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}
?>
