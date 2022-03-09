<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `director`, `visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_carreras` WHERE 1
	*/

	function addCarrer($nombre = null, $descripcion = null, $director = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_carreras",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"director" => $director,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_carreras", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["director"] == $director) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "carrera", $id, "Nuevo registro con valores {nombre => $nombre, descripción => $descripcion, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function editCarrer($id = null, $nombre = null, $descripcion = null, $director = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_carreras",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"director" => $director
			],
			[
				"id" => $id
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_carreras", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["director"] == $director) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "carrera", $id, "Modificación en registro con valores {nombre => $nombre, descripción => $descripcion, director => $director}");
			return $datas;
		}return null;
	}

	function deleteCarrer($id = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_carreras",
			[
				"visible" => "-1",
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_carreras", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "carrera", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getCarrer($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_carreras",
			[
				"id",
				"nombre",
				"descripcion",
				"director",
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

	function getVisibleCarrersByInstitution($institucion = null) {
		include("db_config.php");

		$datas = $db->select("viga_carreras",
			[
				"id",
				"nombre",
				"descripcion",
				"director",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"institucion" => $institucion
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleCarrersByInstitutionId($institucion = null, $id = null) {
		include("db_config.php");

		$datas = $db->select("viga_carreras",
			[
				"id",
				"nombre",
				"descripcion",
				"director",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"institucion" => $institucion,
				"id" => $id
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleCarrers() {
		include("db_config.php");

		$datas = $db->select("viga_carreras",
			[
				"id",
				"nombre",
				"descripcion",
				"director",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);

		return $datas;
	}

	function getCarrersByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_carreras`.`id`,`viga_carreras`.`nombre`
			FROM `viga_carreras` INNER JOIN `viga_iniciativas_carrera` ON `viga_carreras`.`id` = `viga_iniciativas_carrera`.`id_carrera`
			WHERE `viga_iniciativas_carrera`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateCarrersByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_carrera", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_carrera", [
				"id_iniciativa" => $idInitiative,
				"id_carrera" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_carrera", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
