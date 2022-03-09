<?php

	/*
		SELECT `id`, `nombre`, `visible`, `fecha_creacion`
		FROM `viga_entornos_significativos_sub` WHERE 1
	*/

	function getVisibleEnvironmentsSub($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_entornos_significativos_sub",
			[
				"id",
				"id_entorno",
				"nombre",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id" => $id,
				"ORDER" => [
					"nombre" => "ASC",
				]
			]
		);

		return $datas;
	}

	function getVisibleEnvironmentsSubByEnvironment($id_environment = null) {
		include("db_config.php");

		$datas = $db->select("viga_entornos_significativos_sub",
			[
				"id",
				"id_entorno",
				"nombre",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_entorno" => $id_environment,
				"ORDER" => [
					"nombre" => "ASC",
				]
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getEnvironmentsSubsByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_entornos_significativos_sub`.`id`,`viga_entornos_significativos_sub`.`nombre`
			FROM `viga_entornos_significativos_sub` INNER JOIN `viga_iniciativas_entornos_significativos_sub` ON `viga_entornos_significativos_sub`.`id` = `viga_iniciativas_entornos_significativos_sub`.`id_entorno_sub`
			WHERE `viga_iniciativas_entornos_significativos_sub`.`id_iniciativa` = '$idInitiative' "
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateEnvironmentsSubsByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_entornos_significativos_sub", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_entornos_significativos_sub", [
				"id_iniciativa" => $idInitiative,
				"id_entorno_sub" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_entorno_sub", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
