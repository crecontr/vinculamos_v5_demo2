<?php

	//header('Content-type: application/json');

	if( isset($_GET['id_resource']) ) {

		$id_resource = $_GET['id_resource'];

		include("../../controller/medoo_resource_human.php");

		$result = getHumanResourcesTypeByNombre($id_resource);

		echo json_encode($result[0], JSON_PRETTY_PRINT);
		return;
	}

?>
