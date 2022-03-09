<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `id_programa`, `visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_programas_estrategias_estrategias` WHERE 1
	*/

	function addProgramStrategy($nombre = null, $descripcion = null, $id_programa = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_programas_estrategias",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"id_programa" => $id_programa,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_programas_estrategias", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["id_programa"] == $id_programa) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa_estrategia", $id, "Nuevo registro con valores {nombre => $nombre, descripción => $descripcion, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function editProgramStrategy($id = null, $nombre = null, $descripcion = null, $id_programa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_programas_estrategias",
			[
				"nombre" => $nombre,
				"descripcion" => $descripcion,
				"id_programa" => $id_programa
			],
			[
				"id" => $id
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_programas_estrategias", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["id_programa"] == $id_programa) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa_estrategia", $id, "Modificación en registro con valores {nombre => $nombre, descripción => $descripcion, id_programa => $id_programa}");
			return $datas;
		}return null;
	}

	function deleteProgramStrategy($id = null, $id_programa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_programas_estrategias",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_programa" => $id_programa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_programas_estrategias", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa_estrategia", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getProgramStrategy($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_programas_estrategias",
			[
				"id",
				"nombre",
				"descripcion",
				"id_programa",
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

	function getVisibleProgramStrategiesByProgram($id_program = null) {
		include("db_config.php");

		$datas = $db->select("viga_programas_estrategias",
			[
				"id",
				"nombre",
				"descripcion",
				"id_programa",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_programa" => $id_program
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getProgramStrategiesByInitiative($idInitiative = null, $idProgram = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_programas_estrategias`.`id`, `viga_programas_estrategias`.`id_programa`,`viga_programas_estrategias`.`nombre`
			FROM `viga_programas_estrategias` INNER JOIN `viga_iniciativas_programa_estrategia` ON `viga_programas_estrategias`.`id` = `viga_iniciativas_programa_estrategia`.`id_programa_estrategia`
			WHERE `viga_iniciativas_programa_estrategia`.`id_iniciativa` = '$idInitiative'
			AND `viga_iniciativas_programa_estrategia`.`id_programa` = '$idProgram' "
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateProgramStrategiesByInitiative($idInitiative = null, $idProgram = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_programa_estrategia", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_programa_estrategia", [
				"id_iniciativa" => $idInitiative,
				"id_programa" => $idProgram,
				"id_programa_estrategia" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_programa_estrategia", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
