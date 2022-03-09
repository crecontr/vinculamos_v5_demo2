<?php

	/*
		SELECT `id`, `id_encuesta`, `id_pregunta`, `id_participante`,
			`respuesta`, `visible`, `fecha_creacion`
		FROM `viga_encuesta_respuesta` WHERE 1
	*/

	function getAnswer($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_respuesta",
			[
				"id",
				"id_encuesta",
				"id_pregunta",
				"id_participante",
				"respuesta",
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

	function addAnswer($id_encuesta = null, $id_pregunta = null, $id_participante = null, $respuesta = null) {
		include("db_config.php");

		$db->insert("viga_encuesta_respuesta",
			[
				"id_encuesta" => $id_encuesta,
				"id_pregunta" => $id_pregunta,
				"id_participante" => $id_participante,
				"respuesta" => $respuesta
			]
		);
		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_encuesta_respuesta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_encuesta"] == $id_encuesta) $verificator++;
		if($datas[0]["id_pregunta"] == $id_pregunta) $verificator++;
		if($datas[0]["id_participante"] == $id_participante) $verificator++;
		if($datas[0]["respuesta"] == $respuesta) $verificator++;

		if($verificator == 4) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta_respuesta", $id, "Nuevo registro con valores {id_encuesta => $id_encuesta, id_pregunta => $id_pregunta, id_participante => $id_participante, respuesta => $respuesta}");
			return $datas;
		}return null;
	}

	function getVisibleAnswersBySurvey($id_encuesta = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_respuesta",
			[
				"id",
				"id_encuesta",
				"id_pregunta",
				"id_participante",
				"respuesta",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_encuesta" => $id_encuesta
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleAnswersBySurveyParticipation($id_encuesta = null, $id_participante = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_respuesta",
			[
				"id",
				"id_encuesta",
				"id_pregunta",
				"id_participante",
				"respuesta",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_encuesta" => $id_encuesta,
				"id_participante" => $id_participante
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleAnswersBySurveyQuestion($id_encuesta = null, $id_question = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta_respuesta",
			[
				"id",
				"id_encuesta",
				"id_pregunta",
				"id_participante",
				"respuesta",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_encuesta" => $id_encuesta,
				"id_pregunta" => $id_question
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}
?>
