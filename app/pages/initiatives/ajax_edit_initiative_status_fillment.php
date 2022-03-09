<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	session_start();
	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if(false) {
		echo "<br>vg_usuario: " . $_REQUEST['vg_usuario'];
		echo "<br>vg_initiative: " . $_REQUEST['vg_initiative'];
	}

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_estado_completitud'])
		&& isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_initiatives.php");
		$result = editInitiativeStatusFillment(noeliaDecode($_REQUEST['vg_initiative']),
			$_REQUEST['vg_estado_completitud'], noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) {
			$resultado["id"] = $result[0]["id"];
			$resultado["estado_completitud"] = $result[0]["estado_completitud"];
			echo json_encode($resultado);
		} else {
			echo "-1";
		}
	} else {
		echo "Falta info!";
	}
?>
