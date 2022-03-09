<?php
  /*
  SELECT `id`, `nombre`, `fecha_inicio`, `fecha_finalizacion`, `gestor_vinculo`,
    `responsable`, `responsable_cargo`, `formato_implementacion`, `objetivo`,
    `descripcion`, `impacto_esperado`, `resultado_esperado`, `impacto_logrado_interno`,
    `impacto_logrado_externo`, `id_programa`, `id_mecanismo`, `id_frecuencia`,
    `estado`, `visible`, `institucion`, `autor`, `fecha_creacion`
  FROM `viga_iniciativas` WHERE 1
  */

  function addInitiative($nombre = null, $fecha_inicio = null, $fecha_finalizacion = null, $institucion = null, $autor = null) {
		include("db_config.php");

		$db->insert("viga_iniciativas",
			[
				"nombre" => $nombre,
				"fecha_inicio" => $fecha_inicio,
				"fecha_finalizacion" => $fecha_finalizacion,
				"institucion" => $institucion,
				"autor" => $autor
			]
		);
		//echo "<br>query: " . $db->last();

		$id = $db->id();
		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["nombre"] == $nombre) $verificator++;
    if($datas[0]["fecha_inicio"] == $fecha_inicio) $verificator++;
		if($datas[0]["fecha_finalizacion"] == $fecha_finalizacion) $verificator++;
		if($datas[0]["institucion"] == $institucion) $verificator++;
		if($datas[0]["autor"] == $autor) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Nuevo registro con valores {nombre => $nombre, fecha_inicio => $fecha_inicio, fecha_finalizacion => $fecha_finalizacion}");
			return $datas;
		}return null;
	}

	function editInitiativeProgramMechanismFrecuency($id = null, $id_programa = null, $id_mecanismo = null, $id_frecuencia = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"id_programa" => $id_programa,
        "id_mecanismo" => $id_mecanismo,
        "id_frecuencia" => $id_frecuencia
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["id_programa"] == $id_programa) $verificator++;
    if($datas[0]["id_mecanismo"] == $id_mecanismo) $verificator++;
    if($datas[0]["id_frecuencia"] == $id_frecuencia) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {id_programa => $id_programa, id_mecanismo => $id_mecanismo, id_frecuencia => $id_frecuencia}");
			return $datas;
		}return null;
	}

  function editInitiativeAttributesStep1($id = null, $gestor_vinculo = null, $responsable = null,
    $responsable_cargo = null, $formato_implementacion = null, $autor = null) {
		include("db_config.php");

    $db->update("viga_iniciativas",
			[
				"gestor_vinculo" => $gestor_vinculo,
        "responsable" => $responsable,
        "responsable_cargo" => $responsable_cargo,
        "formato_implementacion" => $formato_implementacion
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["gestor_vinculo"] == $gestor_vinculo) $verificator++;
    if($datas[0]["responsable"] == $responsable) $verificator++;
    if($datas[0]["responsable_cargo"] == $responsable_cargo) $verificator++;
    if($datas[0]["formato_implementacion"] == $formato_implementacion) $verificator++;
		if($verificator == 4) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {gestor_vinculo => $gestor_vinculo, responsable => $responsable, responsable_cargo => $responsable_cargo, formato_implementacion => $formato_implementacion}");
			return $datas;
		}return null;
	}

  function editInitiativePerformingPublic($id = null, $ejecutante_estudianes = null, $ejecutante_docentes = null,
    $ejecutante_colaboradores = null, $ejecutante_otro = null, $autor = null) {
		include("db_config.php");

    $db->update("viga_iniciativas",
			[
				"ejecutante_estudiantes" => $ejecutante_estudianes,
        "ejecutante_docentes" => $ejecutante_docentes,
        "ejecutante_colaboradores" => $ejecutante_colaboradores,
        "ejecutante_otros" => $ejecutante_otro
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["ejecutante_estudiantes"] == $ejecutante_estudianes) $verificator++;
    if($datas[0]["ejecutante_docentes"] == $ejecutante_docentes) $verificator++;
    if($datas[0]["ejecutante_colaboradores"] == $ejecutante_colaboradores) $verificator++;
    if($datas[0]["ejecutante_otros"] == $ejecutante_otro) $verificator++;
		if($verificator == 4) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {ejecutante_estudiantes => $ejecutante_estudianes, ejecutante_docentes => $ejecutante_docentes, ejecutante_colaboradores => $ejecutante_colaboradores, ejecutante_otros => $ejecutante_otro}");
			return $datas;
		}return null;
	}

  function editInitiativeASfields($id = null, $as_carrera = null, $as_seccion = null,
    $as_codigo_modulo = null, $as_docente = null, $autor = null) {
		include("db_config.php");

    $db->update("viga_iniciativas",
			[
				"as_carrera" => $as_carrera,
        "as_seccion" => $as_seccion,
        "as_codigo_modulo" => $as_codigo_modulo,
        "as_docente" => $as_docente
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["as_carrera"] == $as_carrera) $verificator++;
    if($datas[0]["as_seccion"] == $as_seccion) $verificator++;
    if($datas[0]["as_codigo_modulo"] == $as_codigo_modulo) $verificator++;
    if($datas[0]["as_docente"] == $as_docente) $verificator++;
		if($verificator == 4) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {as_carrera => $as_carrera, as_seccion => $as_seccion, as_codigo_modulo => $as_codigo_modulo, as_docente => $as_docente}");
			return $datas;
		}return null;
	}

	function editInitiativeStep1($id = null, $nombre = null, $fecha_inicio = null, $fecha_finalizacion = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
        "nombre" => $nombre,
				"fecha_inicio" => $fecha_inicio,
				"fecha_finalizacion" => $fecha_finalizacion,
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
    if($datas[0]["nombre"] == $nombre) $verificator++;
    if($datas[0]["fecha_inicio"] == $fecha_inicio) $verificator++;
		if($datas[0]["fecha_finalizacion"] == $fecha_finalizacion) $verificator++;
		if($verificator == 3) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {nombre => $nombre, fecha_inicio => $fecha_inicio, fecha_finalizacion => $fecha_finalizacion}");
			return $datas;
		}return null;
	}

  function editInitiativeStep2($id = null, $entorno_detalle = null, $descripcion = null, $objetivo = null, $impacto_esperado = null,
    $resultado_esperado = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
        "entorno_detalle" => $entorno_detalle,
				"descripcion" => $descripcion,
				"objetivo" => $objetivo,
				"impacto_esperado" => $impacto_esperado,
        "resultado_esperado" => $resultado_esperado
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["entorno_detalle"] == $entorno_detalle) $verificator++;
    if($datas[0]["descripcion"] == $descripcion) $verificator++;
		if($datas[0]["objetivo"] == $objetivo) $verificator++;
		if($datas[0]["impacto_esperado"] == $impacto_esperado) $verificator++;
    if($datas[0]["resultado_esperado"] == $resultado_esperado) $verificator++;
		if($verificator == 5) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {entorno_detalle => $entorno_detalle, descripcion => $descripcion, objetivo => $objetivo, impacto_esperado => $impacto_esperado, resultado_esperado => $resultado_esperado}");
			return $datas;
		}return null;
	}

  function editInitiativeAchievedImpacts($id = null, $impacto_interno = null, $impacto_externo = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"impacto_logrado_interno" => $impacto_interno,
        "impacto_logrado_externo" => $impacto_externo
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["impacto_logrado_interno"] == $impacto_interno) $verificator++;
		if($datas[0]["impacto_logrado_externo"] == $impacto_externo) $verificator++;
		if($verificator == 2) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {impacto_logrado_interno => $impacto_interno, impacto_logrado_externo => $impacto_externo}");
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
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {estado => $estado}");
			return $datas;
		}return null;
	}

  function editInitiativeStatusExecution($id = null, $estado = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"estado_ejecucion" => $estado
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["estado_ejecucion"] == $estado) $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {estado_ejecucion => $estado}");
			return $datas;
		}return null;
	}

  function editInitiativeStatusFillment($id = null, $estado = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"estado_completitud" => $estado
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["estado_completitud"] == $estado) $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Modificación en registro con valores {estado_completitud => $estado}");
			return $datas;
		}return null;
	}

  function deleteInitiative($id = null, $autor = null) {
		include("db_config.php");

		$db->update("viga_iniciativas",
			[
				"visible" => -1
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();

		$datas = $db->select("viga_iniciativas", "*",["id" => $id]);
		$verificator = 0;
		if($datas[0]["visible"] == -1) $verificator++;
		if($verificator == 1) {
			include_once("medoo_logs.php");
			logAction($db, $autor, "iniciativa", $id, "Eliminación de registro con valores {visible => -1}");
			return $datas;
		}return null;
	}

  function getInitiative($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_iniciativas",
			[
        "viga_iniciativas.id",
				"viga_iniciativas.nombre",
        "viga_iniciativas.fecha_inicio",
        "viga_iniciativas.fecha_finalizacion",

        "viga_iniciativas.gestor_vinculo",
        "viga_iniciativas.responsable",
        "viga_iniciativas.responsable_cargo",
        "viga_iniciativas.formato_implementacion",

        "viga_iniciativas.ejecutante_estudiantes",
        "viga_iniciativas.ejecutante_docentes",
        "viga_iniciativas.ejecutante_colaboradores",
        "viga_iniciativas.ejecutante_otros",

        "viga_iniciativas.as_carrera",
        "viga_iniciativas.as_seccion",
        "viga_iniciativas.as_codigo_modulo",
        "viga_iniciativas.as_docente",

        "viga_iniciativas.entorno_detalle",
        "viga_iniciativas.objetivo",
        "viga_iniciativas.descripcion",
        "viga_iniciativas.impacto_esperado",
        "viga_iniciativas.resultado_esperado",
        "viga_iniciativas.impacto_logrado_interno",
        "viga_iniciativas.impacto_logrado_externo",

        "viga_iniciativas.id_programa",
        "viga_iniciativas.id_mecanismo",
        "viga_iniciativas.id_frecuencia",
        "viga_iniciativas.estado",
        "viga_iniciativas.estado_ejecucion",
        "viga_iniciativas.estado_completitud",
        "viga_iniciativas.institucion"
			],
			[
				"visible" => "1",
				"id" => $id
			]
		);
		//echo "<br>query: " . $db->last();
		return $datas;
	}

  function getVisibleInitiativesByInstitution($institution = null, $executionStatus = null, $fillmentStatus = null,
    $dateFrom = null, $dateTo = null, $college = null, $campus = null, $program = null, $carrer = null) {
		include("db_config.php");

    $joins = [
      "[>]viga_programas" => ["viga_iniciativas.id_programa" => "id"],
      "[>]viga_atributo_mecanismo" => ["viga_iniciativas.id_mecanismo" => "id"],
      "[>]viga_atributo_frecuencia" => ["viga_iniciativas.id_frecuencia" => "id"],
		];

    $conditions = [
      "viga_iniciativas.visible" => "1",
      "viga_iniciativas.institucion" => $institution,
      "ORDER" => [
        "viga_iniciativas.fecha_creacion" => "DESC",
      ]
		];

    /* Filtro por estado de ejecución */
		if($executionStatus != "") {
			$extra = [
				"viga_iniciativas.estado_ejecucion" => $executionStatus,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por estado de completitud */
		if($fillmentStatus != "") {
			$extra = [
				"viga_iniciativas.estado_completitud" => $fillmentStatus,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por fecha desde */
		if($dateFrom != "") {
			$extra = [
				"viga_iniciativas.fecha_inicio[>=]" => $dateFrom,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por fecha hasta */
		if($dateTo != "") {
			$extra = [
				"viga_iniciativas.fecha_finalizacion[<=]" => $dateTo,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por escuela */
		if($college != "") {
			$extra = [
				"viga_iniciativas_escuela.id_escuela" => $college,
			];
			$conditions = array_merge($conditions, $extra);

      $extraJoin = [
				"[><]viga_iniciativas_escuela" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[><]viga_escuelas" => ["viga_iniciativas_escuela.id_escuela" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por sede */
		if($campus != "") {
			$extra = [
				"viga_iniciativas_sede.id_sede" => $campus,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_sede" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[><]viga_sedes" => ["viga_iniciativas_sede.id_sede" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

    /* Filtro por programa */
		if($program != "") {
			$extra = [
				"viga_iniciativas.id_programa" => $program
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por carrera */
		if($carrer != "") {
			$extra = [
				"viga_iniciativas_carrera.id_carrera" => $carrer,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_carrera" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[><]viga_carreras" => ["viga_iniciativas_carrera.id_carrera" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		$datas = $db->select("viga_iniciativas",
        $joins,
			[
        "viga_iniciativas.id",
				"viga_iniciativas.nombre",
        "viga_iniciativas.fecha_inicio",
        "viga_iniciativas.fecha_finalizacion",

        "viga_iniciativas.gestor_vinculo",
        "viga_iniciativas.responsable",
        "viga_iniciativas.responsable_cargo",
        "viga_iniciativas.formato_implementacion",

        "viga_iniciativas.ejecutante_estudiantes",
        "viga_iniciativas.ejecutante_docentes",
        "viga_iniciativas.ejecutante_colaboradores",
        "viga_iniciativas.ejecutante_otros",

        "viga_iniciativas.as_carrera",
        "viga_iniciativas.as_seccion",
        "viga_iniciativas.as_codigo_modulo",
        "viga_iniciativas.as_docente",

        "viga_iniciativas.entorno_detalle",
        "viga_iniciativas.objetivo",
        "viga_iniciativas.descripcion",
        "viga_iniciativas.impacto_esperado",
        "viga_iniciativas.resultado_esperado",
        "viga_iniciativas.impacto_logrado_interno",
        "viga_iniciativas.impacto_logrado_externo",

        "viga_iniciativas.id_programa",
        "viga_iniciativas.id_mecanismo",
        "viga_iniciativas.id_frecuencia",
        "viga_iniciativas.estado",
        "viga_iniciativas.estado_ejecucion",
        "viga_iniciativas.estado_completitud",
        "viga_iniciativas.institucion",

        "viga_programas.nombre(programa_nombre)",
        "viga_atributo_mecanismo.nombre(mecanismo_nombre)",
        "viga_atributo_frecuencia.nombre(frecuencia_nombre)"
			],
			   $conditions
		);
		//echo "query: " . $db->last();
		return $datas;
	}

  function getVisibleInitiativesByInstitutionFull($institution = null, $id_initiative = null) {
		include("db_config.php");

    $conditions = [
      "viga_iniciativas.visible" => "1",
      "viga_iniciativas.institucion" => $institution,
      "ORDER" => [
        "viga_iniciativas.fecha_creacion" => "DESC",
      ]
		];
    if($id_initiative != "") {
			$extra = [
				"viga_iniciativas.id" => $id_initiative,
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
      [
        "[>]viga_programas" => ["viga_iniciativas.id_programa" => "id"],
        "[>]viga_atributo_mecanismo" => ["viga_iniciativas.id_mecanismo" => "id"],
        "[>]viga_atributo_frecuencia" => ["viga_iniciativas.id_frecuencia" => "id"],
      ],
			[
        "viga_iniciativas.id",
				"viga_iniciativas.nombre",
        "viga_iniciativas.fecha_inicio",
        "viga_iniciativas.fecha_finalizacion",

        "viga_iniciativas.gestor_vinculo",
        "viga_iniciativas.responsable",
        "viga_iniciativas.responsable_cargo",
        "viga_iniciativas.formato_implementacion",

        "viga_iniciativas.ejecutante_estudiantes",
        "viga_iniciativas.ejecutante_docentes",
        "viga_iniciativas.ejecutante_colaboradores",
        "viga_iniciativas.ejecutante_otros",

        "viga_iniciativas.as_carrera",
        "viga_iniciativas.as_seccion",
        "viga_iniciativas.as_codigo_modulo",
        "viga_iniciativas.as_docente",

        "viga_iniciativas.entorno_detalle",
        "viga_iniciativas.objetivo",
        "viga_iniciativas.descripcion",
        "viga_iniciativas.impacto_esperado",
        "viga_iniciativas.resultado_esperado",
        "viga_iniciativas.impacto_logrado_interno",
        "viga_iniciativas.impacto_logrado_externo",

        "viga_iniciativas.id_programa",
        "viga_iniciativas.id_mecanismo",
        "viga_iniciativas.id_frecuencia",
        "viga_iniciativas.estado",
        "viga_iniciativas.estado_ejecucion",
        "viga_iniciativas.estado_completitud",
        "viga_iniciativas.institucion",

        "viga_programas.nombre(programa_nombre)",
        "viga_atributo_mecanismo.nombre(mecanismo_nombre)",
        "viga_atributo_frecuencia.nombre(frecuencia_nombre)"
			],
			   $conditions
		);

    for ($i=0; $i < sizeof($datas); $i++) {
      $id_iniciativa = $datas[$i]["id"];
      $id_programa = $datas[$i]["id_programa"];
      /* PROGRAMAS - ESTRATEGIAS */
      $datas_strategy = $db->query(
  			"SELECT DISTINCT `viga_programas_estrategias`.`id`,`viga_programas_estrategias`.`nombre`
  			FROM `viga_programas_estrategias` INNER JOIN `viga_iniciativas_programa_estrategia` ON `viga_programas_estrategias`.`id` = `viga_iniciativas_programa_estrategia`.`id_programa_estrategia`
  			WHERE `viga_iniciativas_programa_estrategia`.`id_iniciativa` = '$id_iniciativa'
  			AND `viga_iniciativas_programa_estrategia`.`id_programa` = '$id_programa' "
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_strategy); $j++) {
        unset($datas_strategy[$j][0]);
        unset($datas_strategy[$j][1]);
      }
      $datas[$i]["programa_estrategias"] = $datas_strategy;

      /* PROGRAMAS - PROGRAMAS SECUNDARIOS */
      $datas_programs = $db->query(
  			"SELECT DISTINCT `viga_programas`.`id`,`viga_programas`.`nombre`
  			FROM `viga_programas` INNER JOIN `viga_iniciativas_programa` ON `viga_programas`.`id` = `viga_iniciativas_programa`.`id_programa`
  			WHERE `viga_iniciativas_programa`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_programs); $j++) {
        unset($datas_programs[$j][0]);
        unset($datas_programs[$j][1]);
      }
      $datas[$i]["programa_secundarios"] = $datas_programs;

      /* ESCUELAS */
      $datas_collegues = $db->query(
  			"SELECT DISTINCT `viga_escuelas`.`id`,`viga_escuelas`.`nombre`
  			FROM `viga_escuelas` INNER JOIN `viga_iniciativas_escuela` ON `viga_escuelas`.`id` = `viga_iniciativas_escuela`.`id_escuela`
  			WHERE `viga_iniciativas_escuela`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_collegues); $j++) {
        unset($datas_collegues[$j][0]);
        unset($datas_collegues[$j][1]);
      }
      $datas[$i]["escuelas"] = $datas_collegues;

      /* SEDES */
      $datas_campus = $db->query(
  			"SELECT DISTINCT `viga_sedes`.`id`,`viga_sedes`.`nombre`
  			FROM `viga_sedes` INNER JOIN `viga_iniciativas_sede` ON `viga_sedes`.`id` = `viga_iniciativas_sede`.`id_sede`
  			WHERE `viga_iniciativas_sede`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_campus); $j++) {
        unset($datas_campus[$j][0]);
        unset($datas_campus[$j][1]);
      }
      $datas[$i]["sedes"] = $datas_campus;

      /* GEO PAIS */
      $datas_countries = $db->query(
  			"SELECT DISTINCT `viga_geo_pais`.`id`,`viga_geo_pais`.`nombre`
  			FROM `viga_geo_pais` INNER JOIN `viga_iniciativas_geo_pais` ON `viga_geo_pais`.`id` = `viga_iniciativas_geo_pais`.`id_pais`
  			WHERE `viga_iniciativas_geo_pais`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_countries); $j++) {
        unset($datas_countries[$j][0]);
        unset($datas_countries[$j][1]);
      }
      $datas[$i]["paises"] = $datas_countries;

      /* GEO PROVINCIA */
      $datas_regions = $db->query(
  			"SELECT DISTINCT `viga_geo_region`.`id`,`viga_geo_region`.`nombre`
  			FROM `viga_geo_region` INNER JOIN `viga_iniciativas_geo_region` ON `viga_geo_region`.`id` = `viga_iniciativas_geo_region`.`id_region`
  			WHERE `viga_iniciativas_geo_region`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_regions); $j++) {
        unset($datas_regions[$j][0]);
        unset($datas_regions[$j][1]);
      }
      $datas[$i]["regiones"] = $datas_regions;

      /* GEO COMUNA */
      $datas_communes = $db->query(
  			"SELECT DISTINCT `viga_geo_comuna`.`id`, `viga_geo_comuna`.`id_region`,`viga_geo_comuna`.`nombre`
  			FROM `viga_geo_comuna` INNER JOIN `viga_iniciativas_geo_comuna` ON `viga_geo_comuna`.`id` = `viga_iniciativas_geo_comuna`.`id_comuna`
  			WHERE `viga_iniciativas_geo_comuna`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_communes); $j++) {
        unset($datas_communes[$j][0]);
        unset($datas_communes[$j][1]);
        unset($datas_communes[$j][2]);
      }
      $datas[$i]["comunas"] = $datas_communes;
    }
		//echo "query: " . $db->last();
		return $datas;
	}

  function getVisibleInitiativesByInstitutionFullFilters($institution = null, $id_initiative = null,
    $executionStatus = null, $fillmentStatus = null) {
		include("db_config.php");

    $conditions = [
      "viga_iniciativas.visible" => "1",
      "viga_iniciativas.institucion" => $institution,
      "ORDER" => [
        "viga_iniciativas.fecha_creacion" => "DESC",
      ]
		];
    if($id_initiative != "") {
			$extra = [
				"viga_iniciativas.id" => $id_initiative,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por estado de ejecución */
		if($executionStatus != "") {
			$extra = [
				"viga_iniciativas.estado_ejecucion" => $executionStatus,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por estado de completitud */
		if($fillmentStatus != "") {
			$extra = [
				"viga_iniciativas.estado_completitud" => $fillmentStatus,
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
      [
        "[>]viga_programas" => ["viga_iniciativas.id_programa" => "id"],
        "[>]viga_atributo_mecanismo" => ["viga_iniciativas.id_mecanismo" => "id"],
        "[>]viga_atributo_frecuencia" => ["viga_iniciativas.id_frecuencia" => "id"],
      ],
			[
        "viga_iniciativas.id",
				"viga_iniciativas.nombre",
        "viga_iniciativas.fecha_inicio",
        "viga_iniciativas.fecha_finalizacion",

        "viga_iniciativas.gestor_vinculo",
        "viga_iniciativas.responsable",
        "viga_iniciativas.responsable_cargo",
        "viga_iniciativas.formato_implementacion",

        "viga_iniciativas.ejecutante_estudiantes",
        "viga_iniciativas.ejecutante_docentes",
        "viga_iniciativas.ejecutante_colaboradores",
        "viga_iniciativas.ejecutante_otros",

        "viga_iniciativas.as_carrera",
        "viga_iniciativas.as_seccion",
        "viga_iniciativas.as_codigo_modulo",
        "viga_iniciativas.as_docente",

        "viga_iniciativas.entorno_detalle",
        "viga_iniciativas.objetivo",
        "viga_iniciativas.descripcion",
        "viga_iniciativas.impacto_esperado",
        "viga_iniciativas.resultado_esperado",
        "viga_iniciativas.impacto_logrado_interno",
        "viga_iniciativas.impacto_logrado_externo",

        "viga_iniciativas.id_programa",
        "viga_iniciativas.id_mecanismo",
        "viga_iniciativas.id_frecuencia",
        "viga_iniciativas.estado",
        "viga_iniciativas.estado_ejecucion",
        "viga_iniciativas.estado_completitud",
        "viga_iniciativas.institucion",

        "viga_programas.nombre(programa_nombre)",
        "viga_atributo_mecanismo.nombre(mecanismo_nombre)",
        "viga_atributo_frecuencia.nombre(frecuencia_nombre)"
			],
			   $conditions
		);

    for ($i=0; $i < sizeof($datas); $i++) {
      $id_iniciativa = $datas[$i]["id"];
      $id_programa = $datas[$i]["id_programa"];
      /* PROGRAMAS - ESTRATEGIAS */
      $datas_strategy = $db->query(
  			"SELECT DISTINCT `viga_programas_estrategias`.`id`,`viga_programas_estrategias`.`nombre`
  			FROM `viga_programas_estrategias` INNER JOIN `viga_iniciativas_programa_estrategia` ON `viga_programas_estrategias`.`id` = `viga_iniciativas_programa_estrategia`.`id_programa_estrategia`
  			WHERE `viga_iniciativas_programa_estrategia`.`id_iniciativa` = '$id_iniciativa'
  			AND `viga_iniciativas_programa_estrategia`.`id_programa` = '$id_programa' "
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_strategy); $j++) {
        unset($datas_strategy[$j][0]);
        unset($datas_strategy[$j][1]);
      }
      $datas[$i]["programa_estrategias"] = $datas_strategy;

      /* PROGRAMAS - PROGRAMAS SECUNDARIOS */
      $datas_programs = $db->query(
  			"SELECT DISTINCT `viga_programas`.`id`,`viga_programas`.`nombre`
  			FROM `viga_programas` INNER JOIN `viga_iniciativas_programa` ON `viga_programas`.`id` = `viga_iniciativas_programa`.`id_programa`
  			WHERE `viga_iniciativas_programa`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_programs); $j++) {
        unset($datas_programs[$j][0]);
        unset($datas_programs[$j][1]);
      }
      $datas[$i]["programa_secundarios"] = $datas_programs;

      /* ESCUELAS */
      $datas_collegues = $db->query(
  			"SELECT DISTINCT `viga_escuelas`.`id`,`viga_escuelas`.`nombre`
  			FROM `viga_escuelas` INNER JOIN `viga_iniciativas_escuela` ON `viga_escuelas`.`id` = `viga_iniciativas_escuela`.`id_escuela`
  			WHERE `viga_iniciativas_escuela`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_collegues); $j++) {
        unset($datas_collegues[$j][0]);
        unset($datas_collegues[$j][1]);
      }
      $datas[$i]["escuelas"] = $datas_collegues;

      /* SEDES */
      $datas_campus = $db->query(
  			"SELECT DISTINCT `viga_sedes`.`id`,`viga_sedes`.`nombre`
  			FROM `viga_sedes` INNER JOIN `viga_iniciativas_sede` ON `viga_sedes`.`id` = `viga_iniciativas_sede`.`id_sede`
  			WHERE `viga_iniciativas_sede`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_campus); $j++) {
        unset($datas_campus[$j][0]);
        unset($datas_campus[$j][1]);
      }
      $datas[$i]["sedes"] = $datas_campus;

      /* GEO PAIS */
      $datas_countries = $db->query(
  			"SELECT DISTINCT `viga_geo_pais`.`id`,`viga_geo_pais`.`nombre`
  			FROM `viga_geo_pais` INNER JOIN `viga_iniciativas_geo_pais` ON `viga_geo_pais`.`id` = `viga_iniciativas_geo_pais`.`id_pais`
  			WHERE `viga_iniciativas_geo_pais`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_countries); $j++) {
        unset($datas_countries[$j][0]);
        unset($datas_countries[$j][1]);
      }
      $datas[$i]["paises"] = $datas_countries;

      /* GEO PROVINCIA */
      $datas_regions = $db->query(
  			"SELECT DISTINCT `viga_geo_region`.`id`,`viga_geo_region`.`nombre`
  			FROM `viga_geo_region` INNER JOIN `viga_iniciativas_geo_region` ON `viga_geo_region`.`id` = `viga_iniciativas_geo_region`.`id_region`
  			WHERE `viga_iniciativas_geo_region`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_regions); $j++) {
        unset($datas_regions[$j][0]);
        unset($datas_regions[$j][1]);
      }
      $datas[$i]["regiones"] = $datas_regions;

      /* GEO COMUNA */
      $datas_communes = $db->query(
  			"SELECT DISTINCT `viga_geo_comuna`.`id`, `viga_geo_comuna`.`id_region`,`viga_geo_comuna`.`nombre`
  			FROM `viga_geo_comuna` INNER JOIN `viga_iniciativas_geo_comuna` ON `viga_geo_comuna`.`id` = `viga_iniciativas_geo_comuna`.`id_comuna`
  			WHERE `viga_iniciativas_geo_comuna`.`id_iniciativa` = '$id_iniciativa'"
  		)->fetchAll();
      for ($j=0; $j < sizeof($datas_communes); $j++) {
        unset($datas_communes[$j][0]);
        unset($datas_communes[$j][1]);
        unset($datas_communes[$j][2]);
      }
      $datas[$i]["comunas"] = $datas_communes;
    }
		//echo "query: " . $db->last();
		return $datas;
	}

  function findInitiativesByFilters($institution = null, $college = null, $campus = null,
		$environment = null, $mechanism = null, $program = null, $covenant = null,
		$country = null, $region = null, $commune = null, $linkManagerType = null,
    $implementationFormat = null, $frecuency = null, $executionStatus = null, $fillmentStatus = null) {
		include("db_config.php");

		$joins = [
      "[><]viga_programas" => ["viga_iniciativas.id_programa" => "id"]
			//"[><]viga_iniciativa_unidad" => ["viga_iniciativas.id" => "id_iniciativa"],
			//"[><]viga_unidades" => ["viga_iniciativa_unidad.id_unidad" => "id"],

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
		/* Filtro por escuela */
		if($college != "") {
			$extra = [
				"viga_iniciativas_escuela.id_escuela" => $college,
			];
			$conditions = array_merge($conditions, $extra);

      $extraJoin = [
				"[><]viga_iniciativas_escuela" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[><]viga_escuelas" => ["viga_iniciativas_escuela.id_escuela" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por sede */
		if($campus != "") {
			$extra = [
				"viga_iniciativas_sede.id_sede" => $campus,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_sede" => ["viga_iniciativas.id" => "id_iniciativa"],
				//"[><]viga_sedes" => ["viga_iniciativas_sede.id_sede" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por entorno significativo */
		if($environment != "") {
			$extra = [
				"viga_entornos_significativos.id" => $environment,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_entornos_significativos" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_entornos_significativos" => ["viga_iniciativas_entornos_significativos.id_entorno" => "id"]
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
				"[><]viga_iniciativas_convenio" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_convenios" => ["viga_iniciativas_convenio.id_convenio" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por pais */
		if($country != "") {
			$extra = [
				"viga_geo_pais.id" => $country,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_geo_pais" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_geo_pais" => ["viga_iniciativas_geo_pais.id_pais" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por región */
		if($region != "") {
			$extra = [
				"viga_geo_region.id" => $region,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_geo_region" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_geo_region" => ["viga_iniciativas_geo_region.id_region" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

		/* Filtro por comuna */
		if($commune != "") {
			$extra = [
				"viga_geo_comuna.id" => $commune,
			];
			$conditions = array_merge($conditions, $extra);

			$extraJoin = [
				"[><]viga_iniciativas_geo_comuna" => ["viga_iniciativas.id" => "id_iniciativa"],
				"[><]viga_geo_comuna" => ["viga_iniciativa_geo_comuna.id_comuna" => "id"]
			];
			$joins = array_merge($joins, $extraJoin);
		}

    /* Filtro por gestor de vinculo */
		if($linkManagerType != "") {
			$extra = [
				"viga_iniciativas.gestor_vinculo" => $linkManagerType,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por formato de implementacion */
		if($implementationFormat != "") {
			$extra = [
				"viga_iniciativas.formato_implementacion" => $implementationFormat,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por formato de implementacion */
		if($frecuency != "") {
			$extra = [
				"viga_iniciativas.id_frecuencia" => $frecuency,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por estado de ejecución */
		if($executionStatus != "") {
			$extra = [
				"viga_iniciativas.estado_ejecucion" => $executionStatus,
			];
			$conditions = array_merge($conditions, $extra);
		}

    /* Filtro por estado de completitud */
		if($fillmentStatus != "") {
			$extra = [
				"viga_iniciativas.estado_completitud" => $fillmentStatus,
			];
			$conditions = array_merge($conditions, $extra);
		}

		$datas = $db->select("viga_iniciativas",
				$joins,
			[
				"viga_iniciativas.id",
				"viga_iniciativas.nombre",
				"viga_iniciativas.descripcion",
				"viga_iniciativas.id_programa",
        "viga_iniciativas.id_mecanismo",
        "viga_iniciativas.id_frecuencia",
				"viga_iniciativas.fecha_creacion",

        "viga_iniciativas.estado",
        "viga_iniciativas.estado_ejecucion",
        "viga_iniciativas.estado_completitud",
				//"viga_entornos.nombre(entornos)"
			],
				$conditions
		);

		//echo "query: " . $db->last() . "<br><br>";

		//return array_unique($datas);
		return ($datas);
	}


 ?>
