<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `archivo`, `id_iniciativa`,
			`visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_iniciativas_evidencias` WHERE 1
	*/

	function addEvidence($nombre = null, $descripcion = null, $id_iniciativa = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_iniciativas_evidencias",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"id_iniciativa" => $id_iniciativa,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);
		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_iniciativas_evidencias", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_evidencia", $id, "Nuevo registro con valores {nombre => $nombre, descripción => $descripcion, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function editEvidence($id = null, $nombre = null, $descripcion = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas_evidencias",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"id_iniciativa" => $id_iniciativa
			],
			[
				"id" => $id
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_iniciativas_evidencias", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_evidencia", $id, "Modificación en registro con valores {nombre => $nombre, descripción => $descripcion, id_iniciativa => $id_iniciativa}");
			return $datas;
		}return null;
	}

	function editEvidenceFile($id = null, $id_iniciativa = null, $archivo = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas_evidencias",
			[
				"archivo" => $archivo
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_iniciativas_evidencias", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["archivo"] == $archivo) $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_evidencia", $id, "Modificación en registro con valores {archivo => $archivo}");
			return $datas;
		}return null;
	}

	function deleteEvidence($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas_evidencias",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_iniciativas_evidencias", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_evidencia", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getEvidences($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas_evidencias",
			[
				"id",
				"nombre",
				"descripcion",
				"archivo",
				"id_iniciativa",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id" => $id
			]
		);

		return $datas;
	}

	function getVisibleEvidencesByInitiative($id_iniciativa = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas_evidencias",
			[
				"id",
				"nombre",
				"descripcion",
				"archivo",
				"id_iniciativa",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa,
				"ORDER" => [
					"viga_iniciativas_evidencias.fecha_creacion" => "DESC",
				]
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

?>
