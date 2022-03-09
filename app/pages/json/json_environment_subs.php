<?php

	//header('Content-type: application/json');
	if( isset($_REQUEST['vg_entorno']) ) {

		$entornos = $_REQUEST['vg_entorno'];

		include("../../controller/medoo_environment_sub.php");

		$finalArray = [];
		for($i=0; $i<sizeof($entornos); $i++) {
			$result = getVisibleEnvironmentsSubByEnvironment($entornos[$i]);
			$finalArray = array_merge($finalArray, $result);
		}

		echo json_encode($finalArray, JSON_PRETTY_PRINT);
		return;
	} else {
		echo "Falta info";
	}


?>
