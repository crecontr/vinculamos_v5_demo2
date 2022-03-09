<?php

	/*
		SELECT `id`, `tipo_evaluador`, `texto`, `orden_visible`
		FROM `viga_evaluacion_conocimiento_ori_pregunta` WHERE 1
	*/

	function getKnowledgeOriQuestionByType($type = null) {
		include("db_config.php");

		$datas = $db->select("viga_evaluacion_conocimiento_ori_pregunta",
			[
				"id",
				"tipo_evaluador",
				"texto",
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
