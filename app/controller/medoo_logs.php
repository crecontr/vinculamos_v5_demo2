<?php

	function logAction($db = null, $autor = null, $recurso = null, $id_recurso = null, $descripcion = null) {

		$db->insert("viga_logs",
			[
				"autor" => $autor,
				"recurso" => $recurso,
				"id_recurso" => $id_recurso,
				"descripcion" => $descripcion
			]
		);

		//echo "<br>query: " . $db->last();
	}

?>
