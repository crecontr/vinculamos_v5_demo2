<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canCreateParameters()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if( isset($_REQUEST['vg_mecanismo']) && isset($_REQUEST['vg_id_program']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_programs_action_types.php");
		$result = addProgramActionType($_REQUEST['vg_mecanismo'], noeliaDecode($_REQUEST['vg_id_program']),
			noeliaDecode($_REQUEST['vg_usuario']), $institucion);

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Tipo de acción guardado correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				El tipo de acción que intenta agregar ya existe.
			</div>
		<?php
		}


	}
?>
