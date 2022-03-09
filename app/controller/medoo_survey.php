<?php

	/*
		SELECT `id`, `id_iniciativa`, `tipo`, `autor`, `visible`, `fecha_creacion`
		FROM `viga_encuesta` WHERE 1
	*/

	function getSurvey($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta",
			[
				"id",
				"id_iniciativa",
				"tipo",
				"titulo",
				"descripcion",
				"correo_asunto",
				"correo_mensaje",
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

	function addSurvey($id_iniciativa = null, $tipo = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_encuesta",
			[
				"id_iniciativa" => $id_iniciativa,
				"tipo" => $tipo
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_encuesta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["tipo"] == $tipo) $verificator++;

		if($verificator == 2) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa, rut => $rut}");
			return $datas;
		}return null;
	}

	function editSurvey($id = null, $id_iniciativa = null, $titulo = null, $descripcion = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_encuesta",
			[
				"titulo" => $titulo,
				"descripcion" => $descripcion
			],[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa,
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_encuesta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["titulo"] == $titulo) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;

		if($verificator == 2) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta", $id, "Modificación de registro con valores {titulo => $titulo, descripcion => $descripcion}");
			return $datas;
		}return null;
	}

	function editSurveyEmail($id = null, $id_iniciativa = null, $asunto = null, $mensaje = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_encuesta",
			[
				"correo_asunto" => $asunto,
				"correo_mensaje" => $mensaje
			],[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa,
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_encuesta", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["correo_asunto"] == $asunto) $verificator++;
		if($datas[0]["correo_mensaje"] == $mensaje) $verificator++;

		if($verificator == 2) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta", $id, "Modificación de registro con valores {correo_asunto => $asunto, correo_mensaje => $mensaje}");
			return $datas;
		}return null;
	}

	function deleteSurvey($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_encuesta",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_encuesta", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "encuesta", $id, "Eliminación de registro con valores {id => $id, id_iniciativa => $id_iniciativa, visible => -1}");
			return $datas;
		}return null;
	}

	function getVisibleSurveyByInitiative($id_iniciativa = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta",
			[
				"id", "id_iniciativa", "tipo", "titulo", "descripcion", "correo_asunto", "correo_mensaje", "autor", "visible", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleSurveyByInitiativeType($id_iniciativa = null, $type = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta",
			[
				"id", "id_iniciativa", "tipo", "titulo", "descripcion", "correo_asunto", "correo_mensaje", "autor", "visible", "fecha_creacion"
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

	function getVisibleSurveyByInitiativeInternalImpact($id_iniciativa = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta",
			[
				"id", "id_iniciativa", "tipo", "titulo", "descripcion", "correo_asunto", "correo_mensaje", "autor", "visible", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa,
				"tipo" => ["Estudiantes", "Titulados", "Docentes"]
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleSurveyByInitiativeExternalImpact($id_iniciativa = null) {
		include("db_config.php");

		$datas = $db->select("viga_encuesta",
			[
				"id", "id_iniciativa", "tipo", "titulo", "descripcion", "correo_asunto", "correo_mensaje", "autor", "visible", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa,
				"tipo" => ["Representantes de Pymes", "Empleadores", "Emprendedores", "Público general"]
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}
?>
