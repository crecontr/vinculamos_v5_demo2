<?php

	function getFilterInitiativesByEnvironment($datas = null, $environment = null) {
		$result = array();

		for ($j=0; $j < sizeof($datas); $j++) {
			$myEnvironments = $datas[$j]['environments'];
			for ($k=0; $k < sizeof($myEnvironments); $k++) {
				if($environment == $myEnvironments[$k]["id"]) {
					$result[] = $datas[$j];
				}
			}
		}

		return $result;
	}

	function getFilterInitiativesByCollege($datas = null, $college = null) {
		$result = array();

		for ($j=0; $j < sizeof($datas); $j++) {
			$myColleges = $datas[$j]['colleges'];
			for ($k=0; $k < sizeof($myColleges); $k++) {
				if($college == $myColleges[$k]["id"]) {
					$result[] = $datas[$j];
				}
			}
		}

		return $result;
	}



?>
