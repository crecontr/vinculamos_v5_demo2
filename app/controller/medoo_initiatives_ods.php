<?php
	/*
		SELECT `id`, `id_iniciativa`, `id_objetivo`, `id_meta`, `visible`, `fecha_creacion`
		FROM `viga_iniciativas_ods` WHERE 1
	*/

	function getODSByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_objetivos`.`id`,`viga_objetivos`.`nombre`
			FROM `viga_objetivos` INNER JOIN `viga_iniciativas_ods` ON `viga_objetivos`.`id` = `viga_iniciativas_ods`.`id_objetivo`
			WHERE `viga_iniciativas_ods`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateODSByInitiative($idInitiative = null, $metas = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_ods", [
				"id_iniciativa" => $idInitiative
			]
		);
		//echo "<br>query: " . $db->last();

		$metasForLog = "";
		for($i=0; $i<sizeof($metas); $i++) {
			$db->insert("viga_iniciativas_ods", [
				"id_iniciativa" => $idInitiative,
				"id_objetivo" => $metas[$i]["id_objetivo"],
				"id_meta" => $metas[$i]["id"]
			]);

			$metasForLog .= ($metas[$i][""] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_ods", $idInitiative, "Modificación de ambito con valores {units => [$metasForLog], autor => $autor}");
			return $datas;
		}
	}
?>
