<?php

	//header('Content-type: application/json');
	if( isset($_REQUEST['vg_pais']) ) {

		$paises = $_REQUEST['vg_pais'];

		include("../../controller/medoo_geographic.php");

		$finalArray = [];
		for($i=0; $i<sizeof($paises); $i++) {
			$result = getVisibleRegionsByCountry($paises[$i]);
			$finalArray = array_merge($finalArray, $result);
		}

		echo json_encode($finalArray, JSON_PRETTY_PRINT);
		return;
	}


?>
