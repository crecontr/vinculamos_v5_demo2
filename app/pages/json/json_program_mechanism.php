<?php

	//header('Content-type: application/json');
	if( isset($_REQUEST['vg_programa']) ) {

		$id_programa = $_REQUEST['vg_programa'];

		include("../../controller/medoo_invi_attributes.php");
		$finalArray = getVisibleMechanismByProgram($id_programa);

		echo json_encode($finalArray, JSON_PRETTY_PRINT);
		return;
	} else {
		echo "Falta info";
	}


?>
