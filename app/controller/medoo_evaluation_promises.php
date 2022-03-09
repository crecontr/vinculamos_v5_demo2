<?php

	/*
		SELECT `id`, `nombre`, `visible`
		FROM `viga_evaluacion_tipo_compromiso` WHERE 1
	*/

	function getEvaluationPromises($institucion = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_tipo_compromiso",
			[
				"id",
				"nombre",
				"visible"
			],
			[
				"visible" => "1"
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

?>
