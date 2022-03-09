<?php

	/*
		SELECT `id`, `tipo_evaluador`, `clave`, `orden_visible`
		FROM `viga_evaluacion_tipo_evaluador_config` WHERE 1
	*/

	function getEvaluationTypesConfigByType($type = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_tipo_evaluador_config",
			[
				"id",
				"tipo_evaluador",
				"clave",
				"orden_visible"
			],
			[
				"tipo_evaluador" => $type,
				"ORDER" => [
	        "orden_visible" => "ASC"
	      ]
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

?>
