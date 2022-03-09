<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `director`, `visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_programas` WHERE 1
	*/

	function addProgram($nombre = null, $descripcion = null, $director = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_programas",
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
		$datas = $db->select("viga_programas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["director"] == $director) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa", $id, "Nuevo registro con valores {nombre => $nombre, descripción => $descripcion, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function editProgram($id = null, $nombre = null, $descripcion = null, $director = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_programas",
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

		$datas = $db->select("viga_programas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["director"] == $director) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa", $id, "Modificación en registro con valores {nombre => $nombre, descripción => $descripcion, director => $director}");
			return $datas;
		}return null;
	}

	function deleteProgram($id = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_programas",
			[
				"visible" => "-1",
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_programas", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getProgram($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_programas",
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
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		return $datas;
	}

	function getVisibleProgramsByInstitution($institucion = null) {
		include("db_config.php");

		$datas = $db->select("viga_programas",
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

	function getVisibleProgramsByInstitutionId($institucion = null, $id = null) {
		include("db_config.php");

		$datas = $db->select("viga_programas",
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

	function getVisiblePrograms() {
		include("db_config.php");

		$datas = $db->select("viga_programas",
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

	function getProgramsByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_programas`.`id`,`viga_programas`.`nombre`
			FROM `viga_programas` INNER JOIN `viga_iniciativas_programa` ON `viga_programas`.`id` = `viga_iniciativas_programa`.`id_programa`
			WHERE `viga_iniciativas_programa`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateProgramsByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_programa", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_programa", [
				"id_iniciativa" => $idInitiative,
				"id_programa" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_programa", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
