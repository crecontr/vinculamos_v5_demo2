<?php

	/*
		SELECT `id`, `nombre`, `visible`
		FROM `viga_evaluacion_tipo_evaluador` WHERE 1
	*/

	function getEvaluationTypes($institucion = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_tipo_evaluador",
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
