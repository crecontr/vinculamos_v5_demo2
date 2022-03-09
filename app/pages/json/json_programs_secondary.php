<?php

	//header('Content-type: application/json');
	if( isset($_REQUEST['vg_programa']) ) {

		$id_programa = $_REQUEST['vg_programa'];

		include("../../controller/medoo_programs.php");
		$programs = getVisiblePrograms();

		$finalArray = array();
		for($i=0; $i<sizeof($programs); $i++) {
			if($programs[$i]["id"] != $id_programa) {
				$finalArray[] = $programs[$i];
			}
		}

		echo json_encode($finalArray, JSON_PRETTY_PRINT);
		return;
	} else {
		echo "Falta info";
	}


?>
