<?php

	function getVisibleCountries() {
		include("db_config.php");

		$datas = $db->select("viga_geo_pais",
			[
				"id",
				"nombre"
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getCountriesByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_geo_pais`.`id`,`viga_geo_pais`.`nombre`
			FROM `viga_geo_pais` INNER JOIN `viga_iniciativas_geo_pais` ON `viga_geo_pais`.`id` = `viga_iniciativas_geo_pais`.`id_pais`
			WHERE `viga_iniciativas_geo_pais`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateCountriesByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_geo_pais", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_geo_pais", [
				"id_iniciativa" => $idInitiative,
				"id_pais" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa_geo_pais", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

	function getVisibleRegions() {
		include("db_config.php");

		$datas = $db->select("viga_geo_region",
			[
				"id",
				"nombre"
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleRegionsByCountry($country = null) {
		include("db_config.php");

		$datas = $db->select("viga_geo_region",
			[
				"id",
				"nombre"
			],
			[
				"id_pais" => $country
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getRegionsByResponsible($idResponsible = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_geo_region`.`id`,`viga_geo_region`.`nombre`
			FROM `viga_geo_region` INNER JOIN `viga_iniciativas_geo_region` ON `viga_geo_region`.`id` = `viga_iniciativas_geo_region`.`id_region`
				INNER JOIN `viga_iniciativas` ON `viga_iniciativas`.`id` = `viga_iniciativas_geo_region`.`id_iniciativa`
			WHERE `viga_iniciativas`.`id_responsable` = '$idResponsible'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getRegionsByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_geo_region`.`id`,`viga_geo_region`.`nombre`
			FROM `viga_geo_region` INNER JOIN `viga_iniciativas_geo_region` ON `viga_geo_region`.`id` = `viga_iniciativas_geo_region`.`id_region`
			WHERE `viga_iniciativas_geo_region`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateRegionsByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_geo_region", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_geo_region", [
				"id_iniciativa" => $idInitiative,
				"id_region" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa_geo_region", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

	function getVisibleCommunes() {
		include("db_config.php");

		$datas = $db->select("viga_geo_comuna",
			[
				"id",
				"nombre"
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getVisibleCommuneByRegion($region = null) {
		include("db_config.php");

		$datas = $db->select("viga_geo_comuna",
			[
				"id",
				"nombre"
			],
			[
				"id_region" => $region
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getCommunesByResponsible($idResponsible = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_geo_comuna`.`id`,`viga_geo_comuna`.`nombre`
			FROM `viga_geo_comuna` INNER JOIN `viga_iniciativas_geo_comuna` ON `viga_geo_comuna`.`id` = `viga_iniciativas_geo_comuna`.`id_comuna`
					INNER JOIN `viga_iniciativas` ON `viga_iniciativas`.`id` = `viga_iniciativas_geo_comuna`.`id_iniciativa`
			WHERE `viga_iniciativas`.`id_responsable` = '$idResponsible'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getCommunesByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_geo_comuna`.`id`,`viga_geo_comuna`.`nombre`
			FROM `viga_geo_comuna` INNER JOIN `viga_iniciativas_geo_comuna` ON `viga_geo_comuna`.`id` = `viga_iniciativas_geo_comuna`.`id_comuna`
			WHERE `viga_iniciativas_geo_comuna`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateCommunesByInitiative($idInitiative = null, $units = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativas_geo_comuna", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$unitsForLog = "";
		for($i=0; $i<sizeof($units); $i++) {
			$db->insert("viga_iniciativas_geo_comuna", [
				"id_iniciativa" => $idInitiative,
				"id_comuna" => $units[$i]
			]);

			$unitsForLog .= ($units[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa_geo_comuna", $idInitiative, "Modificación de ambito con valores {units => [$unitsForLog], autor => $autor}");
			return $datas;
		}
	}

?>
