<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `director`, `visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_escuelas` WHERE 1
	*/

	function addCollege($nombre = null, $descripcion = null, $director = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_escuelas",
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
		$datas = $db->select("viga_escuelas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["director"] == $director) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "escuela", $id, "Nuevo registro con valores {nombre => $nombre, descripción => $descripcion, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function editCollege($id = null, $nombre = null, $descripcion = null, $director = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_escuelas",
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

		$datas = $db->select("viga_escuelas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["director"] == $director) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "escuela", $id, "Modificación en registro con valores {nombre => $nombre, descripción => $descripcion, director => $director}");
			return $datas;
		}return null;
	}

	function deleteCollege($id = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_escuelas",
			[
				"visible" => "-1",
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_escuelas", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "escuela", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getCollege($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_escuelas",
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

	function getVisibleCollegesByInstitution($institucion = null) {
		include("db_config.php");

		$datas = $db->select("viga_escuelas",
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

	function getVisibleCollegesByInstitutionId($institucion = null, $id = null) {
		include("db_config.php");

		$datas = $db->select("viga_escuelas",
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

	function getVisibleColleges() {
		include("db_config.php");

		$datas = $db->select("viga_escuelas",
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

	/* RELACIÓN ESCUELA - INICIATIVA */
	function getCollegesByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_escuelas`.`id`,`viga_escuelas`.`nombre`
			FROM `viga_escuelas` INNER JOIN `viga_iniciativas_escuela` ON `viga_escuelas`.`id` = `viga_iniciativas_escuela`.`id_escuela`
			WHERE `viga_iniciativas_escuela`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateCollegesByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_escuela", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_escuela", [
				"id_iniciativa" => $idInitiative,
				"id_escuela" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_escuela", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
