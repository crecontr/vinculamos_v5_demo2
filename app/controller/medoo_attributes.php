<?php
	/* GESTOR DE VÍNCULO */
	function getVisibleLinksManagerType() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_gestor_vinculo",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* CARGO DEL ENCARGADO */
	function getVisibleManagerPositions() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_cargo_encargado",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* CARGO DEL ENCARGADO */
	function getVisibleImplementationFormats() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_formato_implementacion",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* TIPO IMPACTO INTERNO */
	function getVisibleInternalImpactTypes() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_impacto_interno",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* TIPO IMPACTO EXTERNO */
	function getVisibleExternalImpactTypes() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_impacto_externo",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* TIPO ESTADO EJECUCIÓN */
	function getVisibleExecutionStatus() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_estado_ejecucion",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* TIPO ESTADO COMPLETITUD  */
	function getVisibleFillmentStatus() {
		include("db_config.php");

		$datas = $db->select("viga_tipo_estado_completitud",
			[
				"id",
				"nombre",
				"visible",
				"autor",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

?>
