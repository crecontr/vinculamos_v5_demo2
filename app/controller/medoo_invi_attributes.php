<?php
	/* ATRIBUTOS - FRECUENCIA */
	function getFrecuency($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_atributo_frecuencia",
			[
				"id",
				"nombre",
				"descripcion",
				"puntaje",
				"visible",
				"fecha_creacion"
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getVisibleFrecuency() {
		include("db_config.php");

		$datas = $db->select("viga_atributo_frecuencia",
			[
				"id",
				"nombre",
				"descripcion",
				"puntaje",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1"
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	/* ATRIBUTOS - MECANISMO */
	function getMechanism($id = null) {
		include("db_config.php");

		$datas = $db->select("viga_atributo_mecanismo",
			[
				"id",
				"nombre",
				"descripcion",
				"puntaje",
				"visible",
				"fecha_creacion"
			],
			[
				"id" => $id
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getVisibleMechanism() {
		include("db_config.php");

		$datas = $db->select("viga_atributo_mecanismo",
			[
				"id",
				"nombre",
				"descripcion",
				"puntaje",
				"visible",
				"fecha_creacion"
			],
			[
				"visible" => "1",
				"ORDER" => [
	        "puntaje" => "ASC",
	      ]
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

	function getMechanismsByInitiative($idInitiative = null) {
		include("db_config.php");

		$datas = $db->query(
			"SELECT DISTINCT `viga_atributo_mecanismo`.`id`,`viga_atributo_mecanismo`.`nombre`
			FROM `viga_atributo_mecanismo` INNER JOIN `viga_iniciativa_mecanismo` ON `viga_atributo_mecanismo`.`id` = `viga_iniciativa_mecanismo`.`id_atributo`
			WHERE `viga_iniciativa_mecanismo`.`id_iniciativa` = '$idInitiative'"
		)->fetchAll();
		//echo "<br>>>query: " . $db->last() . "<br><br>";
		return $datas;
	}

	function updateMechanismsByInitiative($idInitiative = null, $attributes = null, $autor = null) {
		include("db_config.php");

		$db->delete("viga_iniciativa_mecanismo", [
				"id_iniciativa" => $idInitiative
			]);
		//echo "<br>query: " . $db->last();

		$envsForLog = "";
		for($i=0; $i<sizeof($attributes); $i++) {
			$db->insert("viga_iniciativa_mecanismo", [
				"id_iniciativa" => $idInitiative,
				"id_atributo" => $attributes[$i]
			]);

			$envsForLog .= ($attributes[$i] . " ");
			//echo "<br>query: " . $db->last();
		}

		if(true) {
			include_once("logs.php");
			logAction($db, $autor, "iniciativa_mecanismo", $idInitiative, "Modificación de atributo mecanismo con valores {attributes => [$envsForLog], autor => $autor}");
			return $datas;
		}
	}

	function getVisibleMechanismByProgram($program) {
		include("db_config.php");

		$datas = $db->select("viga_atributo_mecanismo",
			[
				"[><]viga_programas_tipo_accion" => ["viga_atributo_mecanismo.id" => "id_mecanismo"]
			],
			[
				"viga_atributo_mecanismo.id",
				"viga_atributo_mecanismo.nombre",
				"viga_atributo_mecanismo.descripcion",
				"viga_atributo_mecanismo.puntaje",
				"viga_atributo_mecanismo.visible",
				"viga_atributo_mecanismo.fecha_creacion"
			],
			[
				"viga_programas_tipo_accion.visible" => "1",
				"viga_programas_tipo_accion.id_programa" => $program
			]
		);
		//echo "query: " . $db->last();
		return $datas;
	}

?>
