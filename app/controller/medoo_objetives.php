<?php

	function getObjetive($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_objetivos",
			[
				"id",
				"nombre",
				"nombre_largo",
				"descripcion",
				"descripcion_larga",
				"id_ambito",
				"fecha_creacion"
			],
			[
				"id" => $id,
				"visible" => "1"
			]
		);

		return $datas;
	}

	function getObjetiveByName($nombre = null) {
		include("db_config.php");

		$datas = $db->select("viga_objetivos",
			[
				"id",
				"nombre_largo",
				"descripcion",
				"descripcion_larga",
				"id_ambito",
				"fecha_creacion"
			],
			[
				"nombre" => $nombre,
				"visible" => "1"
			]
		);

		return $datas;
	}

	function getVisibleObjetives() {
		include("db_config.php");

		$datas = $db->select("viga_objetivos",
			[
				"id",
				"nombre_largo",
				"descripcion",
				"descripcion_larga",
				"id_ambito",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();

		return $datas;
	}

	function getVisibleObjetivesByScopes($scopes = null) {
		include("db_config.php");

		$arrayResult = array();
		for($i=0; $i<sizeof($scopes); $i++) {

			$datas = $db->select("viga_objetivos",
				[
					"id",
					"nombre_largo",
					"descripcion",
					"descripcion_larga",
					"id_ambito",
					"fecha_creacion"
				],
				[
					"visible" => "1",
					"id_ambito[~]" => $scopes[$i]

				]
			);

			$arrayResult += $datas;
		}


		return $arrayResult;
	}

	function getVisibleObjetivesByInitiative($id_initiative) {
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

		$myObjetives = array();
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

							if (!in_array($objetives[$i], $myObjetives)) {
									$myObjetives[] = $objetives[$i];
									//echo "<br>	Concepto -> " . $concepts[$x]["concepto"];
							}
					}

				}
			}
		}

		return $myObjetives;
	}

?>
