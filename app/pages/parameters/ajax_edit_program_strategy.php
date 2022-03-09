<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateParameters()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}
	
	$institucion = getInstitution();

	if( isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_nombre']) && isset($_REQUEST['vg_descripcion'])
		&& isset($_REQUEST['vg_id_program']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_programs_strategies.php");
		$result = editProgramStrategy(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_nombre'], $_REQUEST['vg_descripcion'],
			noeliaDecode($_REQUEST['vg_id_program']), noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Estrategia guardada correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No se pudo actualizar la información.
			</div>
		<?php
		}


	}
?>
