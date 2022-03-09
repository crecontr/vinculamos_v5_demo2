<?php
	/*
		SELECT `id`, `id_iniciativa`, `fuente`, `tipo`, `valorizacion`, `visible`, `autor`, `fecha_creacion`
		FROM `viga_iniciativas_recurso_dinero` WHERE 1
	*/

	function getVisibleCashResourcesByInitiative($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas_recurso_dinero",
			[
				"id",
				"id_iniciativa",
				"fuente",
				"tipo",
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

	function getVisibleCashResourcesByInitiativeSource($id = null, $fuente = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas_recurso_dinero",
			[
				"id",
				"id_iniciativa",
				"fuente",
				"tipo",
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

	function sumCashResourcesByInitiative($id = null) {
		include("db_config.php");

		$datas = $db->sum("viga_iniciativas_recurso_dinero", "valorizacion",
			[
				"visible" => "1",
				"id_iniciativa" => $id
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function addCashResource($id_iniciativa = null, $fuente = null, $tipo = null,
		$valorizacion = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_iniciativas_recurso_dinero",
			[
				"id_iniciativa" => $id_iniciativa,
				"fuente" => $fuente,
				"tipo" => $tipo,
				"valorizacion" => $valorizacion,
				"autor" => $autor,
			]
		);
		//echo "query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_iniciativas_recurso_dinero", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["fuente"] == $fuente) $verificator++;
		if($datas[0]["tipo"] == $tipo) $verificator++;
		if($datas[0]["valorizacion"] == $valorizacion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;

		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_recurso_dinero", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa,
				fuente => $fuente, tipo => $tipo, valorizacion => $valorizacion, autor => $autor }");
			return $datas;
		}return null;
	}

	function deleteCashResource($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas_recurso_dinero",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas_recurso_dinero", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa_recurso_dinero", $id, "Eliminar registro con valores {id => $id,
				id_iniciativa => $id_iniciativa, autor => $autor }");
			return $datas;
		}return null;
	}
?>
