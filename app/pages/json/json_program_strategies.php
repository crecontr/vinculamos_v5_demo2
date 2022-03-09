<?php

	//header('Content-type: application/json');
	if( isset($_REQUEST['vg_programa']) ) {

		$id_programa = $_REQUEST['vg_programa'];

		include("../../controller/medoo_programs_strategies.php");
		$finalArray = getVisibleProgramStrategiesByProgram($id_programa);

		echo json_encode($finalArray, JSON_PRETTY_PRINT);
		return;
	} else {
		echo "Falta info";
	}


?>
