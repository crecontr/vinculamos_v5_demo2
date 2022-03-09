<?php

	/*
		SELECT `id`, `id_iniciativa`, `tipo_evaluacion`, `visible`, `fecha_creacion`
		FROM `viga_evaluacion_iniciativa` WHERE 1
	*/

	function addEvaluation($id_iniciativa = null, $tipo = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_evaluacion_iniciativa",
			[
				"id_iniciativa" => $id_iniciativa,
				"tipo_evaluacion" => $tipo
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_evaluacion_iniciativa", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["tipo_evaluacion"] == $tipo) $verificator++;

		if($verificator == 2) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "evaluacion", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa, tipo_evaluacion => $tipo}");
			return $datas;
		}return null;
	}

	function getEvaluationById($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id",
				"id_iniciativa",
				"tipo_evaluacion",
				"visible",
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

	function getEvaluationByInitiativeIdEvaluation($idInitiative = null, $id = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id",
				"id_iniciativa",
				"tipo_evaluacion",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $idInitiative,
				"id" => $id
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		return $datas;
	}

	function getEvaluationByInitiativeType($idInitiative = null, $type = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id",
				"id_iniciativa",
				"tipo_evaluacion",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $idInitiative,
				"tipo_evaluacion" => $type
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		return $datas;
	}

	/*
	function getEvaluationByInitiativeType($idInitiative = null, $type = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_convenios`.`id`,`viga_convenios`.`nombre`
			FROM `viga_convenios` INNER JOIN `viga_iniciativas_convenio` ON `viga_convenios`.`id` = `viga_iniciativas_convenio`.`id_convenio`
			WHERE `viga_iniciativas_convenio`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}
	*/

	function updateCovenantsByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_convenio", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<count($units); $i++) {
			$db->insert("viga_iniciativas_convenio", [
				"id_iniciativa" => $idInitiative,
				"id_convenio" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_convenio", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
