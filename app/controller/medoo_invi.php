<?php

	function calculateInviByInitiative($idInitiative = null) {
		include("db_config.php");

		$iniciativa = $db->select("viga_iniciativas",
			[
				"id", "nombre", "descripcion", "objetivo", "resultado_esperado", "fecha_inicio", "fecha_finalizacion",
				"id_programa", "id_mecanismo", "id_frecuencia", "visible", "institucion", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id" => $idInitiative
			]
		);

		/* SECCIÓN MECANISMO */
		$mecanismo = $db->select("viga_atributo_mecanismo",
			[
				"id",
				"nombre",
				"descripcion",
				"puntaje",
				"visible",
				"fecha_creacion"
			],
			[
				"id" => $iniciativa[0]["id_mecanismo"]
			]
		);
		if($mecanismo != null) {
			$result["mecanismo"]["etiqueta"] = $mecanismo[0]["nombre"];
			$result["mecanismo"]["valor"] = round($mecanismo[0]["puntaje"]);
		} else {
			$result["mecanismo"]["etiqueta"] = "-";
			$result["mecanismo"]["valor"] = 0;
		}


		/* Cobertura = 0,30*Territorialidad + 0,40*Pertinencia + 0,30*Cantidad */
		/* SECCIÓN COBERTURA - TERRITORIALIDAD */
		$geoPaises = $db->query(
			"SELECT DISTINCT `viga_geo_pais`.`id`,`viga_geo_pais`.`nombre`
			FROM `viga_geo_pais` INNER JOIN `viga_iniciativas_geo_pais` ON `viga_geo_pais`.`id` = `viga_iniciativas_geo_pais`.`id_pais`
			WHERE `viga_iniciativas_geo_pais`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();

		$geoRegiones = $db->query(
			"SELECT DISTINCT `viga_geo_region`.`id`,`viga_geo_region`.`nombre`
			FROM `viga_geo_region` INNER JOIN `viga_iniciativas_geo_region` ON `viga_geo_region`.`id` = `viga_iniciativas_geo_region`.`id_region`
			WHERE `viga_iniciativas_geo_region`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();

		$geoComunas = $db->query(
			"SELECT DISTINCT `viga_geo_comuna`.`id`,`viga_geo_comuna`.`nombre`
			FROM `viga_geo_comuna` INNER JOIN `viga_iniciativas_geo_comuna` ON `viga_geo_comuna`.`id` = `viga_iniciativas_geo_comuna`.`id_comuna`
			WHERE `viga_iniciativas_geo_comuna`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();

		if(sizeof($geoPaises) == 1) {
			if(sizeof($geoRegiones) == 1) {
				if(sizeof($geoComunas) == 1) {
					//echo "<br>Comunal";
					$datasCoverage[0] = "Comunal";
					$datasCoverage[1] = "100";
				}
				if(sizeof($geoComunas) == 0 || sizeof($geoComunas) > 1) {
					//echo "<br>Regional";
					$datasCoverage[0] = "Regional";
					$datasCoverage[1] = "100";
				}
			}
			if(sizeof($geoRegiones) == 0 || sizeof($geoRegiones) > 1) {
				//echo "<br>Nacional";
				$datasCoverage[0] = "Nacional";
				$datasCoverage[1] = "100";
			}
		} else {
			if(sizeof($geoPaises) == 2) {
				//echo "<br>Binacional";
				$datasCoverage[0] = "Binacional";
				$datasCoverage[1] = "100";
			}
			if(sizeof($geoPaises) > 2) {
				//echo "<br>Internacional";
				$datasCoverage[0] = "Internacional";
				$datasCoverage[1] = "100";
			}
		}
		$result["cobertura_territorialidad"]["etiqueta"] = $datasCoverage[0];
		$result["cobertura_territorialidad"]["valor"] = $datasCoverage[1];

		/* SECCIÓN COBERTURA - PERTINENCIA */
		$participationRealPueblo = $db->sum("viga_participacion_real", "vulnerabilidad_pueblo",["visible" => "1","id_iniciativa" => $idInitiative]);
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		$participationRealDiscap = $db->sum("viga_participacion_real", "vulneravulnerabilidad_discapacidadbilidad_pueblo",["visible" => "1","id_iniciativa" => $idInitiative]);
		$participationRealPobreza = $db->sum("viga_participacion_real", "vulnerabilidad_pobreza",["visible" => "1","id_iniciativa" => $idInitiative]);


		$participationReal = $datas = $db->select("viga_participacion_real",
			[
				"id", "tipo", "id_iniciativa", "publico_general",
				"aplica_sexo", "sexo_masculino", "sexo_femenino", "sexo_otro",
				"aplica_edad", "edad_ninos", "edad_jovenes", "edad_adultos", "edad_adultos_mayores",
				"aplica_procedencia", "procedencia_rural", "procedencia_urbano",
				"aplica_vulnerabilidad", "vulnerabilidad_pueblo", "vulnerabilidad_discapacidad", "vulnerabilidad_pobreza",
				"visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $idInitiative
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		$participationEsperada = $db->select("viga_participacion_plan",
			[
				"id", "tipo", "id_iniciativa", "publico_general",
				"aplica_sexo", "sexo_masculino", "sexo_femenino", "sexo_otro",
				"aplica_edad", "edad_ninos", "edad_jovenes", "edad_adultos", "edad_adultos_mayores",
				"aplica_procedencia", "procedencia_rural", "procedencia_urbano",
				"aplica_vulnerabilidad", "vulnerabilidad_pueblo", "vulnerabilidad_discapacidad", "vulnerabilidad_pobreza",
				"visible", "autor", "fecha_creacion"
			],
			[
				"visible" => "1",
				"id_iniciativa" => $idInitiative
			]
		);
		//echo "<br>>>query: " . $db->last() . "<br><br>";

		$tienePublicoEspecifico = false;
		for($i=0 ; $i<sizeof($participationReal) ; $i++) {
			if($participationReal[$i]["aplica_sexo"] == "on" || $participationReal[$i]["aplica_edad"] == "on"
				|| $participationReal[$i]["aplica_procedencia"] == "on" || $participationReal[$i]["aplica_vulnerabilidad"] == "on") {
				$tienePublicoEspecifico = true;
			}
		}

		if(sizeof($participationReal) > 0) {
			if($tienePublicoEspecifico == true) {
				$result["cobertura_pertinencia"]["etiqueta"] = "Publico Especifico";
				$result["cobertura_pertinencia"]["valor"] = 100;
			}

			if($tienePublicoEspecifico == false) {
				$result["cobertura_pertinencia"]["etiqueta"] = "Publico General";
				/* ANTERIORMENTE: $result["cobertura_pertinencia"]["valor"] = 70; */
				$result["cobertura_pertinencia"]["valor"] = 100;
			}
		} else {
			$result["cobertura_pertinencia"]["etiqueta"] = "-";
			$result["cobertura_pertinencia"]["valor"] = 0;
		}

		/* SECCIÓN COBERTURA - CANTIDAD */
		$sumaParticipaconReal = 0;
		for ($i=0; $i < sizeof($participationReal); $i++) {
			$sumaParticipaconReal += $participationReal[$i]["publico_general"];
		}

		$sumaParticipaconEsperada = 0;
		for ($i=0; $i < sizeof($participationEsperada); $i++) {
			$sumaParticipaconEsperada += $participationEsperada[$i]["publico_general"];
		}

		$porcCantidad = ($sumaParticipaconEsperada != 0 ? ($sumaParticipaconReal / $sumaParticipaconEsperada)*100 : 0);
		if($sumaParticipaconReal == 0) {
			$result["cobertura_cantidad"]["etiqueta"] = "-";
			$result["cobertura_cantidad"]["valor"] = 0;
		}
		if($porcCantidad >= 100) {
			$result["cobertura_cantidad"]["etiqueta"] = "Cumplimiento Total";
			$result["cobertura_cantidad"]["valor"] = 100;
		}
		if($porcCantidad < 100 && $porcCantidad >= 50) {
			$result["cobertura_cantidad"]["etiqueta"] = "Cumplimiento Parcial";
			$result["cobertura_cantidad"]["valor"] = 50;
		}
		if($porcCantidad < 50) {
			$result["cobertura_cantidad"]["etiqueta"] = "Sin Cumplimiento";
			$result["cobertura_cantidad"]["valor"] = 0;
		}

		/* SECCIÓN FRECUENCIA */
		$frecuencia = $db->select("viga_atributo_frecuencia",
			[
				"id", "nombre", "descripcion", "puntaje", "visible", "fecha_creacion"
			],
			[
				"id" => $iniciativa[0]["id_frecuencia"]
			]
		);
		$result["frecuencia"]["etiqueta"] = $frecuencia[0]["nombre"];
		$result["frecuencia"]["valor"] = round($frecuencia[0]["puntaje"]);

		/* SECCIÓN EVALUACIÓN */
		/* SECCIÓN EVALUACIÓN INTERNA */
		$evaluacionEstudiante = $datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id", "id_iniciativa", "tipo_evaluacion", "visible"
			],
			[
				"visible" => "1", "id_iniciativa" => $idInitiative, "tipo_evaluacion" => "Evaluador interno - Estudiante"
			]
		);
		//echo "<br> encuestas estudiantes: " . sizeof($evaluacionEstudiante);

		$evaluacionProfesor = $datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id", "id_iniciativa", "tipo_evaluacion", "visible"
			],
			[
				"visible" => "1", "id_iniciativa" => $idInitiative, "tipo_evaluacion" => "Evaluador interno - Docente"
			]
		);
		//echo "<br> encuestas profesores: " . sizeof($evaluacionProfesor);

		$evaluacionJefatura = $datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id", "id_iniciativa", "tipo_evaluacion", "visible"
			],
			[
				"visible" => "1", "id_iniciativa" => $idInitiative, "tipo_evaluacion" => "Evaluador interno - Jefatura"
			]
		);
		//echo "<br> encuestas jefaturas: " . sizeof($evaluacionJefatura);

		$evaluacionDirectivo = $datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id", "id_iniciativa", "tipo_evaluacion", "visible"
			],
			[
				"visible" => "1", "id_iniciativa" => $idInitiative, "tipo_evaluacion" => "Evaluador interno - Directivo"
			]
		);
		//echo "<br> encuestas directivos: " . sizeof($evaluacionDirectivo);

		/* ESTUDIANTE */
		$estudianteConocimientoORI = $db->avg("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionEstudiante[0]["id"], "clave[~]" => "CONOCIMIENTO_%"
			]
		);
		//echo "<br> encuestas estudiante conocimiento ori: " . $estudianteConocimientoORI;

		$estudianteCumplimientoORI = $db->avg("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionEstudiante[0]["id"], "clave[~]" => "CUMPLIMIENTO_%"
			]
		);
		//echo "<br> encuestas estudiante cumplimiento ori: " . $estudianteCumplimientoORI;

		$estudianteCalidadSum = $db->sum("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionEstudiante[0]["id"], "clave[~]" => "COMPROMISO_%", "valor[!]" => ""
			]
		);
		$estudianteCalidadCount = $db->select("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionEstudiante[0]["id"], "clave[~]" => "COMPROMISO_%", "valor[!]" => ""
			]
		);
		$estudianteCalidad = sizeof($estudianteCalidadCount) == 0 ? 0:($estudianteCalidadSum / (sizeof($estudianteCalidadCount) * 3)) * 100;
		if(sizeof($estudianteCalidadCount) == 0) {
			$estudianteCalidad = 0;
		}
		//echo "<br> encuestas estudiante calidad: " . $estudianteCalidadSum;
		//echo "<br> encuestas estudiante calidad count: " . sizeof($estudianteCalidadCount);

		$estudianteCompetenciasSum = $db->sum("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionEstudiante[0]["id"], "clave[~]" => "COMPETENCIA_%", "valor[!]" => ""
			]
		);
		$estudianteCompetenciasCount = $db->select("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionEstudiante[0]["id"], "clave[~]" => "COMPETENCIA_%", "valor[!]" => ""
			]
		);
		$estudianteCompetencias = sizeof($estudianteCompetenciasCount) == 0 ? 0:($estudianteCompetenciasSum / (sizeof($estudianteCompetenciasCount) * 3)) * 100;
		if(sizeof($estudianteCompetenciasCount) == 0) {
			$estudianteCompetencias = 0;
		}
		//echo "<br> encuestas estudiante competencias: " . $estudianteCompetenciasSum;
		//echo "<br> encuestas estudiante competencias count: " . sizeof($estudianteCompetenciasCount);

		$evaEstudiante = (0.15*$estudianteConocimientoORI) + (0.3*$estudianteCumplimientoORI) + (0.15*$estudianteCalidad) + (0.4*$estudianteCompetencias);
		//echo "<br> eva estudiante: " . $evaEstudiante;

		/* PROFESOR */
		$profesorConocimientoORI = $db->avg("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionProfesor[0]["id"], "clave[~]" => "CONOCIMIENTO_%"
			]
		);
		//echo "<br> encuestas profesor conocimiento ori: " . $profesorConocimientoORI;

		$profesorCumplimientoORI = $db->avg("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionProfesor[0]["id"], "clave[~]" => "CUMPLIMIENTO_%"
			]
		);
		//echo "<br> encuestas profesor cumplimiento ori: " . $profesorCumplimientoORI;

		$profesorCalidadSum = $db->sum("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionProfesor[0]["id"], "clave[~]" => "COMPROMISO_%", "valor[!]" => ""
			]
		);
		$profesorCalidadCount = $db->select("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionProfesor[0]["id"], "clave[~]" => "COMPROMISO_%", "valor[!]" => ""
			]
		);
		$profesorCalidad = sizeof($profesorCalidadCount) == 0 ? 0:($profesorCalidadSum / (sizeof($profesorCalidadCount) * 3)) * 100;
		if(sizeof($profesorCalidadCount) == 0) {
			$profesorCalidad = 0;
		}
		//echo "<br> encuestas profesor calidad: " . $profesorCalidadSum;
		//echo "<br> encuestas profesor calidad count: " . sizeof($profesorCalidadCount);

		$profesorCompetenciasSum = $db->sum("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionProfesor[0]["id"], "clave[~]" => "COMPETENCIA_%", "valor[!]" => ""
			]
		);
		$profesorCompetenciasCount = $db->select("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionProfesor[0]["id"], "clave[~]" => "COMPETENCIA_%", "valor[!]" => ""
			]
		);
		$profesorCompetencias = sizeof($profesorCompetenciasCount) == 0 ? 0:($profesorCompetenciasSum / (sizeof($profesorCompetenciasCount) * 3)) * 100;
		if(sizeof($profesorCompetenciasCount) == 0) {
			$profesorCompetencias = 0;
		}
		//echo "<br> encuestas profesor competencias: " . $profesorCompetenciasSum;
		//echo "<br> encuestas profesor competencias count: " . sizeof($profesorCompetenciasCount);

		$evaProfesor = (0.15*$profesorConocimientoORI) + (0.3*$profesorCumplimientoORI) + (0.15*$profesorCalidad) + (0.4*$profesorCompetencias);
		//echo "<br> eva profesor: " . $evaProfesor;

		if(sizeof($evaluacionEstudiante) > 0 && sizeof($evaluacionProfesor) > 0) { /* TIENE AMBAS */
			$ponderacionEstudiante = 0.7;
			$ponderacionProfesor = 0.3;
		} else {
			if(sizeof($evaluacionEstudiante) > 0 && sizeof($evaluacionProfesor) == 0) {
				$ponderacionEstudiante = 1;
				$ponderacionProfesor = 0;
			}

			if(sizeof($evaluacionEstudiante) == 0 && sizeof($evaluacionProfesor) > 0) {
				$ponderacionEstudiante = 0;
				$ponderacionProfesor = 1;
			}

			if(sizeof($evaluacionEstudiante) == 0 && sizeof($evaluacionProfesor) == 0) {
				$ponderacionEstudiante = 0;
				$ponderacionProfesor = 0;
			}
		}
		$puntajeInterno = round(($evaEstudiante * $ponderacionEstudiante) + ($evaProfesor * $ponderacionProfesor));
		//echo "<br> evaEstudiante: " . $evaEstudiante;
		//echo "<br> ponderacionEstudiante: " . $ponderacionEstudiante;
		//echo "<br> evaProfesor: " . $evaProfesor;
		//echo "<br> ponderacionProfesor: " . $ponderacionProfesor;
		//echo "<br> eva interno: " . $puntajeInterno;

		$result["evaluacionInterna"]["valor"] = 0;
		$result["evaluacionInterna"]["etiqueta"] = "No encontrado";
		if($puntajeInterno <= 20 || (sizeof($evaluacionEstudiante) + sizeof($evaluacionProfesor)) == 0) {
			$result["evaluacionInterna"]["valor"] = 20;
			$result["evaluacionInterna"]["etiqueta"] = "Muy Baja (0% - 20%)";
		}
		if($puntajeInterno > 20 && $puntajeInterno <= 40 ) {
			$result["evaluacionInterna"]["valor"] = 40;
			$result["evaluacionInterna"]["etiqueta"] = "Baja (21% - 40%)";
		}
		if($puntajeInterno > 40 && $puntajeInterno <= 60 ) {
			$result["evaluacionInterna"]["valor"] = 60;
			$result["evaluacionInterna"]["etiqueta"] = "Medio (41% - 60%)";
		}
		if($puntajeInterno > 60 && $puntajeInterno <= 80 ) {
			$result["evaluacionInterna"]["valor"] = 80;
			$result["evaluacionInterna"]["etiqueta"] = "Alto (61% - 80%)";
		}
		if($puntajeInterno > 80) {
			$result["evaluacionInterna"]["valor"] = 100;
			$result["evaluacionInterna"]["etiqueta"] = "Muy Alto (81% - 100%)";
		}


		/* SECCIÓN EVALUACIÓN EXTERNA */
		$evaluacionSocio = $datas = $db->select("viga_evaluacion_iniciativa",
			[
				"id", "id_iniciativa", "tipo_evaluacion", "visible"
			],
			[
				"visible" => "1", "id_iniciativa" => $idInitiative, "tipo_evaluacion" => "Evaluador externo"
			]
		);
		//echo "<br> encuestas socio: " . sizeof($evaluacionSocio);

		/* SOCIO COMUNITARIO */
		$socioConocimientoORI = $db->avg("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionSocio[0]["id"], "clave[~]" => "CONOCIMIENTO_%"
			]
		);
		//echo "<br> encuestas socio conocimiento ori: " . $socioConocimientoORI;

		$socioCumplimientoORI = $db->avg("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionSocio[0]["id"], "clave[~]" => "CUMPLIMIENTO_%"
			]
		);
		//echo "<br> encuestas socio cumplimiento ori: " . $socioCumplimientoORI;

		$socioCalidadSum = $db->sum("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionSocio[0]["id"], "clave[~]" => "COMPROMISO_%", "valor[!]" => ""
			]
		);
		$socioCalidadCount = $db->select("viga_evaluacion_detalle_respuesta",
			"valor",
			[
				"id_iniciativa" => $idInitiative, "id_evaluacion" => $evaluacionSocio[0]["id"], "clave[~]" => "COMPROMISO_%", "valor[!]" => ""
			]
		);
		$socioCalidad = sizeof($socioCalidadCount)==0 ? 0:($socioCalidadSum / (sizeof($socioCalidadCount) * 3)) * 100;
		if(sizeof($socioCalidadCount) == 0) {
			$socioCalidad = 0;
		}
		//echo "<br> encuestas socio calidad: " . $socioCalidadSum;
		//echo "<br> encuestas socio calidad count: " . sizeof($socioCalidadCount);

		$puntajeExterno = (0.2*$socioConocimientoORI) + (0.5*$socioCumplimientoORI) + (0.3*$socioCalidad);
		//echo "<br> eva socio: " . $puntajeExterno;

		if($puntajeExterno <= 20 || sizeof($evaluacionSocio) == 0) {
			$result["evaluacionExterna"]["valor"] = 20;
			$result["evaluacionExterna"]["etiqueta"] = "Muy Baja (0% - 20%)";
		}
		if($puntajeExterno > 20 && $puntajeExterno <= 40 ) {
			$result["evaluacionExterna"]["valor"] = 40;
			$result["evaluacionExterna"]["etiqueta"] = "Baja (21% - 40%)";
		}
		if($puntajeExterno > 40 && $puntajeExterno <= 60 ) {
			$result["evaluacionExterna"]["valor"] = 60;
			$result["evaluacionExterna"]["etiqueta"] = "Medio (41% - 60%)";
		}
		if($puntajeExterno > 60 && $puntajeExterno <= 80 ) {
			$result["evaluacionExterna"]["valor"] = 80;
			$result["evaluacionExterna"]["etiqueta"] = "Alto (61% - 80%)";
		}
		if($puntajeExterno > 80) {
			$result["evaluacionExterna"]["valor"] = 100;
			$result["evaluacionExterna"]["etiqueta"] = "Muy Alto (81% - 100%)";
		}

		$result["evaluacion"]["valor"] = round($result["evaluacionInterna"]["valor"]*0.5 + $result["evaluacionExterna"]["valor"]*0.5);
		$result["evaluacion"]["etiqueta"] = "";

		/* RESULTADO INVI */
		$cobertura = (0.3 * $result["cobertura_territorialidad"]["valor"]) + (0.4 * $result["cobertura_pertinencia"]["valor"]) + (0.3 * $result["cobertura_cantidad"]["valor"]);
		$invi = (0.2 * $result["mecanismo"]["valor"]) + (0.35 * $cobertura) + (0.35 * $result["evaluacion"]["valor"]) + (0.1 * $result["frecuencia"]["valor"]);

		$result["invi"]["total"] = round($invi);
		//echo "<br>query: " . $db->last();
		return $result;
	}

?>
