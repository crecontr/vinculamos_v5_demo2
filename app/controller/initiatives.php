<?php
	/*
		SELECT "id", "nombre", "descripcion", "fecha_inicio", "fecha_finalizacion", "region", "comuna",
		"id_responsable",
		"detalle_entorno_empresa", "detalle_entorno_gobierno", "detalle_entorno_ies",
		"detalle_entorno_sindicato", "detalle_entorno_sociedad",
		"monto_vvcm", "monto_terceros", "monto_unidad", "estado",
		"visible", "institucion", "autor", "fecha_creacion"
		FROM "viga_iniciativas" WHERE 1
	*/

	/* Actualizado */
	function getInitiative($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas",
			[
				"id", "nombre", "descripcion", "objetivos", "resultado_esperado", "fecha_inicio", "fecha_finalizacion",
				"id_responsable", "id_mecanismo", "id_frecuencia", "destino_impacto", "medio_ambiente",
				"monto_vvcm", "monto_terceros", "monto_unidad", "estado",
				"detalle_entorno_empresa", "detalle_entorno_gobierno", "detalle_entorno_ies",
				"detalle_entorno_sindicato", "detalle_entorno_sociedad",
				"monto_vvcm", "monto_terceros", "monto_unidad",
				"disciplinar_asunto", "disciplinar_mensaje",
				"visible", "institucion", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id" => $id
			]
		);
		//echo "<br>query: " . $db->last();
		return $datas;
	}

	/* Actualizado */
	function addInitiative($fecha_inicio = null, $fecha_finalizacion = null,
		$id_responsable = null, $institucion = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_iniciativas",
			[
				"nombre" => "",
				"descripcion" => "",
				"fecha_inicio" => $fecha_inicio,
				"fecha_finalizacion" => $fecha_finalizacion,
				"id_responsable" => $id_responsable,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);

		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["fecha_inicio"] == $fecha_inicio) $verificator++;
		if($datas[0]["fecha_finalizacion"] == $fecha_finalizacion) $verificator++;
		if($datas[0]["id_responsable"] == $id_responsable) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Nuevo registro con valores {fecha_inicio => $fecha_inicio, fecha_finalizacion => $fecha_finalizacion, id_responsable => $id_responsable}");
			return $datas;
		}return null;
	}

	function editInitiativeFrecuency($id = null, $id_frecuencia = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"id_frecuencia" => $id_frecuencia
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_frecuencia"] == $id_frecuencia) $verificator++;
		if($verificator == 1) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {id_frecuencia => $id_frecuencia}");
			return $datas;
		}return null;
	}

	function editInitiativeStep2($id = null, $nombre = null, $id_mecanismo = null,
		$descripcion = null, $objetivos = null, $resultado_esperado = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"nombre" => $nombre,
				"id_mecanismo" => $id_mecanismo,
				"descripcion" => $descripcion,
				"objetivos" => $objetivos,
				"resultado_esperado" => $resultado_esperado
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
		if($datas[0]["id_mecanismo"] == $id_mecanismo) $verificator++;
		if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["objetivos"] == $objetivos) $verificator++;
		if($datas[0]["resultado_esperado"] == $resultado_esperado) $verificator++;
		if($verificator == 5) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {nombre => $nombre, id_mecanismo => $id_mecanismo, descripcion => $descripcion, objetivos => $objetivos, resultado_esperado => $resultado_esperado}");
			return $datas;
		}return null;
	}












	function editInitiativeStep3($id = null, $destino_impacto = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"destino_impacto" => $destino_impacto
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["destino_impacto"] == $destino_impacto) $verificator++;
		if($verificator == 1) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {destino_impacto => $destino_impacto}");
			return $datas;
		}return null;
	}

	function editInitiativeStep6($id = null, $monto_vvcm = null, $monto_terceros = null, $monto_unidad = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"monto_vvcm" => $monto_vvcm,
				"monto_terceros" => $monto_terceros,
				"monto_unidad" => $monto_unidad
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["monto_vvcm"] == $monto_vvcm) $verificator++;
		if($datas[0]["monto_terceros"] == $monto_terceros) $verificator++;
		if($datas[0]["monto_unidad"] == $monto_unidad) $verificator++;
		if($verificator == 3) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {monto_vvcm => $monto_vvcm, monto_terceros => $monto_terceros, monto_unidad => $monto_unidad}");
			return $datas;
		}return null;
	}

	function editInitiativeStatus($id = null, $estado = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"estado" => $estado
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["estado"] == $estado) $verificator++;
		if($verificator == 1) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {estado => $estado}");
			return $datas;
		}return null;
	}

	function editInitiativeDisciplinaryMessage($id = null, $disciplinar_asunto = null, $disciplinar_mensaje = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"disciplinar_asunto" => $disciplinar_asunto,
				"disciplinar_mensaje" => $disciplinar_mensaje
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["disciplinar_asunto"] == $disciplinar_asunto) $verificator++;
		if($datas[0]["disciplinar_mensaje"] == $disciplinar_mensaje) $verificator++;
		if($verificator == 2) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {disciplinar_asunto => $disciplinar_asunto, disciplinar_mensaje => $disciplinar_mensaje}");
			return $datas;
		}return null;
	}

	function editEnvironmentDetailEnterprise($id = null, $detalle_entorno_empresa = null, $detalle_entorno_gobierno = null,
		$detalle_entorno_ies = null, $detalle_entorno_sindicato = null, $detalle_entorno_sociedad = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"detalle_entorno_empresa" => $detalle_entorno_empresa,
				"detalle_entorno_gobierno" => $detalle_entorno_gobierno,
				"detalle_entorno_ies" => $detalle_entorno_ies,
				"detalle_entorno_sindicato" => $detalle_entorno_sindicato,
				"detalle_entorno_sociedad" => $detalle_entorno_sociedad
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["detalle_entorno_empresa"] == $detalle_entorno_empresa) $verificator++;
		if($datas[0]["detalle_entorno_gobierno"] == $detalle_entorno_gobierno) $verificator++;
		if($datas[0]["detalle_entorno_ies"] == $detalle_entorno_ies) $verificator++;
		if($datas[0]["detalle_entorno_sindicato"] == $detalle_entorno_sindicato) $verificator++;
		if($datas[0]["detalle_entorno_sociedad"] == $detalle_entorno_sociedad) $verificator++;
		if($verificator == 5) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {detalle_entorno_empresa => $detalle_entorno_empresa, detalle_entorno_gobierno => $detalle_entorno_gobierno, detalle_entorno_ies => $detalle_entorno_ies, detalle_entorno_sindicato => $detalle_entorno_sindicato, detalle_entorno_sociedad => $detalle_entorno_sociedad}");
			return $datas;
		}return null;
	}

	function editCoverageSizeFrecuency($id = null, $id_cobertura = null, $id_tamanio = null, $id_frecuencia = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"id_cobertura" => $id_cobertura,
				"id_tamanio" => $id_tamanio,
				"id_frecuencia" => $id_frecuencia
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_cobertura"] == $id_cobertura) $verificator++;
		if($datas[0]["id_tamanio"] == $id_tamanio) $verificator++;
		if($datas[0]["id_frecuencia"] == $id_frecuencia) $verificator++;
		if($verificator == 3) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {id_cobertura => $id_cobertura, id_tamanio => $id_tamanio, id_frecuencia => $id_frecuencia}");
			return $datas;
		}return null;
	}

	function editEnvironmentType($id = null, $medio_ambiente = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"medio_ambiente" => $medio_ambiente
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["medio_ambiente"] == $medio_ambiente) $verificator++;
		if($verificator == 1) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {medio_ambiente => $medio_ambiente}");
			return $datas;
		}return null;
	}

	function deleteProcedure($id = null, $nombre_usuario = null) {
		include("db_config.php");

		$db->update("viga_tramites",
			[
				"visible" => "-1",
			],
			[
				"id" => $id
			]
		);

		$datas = $db->select("viga_tramites", "*", ["id" => $id]);

		$verificator = 0;
		if($datas[0]["visible"] == "-1") $verificator++;
		if($verificator == 1) return $datas;
		return null;
	}

	function getVisibleInitiatives() {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas",
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_creacion"
			],
			[
				"viga_iniciativas.visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitution($institution = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.objetivos",
				"viga_iniciativas.resultado_esperado",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.id_mecanismo",
				"viga_iniciativas.institucion",
				"viga_iniciativas.destino_impacto",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
			[
				"viga_iniciativas.visible" => "1",
				"viga_iniciativas.institucion" => $institution,
				"ORDER" => [
					"viga_iniciativas.fecha_creacion" => "DESC",
				]
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitutionResponsiblesDates(
		$institution = null, $responsible = null, $dateFrom = null, $dateTo = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativas.id_responsable" => $responsible,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($dateFrom != "") {
			$extra = [
				"viga_iniciativas.fecha_inicio[>=]" => $dateFrom
			];
			$conditions = array_merge($conditions, $extra);
		}
		if($dateTo != "") {
			$extra = [
				"viga_iniciativas.fecha_finalizacion[<=]" => $dateTo
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitutionResponsiblesFrecuency(
		$institution = null, $responsible = null, $frecuency = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativas.id_responsable" => $responsible,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($frecuency != "") {
			$extra = [
				"viga_iniciativas.id_frecuencia" => $frecuency
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.id_frecuencia",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitutionResponsiblesMechanism(
		$institution = null, $responsible = null, $mechanism = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativas.id_responsable" => $responsible,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($mechanism != "") {
			$extra = [
				"viga_iniciativas.id_mecanismo" => $mechanism
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.id_frecuencia",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitutionResponsiblesEnvironment(
		$institution = null, $responsible = null, $environment = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativas.id_responsable" => $responsible,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($environment != "") {
			$extra = [
				"viga_entornos.id" => $environment
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"],
				"[><]viga_iniciativa_entorno" => ["id" => "id_iniciativa"],
				"[><]viga_entornos" => ["viga_iniciativa_entorno.id_entorno" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.id_frecuencia",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitutionUnitsDates(
		$institution = null, $unit = null, $dateFrom = null, $dateTo = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativa_unidad.id_unidad" => $unit,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($dateFrom != "") {
			$extra = [
				"viga_iniciativas.fecha_inicio[>=]" => $dateFrom
			];
			$conditions = array_merge($conditions, $extra);
		}
		if($dateTo != "") {
			$extra = [
				"viga_iniciativas.fecha_finalizacion[<=]" => $dateTo
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"],
				"[><]viga_iniciativa_unidad" => ["id" => "id_iniciativa"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByInstitutionCounitsDates(
		$institution = null, $unit = null, $dateFrom = null, $dateTo = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativa_unidad_coejecutante.id_unidad" => $unit,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($dateFrom != "") {
			$extra = [
				"viga_iniciativas.fecha_inicio[>=]" => $dateFrom
			];
			$conditions = array_merge($conditions, $extra);
		}
		if($dateTo != "") {
			$extra = [
				"viga_iniciativas.fecha_finalizacion[<=]" => $dateTo
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"],
				"[><]viga_iniciativa_unidad_coejecutante" => ["id" => "id_iniciativa"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getVisibleInitiativesByEnvironmentDates(
		$institution = null, $environment = null, $dateFrom = null, $dateTo = null) {
		include("db_config.php");

		$conditions = [
			"viga_iniciativas.visible" => "1",
			"viga_iniciativas.institucion" => $institution,
			"viga_iniciativa_entorno.id_entorno" => $environment,
			"ORDER" => [
				"fecha_inicio" => "ASC",
			]
		];
		if($dateFrom != "") {
			$extra = [
				"viga_iniciativas.fecha_inicio[>=]" => $dateFrom
			];
			$conditions = array_merge($conditions, $extra);
		}
		if($dateTo != "") {
			$extra = [
				"viga_iniciativas.fecha_finalizacion[<=]" => $dateTo
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_responsables" => ["id_responsable" => "id"],
				"[><]viga_iniciativa_entorno" => ["id" => "id_iniciativa"],
				"[><]viga_entornos" => ["viga_iniciativa_entorno.id_entorno" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_inicio",
				"viga_iniciativas.fecha_finalizacion",
				"viga_iniciativas.institucion",
				"viga_iniciativas.fecha_creacion",
				"viga_iniciativas.estado",
				"viga_responsables.nombre(responsable_nombre)"
			],
				$conditions
		);
		//echo "<BR>query: " . $db->last();
		return $datas;
	}

	function getLastInitiatives($limit) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas",
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_creacion"
			],
			[
				"viga_iniciativas.visible" => "1",
				"ORDER" => [
					"viga_iniciativas.fecha_creacion" => "DESC",
				],
				"LIMIT" => $limit
			]
		);

		return $datas;
	}

	function findInitiatives($text = null) {
		include("db_config.php");

		$conditions = [
				"viga_iniciativas.visible" => "1",
				"ORDER" => [
					"viga_iniciativas.fecha_creacion" => "DESC",
				],
				"LIMIT" => 15
			];
		if($text != "") {
			$extra = [
				"OR" => [
					"viga_iniciativas.nombre[~]" => $text,
					"viga_iniciativas.descripcion[~]" => $text
				]
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
			[
				"[><]viga_programas" => ["id_programa" => "id"]
			],
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_creacion",
				"viga_programas.nombre(programa)"
			],
				$conditions
		);

		//echo "query: " . $db->last() . "<br><br>";

		return $datas;
	}

	function findInitiativesByFilters($institution = null, $responsible = null, $unit = null, $counit = null,
		$environment = null, $mechanism = null, $program = null, $covenant = null, $campus = null,
		$country = null, $region = null, $commune = null) {
		include("db_config.php");

		$joins = [
			"[><]viga_responsables" => ["id_responsable" => "id"],
			"[><]viga_iniciativa_programa" => ["id" => "id_iniciativa"],
			"[><]viga_programas" => ["viga_iniciativa_programa.id_programa" => "id"],

			"[><]viga_iniciativa_unidad" => ["viga_iniciativas.id" => "id_iniciativa"],
			"[><]viga_unidades" => ["viga_iniciativa_unidad.id_unidad" => "id"],

			//"[><]viga_iniciativa_entorno" => ["viga_iniciativas.id" => "id_iniciativa"],
			//"[><]viga_entornos" => ["viga_iniciativa_entorno.id_entorno" => "id"]
		];

		$conditions = [
				"viga_iniciativas.visible" => "1",
				"viga_iniciativas.institucion" => $institution,
				"ORDER" => [
					"viga_iniciativas.fecha_creacion" => "DESC",
				]
			];
		/* Filtro por responsable */
		if($responsible != "") {
			$extra = [
				"viga_responsables.id" => $responsible,
			];
			$conditions = array_merge($conditions, $extra);
		}

		/* Filtro por unidad */
		if($unit != "") {
			$extra = [
				"viga_unidades.id" => $unit,
			];
			$conditions = array_merge($conditions, $extra);
		}

		/* Filtro por counidad */
		if($counit != "") {
			$extra = [
				"viga_iniciativa_unidad_coejecutante.id_unidad" => $counit,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativa_unidad_coejecutante" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[>]viga_unidades" => ["viga_iniciativa_unidad_coejecutante.id_unidad" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por entorno significativo */
		if($environment != "") {
			$extra = [
				"viga_entornos.id" => $environment,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativa_entorno" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_entornos" => ["viga_iniciativa_entorno.id_entorno" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por mecanismo */
		if($mechanism != "") {
			$extra = [
				"viga_atributo_mecanismo.id" => $mechanism,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_atributo_mecanismo" => ["viga_iniciativas.id_mecanismo" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por programa */
		if($program != "") {
			$extra = [
				"viga_programas.id" => $program,
			];
			$conditions = array_merge($conditions, $extra);
		}

		/* Filtro por convenio */
		if($covenant != "") {
			$extra = [
				"viga_convenios.id" => $covenant,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[>]viga_iniciativa_convenio" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[>]viga_convenios" => ["viga_iniciativa_convenio.id_convenio" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por campus o sede */
		if($campus != "") {
			$extra = [
				"viga_institucion_sede.id" => $campus,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_unidad_institucion_sede" => ["viga_unidades.id" => "id_unidad"],
				"[><]viga_institucion_sede" => ["viga_unidad_institucion_sede.id_institucion_sede" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por pais */
		if($country != "") {
			$extra = [
				"viga_pais.id" => $country,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativa_geo_pais" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_pais" => ["viga_iniciativa_geo_pais.id_pais" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por región */
		if($region != "") {
			$extra = [
				"viga_region.id" => $region,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativa_geo_region" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_region" => ["viga_iniciativa_geo_region.id_region" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por comuna */
		if($commune != "") {
			$extra = [
				"viga_comuna.id" => $commune,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativa_geo_comuna" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_comuna" => ["viga_iniciativa_geo_comuna.id_comuna" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		$datas = $db->select("viga_iniciativas",
				$joins
			/*[




				//





				//"[><]viga_iniciativa_geo_pais" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[><]viga_pais" => ["viga_iniciativa_geo_pais.id_pais" => "id"],

			]*/,
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_responsable",
				"viga_iniciativas.fecha_creacion",
				"viga_responsables.nombre(responsable_nombre)",
				"viga_unidades.nombre(unidad)",
				"viga_programas.nombre(programa)",
				//"viga_entornos.nombre(entornos)"
			],
				$conditions
		);

		//echo "query: " . $db->last() . "<br><br>";

		//return array_unique($datas);
		return ($datas);
	}

?>
