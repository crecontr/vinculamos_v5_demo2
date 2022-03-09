<?php

	function addEvaluationAnswer($id_iniciativa = null, $id_evaluacion = null,
		$correo_evaluador = null, $clave = null, $valor = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_evaluacion_detalle_respuesta",
			[
				"id_iniciativa" => $id_iniciativa,
				"id_evaluacion" => $id_evaluacion,
				"correo_evaluador" => $correo_evaluador,
				"clave" => $clave,
				"valor" => $valor,
				"autor" => $autor
			]
		);
		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_evaluacion_detalle_respuesta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["id_evaluacion"] == $id_evaluacion) $verificator++;
		if($datas[0]["correo_evaluador"] == $correo_evaluador) $verificator++;
		if($datas[0]["clave"] == $clave) $verificator++;
		if($datas[0]["valor"] == $valor) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;

		if($verificator == 6) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "evaluacion_respuestas", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa, id_evaluacion => $id_evaluacion, correo_evaluador => $correo_evaluador, clave => $clave, valor => $valor, autor => $autor}");
			return $datas;
		}return null;
	}

	function getVisibleEvaluationAnswerByInitiativeIdEvaluationEmail(
		$id_iniciativa = null, $id_evaluation = null, $correo = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_detalle_respuesta",
			[
				"id",
				"id_iniciativa",
				"id_evaluacion",
				"correo_evaluador",
				"clave",
				"valor",
				"autor"
			],
			[
				"id_iniciativa" => $id_iniciativa,
				"id_evaluacion" => $id_evaluation,
				"correo_evaluador" => $correo
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleEvaluationAnswerByInitiativeKey(
		$id_iniciativa = null, $id_evaluation = null, $key = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_detalle_respuesta",
			[
				"id",
				"id_iniciativa",
				"id_evaluacion",
				"correo_evaluador",
				"clave",
				"valor",
				"autor"
			],
			[
				"id_iniciativa" => $id_iniciativa,
				"id_evaluacion" => $id_evaluation,
				"clave[~]" => $key,
				"valor[!]" => ""
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	/*
	function deleteEvaluator($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_evaluacion_detalle_respuesta",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_evaluacion_detalle_respuesta", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "evaluacion_evaluadores", $id, "Eliminación de registro con valores {id => $id, id_iniciativa => $id_iniciativa, visible => -1}");
			return $datas;
		}return null;
	}


	function getVisibleEvaluatorsByInitiativeIdEvaluation($id_iniciativa = null, $id_evaluation = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_detalle_respuesta",
			[
				"id", "id_iniciativa", "id_evaluacion", "tipo_evaluacion", "nombre", "correo_electronico",
				"estado", "visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa,
				"id_evaluacion" => $id_evaluation
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleEvaluatorsByInitiativeType($id_iniciativa = null, $type = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_detalle_respuesta",
			[
				"id", "id_iniciativa", "tipo_evaluacion", "nombre", "correo_electronico",
				"estado", "visible", "autor", "fecha_creacion"
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

	/*

	function answerSurvey($id_iniciativa = null, $correo = null, $pregunta1 = null, $pregunta2 = null, $pregunta3 = null, $pregunta4 = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_evaluacion_detalle_respuesta",
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

		$datas = $db->select("viga_evaluacion_detalle_respuesta", "*", ["id_iniciativa" => $id_iniciativa, "correo_electronico" => $correo]);

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

		$db->update("viga_evaluacion_detalle_respuesta",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_evaluacion_detalle_respuesta", "*", ["id" => $id]);

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

		$datas = $db->select("viga_evaluacion_detalle_respuesta",
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

	function getVisibleAttendanceByInitiativeAttendanceType($id_iniciativa = null, $correo = null, $tipo = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_detalle_respuesta",
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

	*/
?>
