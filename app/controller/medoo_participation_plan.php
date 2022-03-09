<?php

	/*
		SELECT "id", "id_iniciativa", "publico_general",
			"aplica_sexo", "sexo_masculino", "sexo_femenino", "sexo_otro",
			"aplica_edad", "edad_ninos", "edad_jovenes", "edad_adultos", "edad_adultos_mayores",
			"aplica_procedencia", "procedencia_rural", "procedencia_urbano",
			"visible", "autor", "fecha_creacion"
		FROM "viga_participacion_plan" WHERE 1
	*/

	function addPlanParticipation($id_iniciativa = null, $tipo = null, $publico_general = null,
		$aplica_sexo = null, $sexo_masculino = null, $sexo_femenino = null, $sexo_otro = null,
		$aplica_edad = null, $edad_ninos = null, $edad_jovenes = null, $edad_adultos = null, $edad_adultos_mayores = null,
		$aplica_procedencia = null, $procedencia_rural = null, $procedencia_urbano = null,
		$aplica_vulnerabilidad = null, $vulnerabilidad_pueblo = null, $vulnerabilidad_discapacidad = null, $vulnerabilidad_pobreza = null,
		$aplica_nacionalidad = null, $nacionalidad_chileno = null, $nacionalidad_migrante = null, $nacionalidad_pueblo = null,
		$autor = null) {
		include("db_config.php");

		$db->insert("viga_participacion_plan",
			[
				"id_iniciativa" => $id_iniciativa,
				"tipo" => $tipo,
				"publico_general" => $publico_general,
				"aplica_sexo" => $aplica_sexo,
				"sexo_masculino" => $sexo_masculino,
				"sexo_femenino" => $sexo_femenino,
				"sexo_otro" => $sexo_otro,
				"aplica_edad" => $aplica_edad,
				"edad_ninos" => $edad_ninos,
				"edad_jovenes" => $edad_jovenes,
				"edad_adultos" => $edad_adultos,
				"edad_adultos_mayores" => $edad_adultos_mayores,
				"aplica_procedencia" => $aplica_procedencia,
				"procedencia_rural" => $procedencia_rural,
				"procedencia_urbano" => $procedencia_urbano,
				"aplica_vulnerabilidad" => $aplica_vulnerabilidad,
				"vulnerabilidad_pueblo" => $vulnerabilidad_pueblo,
				"vulnerabilidad_discapacidad" => $vulnerabilidad_discapacidad,
				"vulnerabilidad_pobreza" => $vulnerabilidad_pobreza,
				"aplica_nacionalidad" => $aplica_nacionalidad,
				"nacionalidad_chileno" => $nacionalidad_chileno,
				"nacionalidad_migrante" => $nacionalidad_migrante,
				"nacionalidad_pueblo" => $nacionalidad_pueblo,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_participacion_plan", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_iniciativa"] == $id_iniciativa) $verificator++;
		if($datas[0]["tipo"] == $tipo) $verificator++;
		if($datas[0]["publico_general"] == $publico_general) $verificator++;
		if($datas[0]["aplica_sexo"] == $aplica_sexo) $verificator++;
		if($datas[0]["sexo_masculino"] == $sexo_masculino) $verificator++;
		if($datas[0]["sexo_femenino"] == $sexo_femenino) $verificator++;
		if($datas[0]["sexo_otro"] == $sexo_otro) $verificator++;
		if($datas[0]["aplica_edad"] == $aplica_edad) $verificator++;
		if($datas[0]["edad_ninos"] == $edad_ninos) $verificator++;
		if($datas[0]["edad_jovenes"] == $edad_jovenes) $verificator++;
		if($datas[0]["edad_adultos"] == $edad_adultos) $verificator++;
		if($datas[0]["edad_adultos_mayores"] == $edad_adultos_mayores) $verificator++;
		if($datas[0]["aplica_procedencia"] == $aplica_procedencia) $verificator++;
		if($datas[0]["procedencia_rural"] == $procedencia_rural) $verificator++;
		if($datas[0]["procedencia_urbano"] == $procedencia_urbano) $verificator++;
		if($datas[0]["aplica_vulnerabilidad"] == $aplica_vulnerabilidad) $verificator++;
		if($datas[0]["vulnerabilidad_pueblo"] == $vulnerabilidad_pueblo) $verificator++;
		if($datas[0]["vulnerabilidad_discapacidad"] == $vulnerabilidad_discapacidad) $verificator++;
		if($datas[0]["vulnerabilidad_pobreza"] == $vulnerabilidad_pobreza) $verificator++;
		if($datas[0]["aplica_nacionalidad"] == $aplica_nacionalidad) $verificator++;
		if($datas[0]["nacionalidad_chileno"] == $nacionalidad_chileno) $verificator++;
		if($datas[0]["nacionalidad_migrante"] == $nacionalidad_migrante) $verificator++;
		if($datas[0]["nacionalidad_pueblo"] == $nacionalidad_pueblo) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;

		if($verificator == 24) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "participacion_esperada", $id, "Nuevo registro con valores {id_iniciativa => $id_iniciativa, publico_general => $publico_general, aplica_sexo => $aplica_sexo, sexo_masculino => $sexo_masculino, sexo_femenino => $sexo_femenino, sexo_otro => $sexo_otro, aplica_edad => $aplica_edad, edad_ninos => $edad_ninos, edad_jovenes => $edad_jovenes, edad_adultos => $edad_adultos, edad_adultos_mayores => $edad_adultos_mayores, aplica_procedencia => $aplica_procedencia, procedencia_rural => $procedencia_rural, procedencia_urbano => $procedencia_urbano, aplica_vulnerabilidad => $aplica_vulnerabilidad, vulnerabilidad_pueblo => $vulnerabilidad_pueblo, vulnerabilidad_discapacidad => $vulnerabilidad_discapacidad, vulnerabilidad_pobreza => $vulnerabilidad_pobreza, aplica_nacionalidad => $aplica_nacionalidad, nacionalidad_chileno => $nacionalidad_chileno, nacionalidad_migrante => $nacionalidad_migrante, nacionalidad_pueblo => $nacionalidad_pueblo, autor => $autor}");
			return $datas;
		}return null;
	}

	function deletePlanParticipation($id = null, $id_iniciativa = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_participacion_plan",
			[
				"visible" => "-1",
			],
			[
				"id" => $id,
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>query: " . $db->last();

		$datas = $db->select("viga_participacion_plan", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "participacion_esperada", $id, "Eliminación de registro con valores {id => $id, id_iniciativa => $id_iniciativa, visible => -1}");
			return $datas;
		}return null;
	}

	function getVisiblePlanParticipationByInitiative($id_iniciativa = null) {
		include("db_config.php");

		$datas = $db->select("viga_participacion_plan",
			[
				"id", "tipo", "id_iniciativa", "publico_general",
				"aplica_sexo", "sexo_masculino", "sexo_femenino", "sexo_otro",
				"aplica_edad", "edad_ninos", "edad_jovenes", "edad_adultos", "edad_adultos_mayores",
				"aplica_procedencia", "procedencia_rural", "procedencia_urbano",
				"aplica_vulnerabilidad", "vulnerabilidad_pueblo", "vulnerabilidad_discapacidad", "vulnerabilidad_pobreza",
				"aplica_nacionalidad", "nacionalidad_chileno", "nacionalidad_migrante", "nacionalidad_pueblo",
				"visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $id_iniciativa
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}
?>
