<?php
	/* Institution related to Users */
	function getInstitution() {
		return $_SESSION["permiso_institucion"];
	}

	/* Permissions related to Users */
	function canCreateUsers() {
		return containsPermission($_SESSION["permiso_usuarios"], "c");
	}
	function canReadUsers() {
		return containsPermission($_SESSION["permiso_usuarios"], "r");
	}
	function canUpdateUsers() {
		return containsPermission($_SESSION["permiso_usuarios"], "u");
	}
	function canDeleteUsers() {
		return containsPermission($_SESSION["permiso_usuarios"], "d");
	}

	/* Permissions related to Objetives */
	function canCreateObjetives() {
		return containsPermission($_SESSION["permiso_objetivos"], "c");
	}
	function canReadObjetives() {
		return containsPermission($_SESSION["permiso_objetivos"], "r");
	}
	function canUpdateObjetives() {
		return containsPermission($_SESSION["permiso_objetivos"], "u");
	}
	function canDeleteObjetives() {
		return containsPermission($_SESSION["permiso_objetivos"], "d");
	}

	/* Permissions related to Initiatives */
	function canCreateInitiatives() {
		return containsPermission($_SESSION["permiso_iniciativas"], "c");
	}
	function canReadInitiatives() {
		return containsPermission($_SESSION["permiso_iniciativas"], "r");
	}
	function canUpdateInitiatives() {
		return containsPermission($_SESSION["permiso_iniciativas"], "u");
	}
	function canDeleteInitiatives() {
		return containsPermission($_SESSION["permiso_iniciativas"], "d");
	}
	function canSuperviseInitiatives() {
		return containsPermission($_SESSION["permiso_iniciativas"], "s");
	}

	/* Permissions related to Challenges */
	function canCreateChallenges() {
		return containsPermission($_SESSION["permiso_desafios"], "c");
	}
	function canReadChallenges() {
		return containsPermission($_SESSION["permiso_desafios"], "r");
	}
	function canUpdateChallenges() {
		return containsPermission($_SESSION["permiso_desafios"], "u");
	}
	function canDeleteChallenges() {
		return containsPermission($_SESSION["permiso_desafios"], "d");
	}

	/* Permissions related to Dashboards */
	function canCreateStats() {
		return containsPermission($_SESSION["permiso_estadisticas"], "c");
	}
	function canReadStats() {
		return containsPermission($_SESSION["permiso_estadisticas"], "r");
	}
	function canUpdateStats() {
		return containsPermission($_SESSION["permiso_estadisticas"], "u");
	}
	function canDeleteStats() {
		return containsPermission($_SESSION["permiso_estadisticas"], "d");
	}
	function canSuperviseStats() {
		return containsPermission($_SESSION["permiso_estadisticas"], "s");
	}

	/* Permissions related to Parameters */
	function canCreateParameters() {
		return containsPermission($_SESSION["permiso_parametros"], "c");
	}
	function canReadParameters() {
		return containsPermission($_SESSION["permiso_parametros"], "r");
	}
	function canUpdateParameters() {
		return containsPermission($_SESSION["permiso_parametros"], "u");
	}
	function canDeleteParameters() {
		return containsPermission($_SESSION["permiso_parametros"], "d");
	}

	/* Extra utils */
	function containsPermission($main, $substring) {
    	return strpos($main, $substring) !== false;
	}

	function noeliaEncode($dato) {
		$resultado = $dato;
		$arrayLetras = array('N', 'O', 'E', 'L', 'I', 'A');
		$limite = count($arrayLetras) - 1;
		$num = mt_rand(0, $limite);
		for ($i = 1; $i <= $num; $i++) {
			$resultado = base64_encode($resultado);
		}
		$resultado = $resultado . '+' . $arrayLetras[$num];
		$resultado = base64_encode($resultado);
		return $resultado;
	}

	function noeliaDecode($dato) {
		$resultado = base64_decode($dato);
		list($resultado, $letra) = explode('+', $resultado);
		$arrayLetras = array('N', 'O', 'E', 'L', 'I', 'A');
		for ($i = 0; $i < count($arrayLetras); $i++) {
			if ($arrayLetras[$i] == $letra) {
				for ($j = 1; $j <= $i; $j++) {
					$resultado = base64_decode($resultado);
				}
				break;
			}
		}
		return $resultado;
	}
?>
