<?php

	//header('Content-type: application/json');
	if( isset($_REQUEST['vg_region']) ) {

		$regiones = $_REQUEST['vg_region'];

		include("../../controller/medoo_geographic.php");

		$finalArray = [];
		for($i=0; $i<sizeof($regiones); $i++) {
			$result = getVisibleCommuneByRegion($regiones[$i]);
			$finalArray = array_merge($finalArray, $result);
		}

		echo json_encode($finalArray, JSON_PRETTY_PRINT);
		return;
	}


?>
