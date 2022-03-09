<?php
	/*
		SELECT `id`, `nombre`, `descripcion`, `visible`, `autor`, `fecha_creacion`
		FROM `viga_tipo_recurso_infraestructura` WHERE 1
	*/

	function getBuildingResourcesTypeByNombre($nombre = null) {
		include("db_config.php");

		$datas = $db->select("viga_tipo_recurso_infraestructura",
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

	function getVisibleBuildingResourcesTypes() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_recurso_infraestructura",
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
