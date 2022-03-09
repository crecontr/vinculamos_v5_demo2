<?php

	/*
		SELECT `id`, `id_mecanismo`, `id_programa`, `visible`, `institucion`, `autor`, `fecha_creacion`
		FROM `viga_programas_tipo_accion_estrategias` WHERE 1
	*/

	function addProgramActionType($mecanismo = null, $id_programa = null, $autor = null, $institucion = null) {
		include("db_config.php");

		$db->insert("viga_programas_tipo_accion",
			[
				"id_mecanismo" => $mecanismo,
				"id_programa" => $id_programa,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_programas_tipo_accion", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_mecanismo"] == $mecanismo) $verificator++;
		if($datas[0]["id_programa"] == $id_programa) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 4) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa_tipo_accion", $id, "Nuevo registro con valores {id_mecanismo => $mecanismo, institucion => $institucion}");
			return $datas;
		}return null;
	}

	function deleteActionType($id_mecanismo = null, $id_programa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_programas_tipo_accion",
			[
				"visible" => "-1",
			],
			[
				"id_mecanismo" => $id_mecanismo,
				"id_programa" => $id_programa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_programas_tipo_accion", "*", ["id_mecanismo" => $id_mecanismo, "id_programa" => $id_programa]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "programa_tipo_accion", $id, "Eliminación de registro con valores {id => $id, visible => -1}");
			return $datas;
		}return null;
	}

	function getVisibleActionTypesByProgram($id_program = null) {
		include("db_config.php");

		$datas = $db->select("viga_programas_tipo_accion",
			[
				"id",
				"id_mecanismo",
				"id_programa",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"id_programa" => $id_program
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

?>
