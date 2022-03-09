<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `archivo`, `id_convenio`,
			`visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_convenios_docs` WHERE 1
	*/

	function addCovenantDoc($nombre = null, $descripcion = null, $id_convenio = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_convenios_docs",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"id_convenio" => $id_convenio,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_convenios_docs", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["id_convenio"] == $id_convenio) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "convenio_doc", $id, "Nuevo registro con valores {nombre => $nombre, descripción => $descripcion, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function editCovenantDoc($id = null, $nombre = null, $descripcion = null, $id_convenio = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_convenios_docs",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"id_convenio" => $id_convenio
			],
			[
				"id" => $id
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_convenios_docs", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["id_convenio"] == $id_convenio) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "convenio_doc", $id, "Modificación en registro con valores {nombre => $nombre, descripción => $descripcion, id_convenio => $id_convenio}");
			return $datas;
		}return null;
	}

	function editCovenantDocFile($id = null, $id_convenio = null, $archivo = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_convenios_docs",
			[
				"archivo" => $archivo
			],
			[
				"id" => $id,
				"id_convenio" => $id_convenio
			]
		);
		echo "<br>query: " . $db->last();

		$datas = $db->select("viga_convenios_docs", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["archivo"] == $archivo) $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "convenio_doc", $id, "Modificación en registro con valores {archivo => $archivo}");
			return $datas;
		}return null;
	}

	function deleteCovenantDoc($id = null, $id_convenio = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_convenios_docs",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_convenio" => $id_convenio
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_convenios_docs", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "convenio_doc", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getCovenantDocs($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_convenios_docs",
			[
				"id",
				"nombre",
				"descripcion",
				"archivo",
				"id_convenio",
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

	function getVisibleCovenantDocsByCovenant($id_convenio = null) {
		include("db_config.php");

		$datas = $db->select("viga_convenios_docs",
			[
				"id",
				"nombre",
				"descripcion",
				"archivo",
				"id_convenio",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_convenio" => $id_convenio
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

?>
