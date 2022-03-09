<?php
	function getConsideratedProfilesByInstitution($institucion = null) {
		include("db_config.php");
		$datas = $db->select("viga_perfiles",
			[
				"id_perfil",
				"nombre"
			],
			[
				"id_perfil[!]" => 100,
				"institucion" => $institucion
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function getConsideratedProfiles() {
		include("db_config.php");
		$datas = $db->select("viga_perfiles",
		[
			"id_perfil",
			"nombre"
		],[
			"id_perfil[!]" => 100
		]);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		return $datas;
	}

?>
