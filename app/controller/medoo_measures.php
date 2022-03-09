<?php
	/*
		SELECT `id`, `nombre`, `concepto_pertinente`, `factor`, `id_objetivo`, `fecha_creacion`
		FROM `viga_metas` WHERE 1
	*/

	function getMeasure($id_measure = null) {
		include("db_config.php");

		$datas = $db->select("viga_metas",
			[
				"id",
				"nombre",
				"id_objetivo",
				"concepto_pertinente",
				"factor"
			],
			[
				"visible" => "1",
				"id" => $id_measure
			]
		);

		return $datas;
	}

	function getMeasuresByObjetive($id_objetive = null) {
		include("db_config.php");

		$datas = $db->select("viga_metas",
			[
				"id",
				"nombre",
				"id_objetivo",
				"concepto_pertinente",
				"factor"
			],
			[
				"visible" => "1",
				"id_objetivo" => $id_objetive
			]
		);

		return $datas;
	}

	function getVisibleMeasuresByInitiative($id_initiative) {
		include("db_config.php");

		$initiative = $db->select("viga_iniciativas",
			[
				"id", "nombre", "descripcion", "objetivo", "impacto_esperado", "resultado_esperado", "visible", "institucion", "autor"
			],
			[
				"visible" => "1",
				"id" => $id_initiative
			]
		);
		//echo "<br>query: " . $db->last();

		$myMeasures = array();
		$objetives = $db->select("viga_objetivos",
			[
				"id",
				"nombre_largo"
			],
			[
				"visible" => "1"
			]
		);

		for($i=0 ; $i<sizeof($objetives) ; $i++) {
			$measures = $db->select("viga_metas",
				[
					"id",
					"nombre",
					"id_objetivo"
				],
				[
					"visible" => "1",
					"id_objetivo" => $objetives[$i]["id"]
				]
			);

			for($j=0 ; $j<sizeof($measures) ; $j++) {
				$concepts = $db->select("viga_concepto_pertinente",
		      [
		        "id",
		        "id_meta",
		        "concepto",
		      ],
		      [
		        "id_meta" => $measures[$j]["id"]
		      ]
		    );

				for($x=0 ; $x<sizeof($concepts) ; $x++) {
					//echo "<br>	" . $concepts[$x]["concepto"];
					$conceptoMinuscula = strtolower($concepts[$x]["concepto"]);

					if (strpos(strtolower($initiative[0]["objetivo"]), $conceptoMinuscula) !== false ||
						strpos(strtolower($initiative[0]["descripcion"]), $conceptoMinuscula) !== false ||
						strpos(strtolower($initiative[0]["impacto_esperado"]), $conceptoMinuscula) !== false ||
						strpos(strtolower($initiative[0]["resultado_esperado"]), $conceptoMinuscula) !== false) {

							if (!in_array($measures[$j], $myMeasures)) {
									$myMeasures[] = $measures[$j];
									//echo "<br>	Concepto -> " . $concepts[$x]["concepto"];
							}
					}

				}
			}
		}

		return $myMeasures;
	}

?>
