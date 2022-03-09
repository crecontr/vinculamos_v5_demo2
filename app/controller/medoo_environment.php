<?php
	function getVisibleEnvironments() {
		include("db_config.php");

		$datas = $db->select("viga_entornos_significativos",
			[
				"id",
				"nombre",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getEnvironmentsByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_entornos_significativos`.`id`,`viga_entornos_significativos`.`nombre`
			FROM `viga_entornos_significativos` INNER JOIN `viga_iniciativas_entornos_significativos` ON `viga_entornos_significativos`.`id` = `viga_iniciativas_entornos_significativos`.`id_entorno`
			WHERE `viga_iniciativas_entornos_significativos`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateEnvironmentsByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_entornos_significativos", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_entornos_significativos", [
				"id_iniciativa" => $idInitiative,
				"id_entorno" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa_entorno", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}
?>
