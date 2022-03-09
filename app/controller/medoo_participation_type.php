<?php
	/*
		SELECT `id`, `nombre`, `tipo_iniciativa`, `visible`, `autor`, `fecha_creacion`
		FROM `viga_tipo_participantes` WHERE 1
	*/

	function getParticipationType($type = null) {
		include("db_config.php");

		$datas = $db->select("viga_tipo_participantes",
			[
				"id",
				"nombre",
				"tipo_iniciativa",
				"visible",
				"fecha_creacion"
			],
			[
				"tipo_iniciativa" => $type
			]
		);

		//echo "<br>query: " . $db->last();

		return $datas;
	}

	function getVisibleParticipationTypes() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_participantes",
			[
				"id",
				"nombre",
				"tipo_iniciativa",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);

		return $datas;
	}



?>
