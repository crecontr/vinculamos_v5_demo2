<?php

	/*
		SELECT `id`, `nombre`, `descripcion`, `director`, `visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_tipo_impacto_externo` WHERE 1
	*/

	function getExternalImpactByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_tipo_impacto_externo`.`id`,`viga_tipo_impacto_externo`.`nombre`
			FROM `viga_tipo_impacto_externo` INNER JOIN `viga_iniciativas_impacto_externo` ON `viga_tipo_impacto_externo`.`id` = `viga_iniciativas_impacto_externo`.`id_impacto_externo`
			WHERE `viga_iniciativas_impacto_externo`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateExternalImpactByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_impacto_externo", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_impacto_externo", [
				"id_iniciativa" => $idInitiative,
				"id_impacto_externo" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_impacto_interno", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
