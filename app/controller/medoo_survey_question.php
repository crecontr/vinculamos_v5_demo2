<?php

	/*
		SELECT `id`, `id_encuesta`, `titulo`, `tipo_respuesta`, `autor`, `visible`, `fecha_creacion`
		FROM `viga_encuesta_pregunta` WHERE 1
	*/

	function getQuestion($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_pregunta",
			[
				"id",
				"id_encuesta",
				"titulo",
				"tipo_respuesta",
				"autor",
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

	function addQuestion($id_encuesta = null, $titulo = null, $tipo_respuesta = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_encuesta_pregunta",
			[
				"id_encuesta" => $id_encuesta,
				"titulo" => $titulo,
				"tipo_respuesta" => $tipo_respuesta,
				"autor" => $autor
			]
		);
		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_encuesta_pregunta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_encuesta"] == $id_encuesta) $verificator++;
		if($datas[0]["titulo"] == $titulo) $verificator++;
		if($datas[0]["tipo_respuesta"] == $tipo_respuesta) $verificator++;

		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta_pregunta", $id, "Nuevo registro con valores {id_encuesta => $id_encuesta, titulo => $titulo, tipo_respuesta => $tipo_respuesta}");
			return $datas;
		}return null;
	}

	function editQuestion($id = null, $id_encuesta = null, $titulo = null, $tipo_respuesta = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_encuesta_pregunta",
			[
				"titulo" => $titulo,
				"tipo_respuesta" => $tipo_respuesta
			],[
				"id" => $id,
				"id_encuesta" => $id_encuesta,
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_encuesta_pregunta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["titulo"] == $titulo) $verificator++;
		if($datas[0]["tipo_respuesta"] == $tipo_respuesta) $verificator++;

		if($verificator == 2) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta_pregunta", $id, "Modificación de registro con valores {titulo => $titulo, tipo_respuesta => $tipo_respuesta}");
			return $datas;
		}return null;
	}

	function deleteQuestion($id = null, $id_encuesta = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_encuesta_pregunta",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_encuesta" => $id_encuesta
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_encuesta_pregunta", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta_pregunta", $id, "Eliminación de registro con valores {id => $id, id_encuesta => $id_encuesta, visible => -1}");
			return $datas;
		}return null;
	}

	function getVisibleQuestionsBySurvey($id_encuesta = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_pregunta",
			[
				"id", "id_encuesta", "titulo", "tipo_respuesta", "autor", "visible", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_encuesta" => $id_encuesta
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleQuestionsByInitiativeType($id_encuesta = null, $type = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_pregunta",
			[
				"id", "id_encuesta", "titulo", "tipo_respuesta", "autor", "visible", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_encuesta" => $id_encuesta,
				"tipo" => $type
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}
?>
