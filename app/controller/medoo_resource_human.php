<?php
	/*
		SELECT `id`, `nombre`, `descripcion`, `visible`, `autor`, `fecha_creacion`
		FROM `viga_tipo_recurso_humano` WHERE 1
	*/

	function getHumanResourcesTypeByNombre($nombre = null) {
		include("db_config.php");

		$datas = $db->select("viga_tipo_recurso_humano",
			[
				"id",
				"nombre",
				"puntaje",
				"descripcion",
				"visible",
				"fecha_creacion"
			],
			[
				"nombre" => $nombre
			]
		);

		//echo "<br>query: " . $db->last();

		return $datas;
	}

	function getVisibleHumanResourcesTypes() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_recurso_humano",
			[
				"id",
				"nombre",
				"puntaje",
				"descripcion",
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
