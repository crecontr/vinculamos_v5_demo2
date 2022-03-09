<?php
	if(!isset($_SESSION)){
		@session_start();
	}

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

	// vg_usuario, vg_id_initiative
	// vg_rut, vg_nombre, vg_correo, vg_telefono
	if(false) {
		echo "<br>vg_initiative: " . noeliaDecode($_REQUEST['vg_initiative']);
		echo "<br>vg_id: " . noeliaDecode($_REQUEST['vg_id']);
		echo "<br>vg_usuario: " . noeliaDecode($_REQUEST['vg_usuario']);
		return;
	}

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_evaluation_evaluators.php");
		$result = deleteEvaluator(noeliaDecode($_REQUEST['vg_id']), noeliaDecode($_REQUEST['vg_initiative']),
			noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Participante guardado correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				El participante que intenta agregar ya existe.
			</div>
		<?php
		}

	} else {
		echo "<br> Falta info";
	}
?>
