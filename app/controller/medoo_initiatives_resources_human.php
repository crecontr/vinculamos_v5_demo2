<?php
	/*
		SELECT `id`, `id_iniciativa`, `fuente`, `tipo`, `horas`, `valorizacion`, `visible`, `autor`, `fecha_creacion`
		FROM `viga_iniciativas_recurso_humano` WHERE 1
	*/

	function getVisibleHumanResourcesByInitiative($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas_recurso_humano",
			[
				"id",
				"id_iniciativa",
				"fuente",
				"tipo",
				"horas",
				"valorizacion",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"id_iniciativa" => $id,
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getVisibleHumanResourcesByInitiativeSource($id = null, $fuente = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas_recurso_humano",
			[
				"id",
				"id_iniciativa",
				"fuente",
				"tipo",
				"horas",
				"valorizacion",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"id_iniciativa" => $id,
				"fuente" => $fuente,
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function sumHumanResourcesByInitiative($id = null) {
		include("db_config.php");

		$datas = $db->sum("viga_iniciativas_recurso_humano", "valorizacion",
			[
				"visible" => "1",
				"id_iniciativa" => $id
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function addHumanResource($id_iniciativa = null, $fuente = null, $tipo = null, $horas = null,
		$valorizacion = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_iniciativas_recurso_humano",
			[
				"id_iniciativa" => $id_iniciativa,
				"fuente" => $fuente,
				"tipo" => $tipo,
				"valorizacion" => $valorizacion,
				"horas" => $horas,
				"autor" => $autor,
			]
		);
		//echo "query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_iniciativas_recurso_humano", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["fuente"] == $fuente) $verificator++;
		if($datas[0]["tipo"] == $tipo) $verificator++;
		if($datas[0]["valorizacion"] == $valorizacion) $verificator++;
		if($datas[0]["horas"] == $horas) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;

		if($verificator == 6) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_recurso_humano", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa,
				fuente => $fuente, tipo => $tipo, valorizacion => $valorizacion, horas => $horas, autor => $autor }");
			return $datas;
		}return null;
	}

	function deleteHumanResource($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas_recurso_humano",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas_recurso_humano", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_recurso_humano", $id, "Eliminar registro con valores {id => $id,
				id_iniciativa => $id_iniciativa, autor => $autor }");
			return $datas;
		}return null;
	}
?>
