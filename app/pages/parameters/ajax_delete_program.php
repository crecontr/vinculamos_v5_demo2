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
	if(!canDeleteParameters()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if( isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_usuario']) ) {

		include("../../controller/medoo_programs.php");
		$result = deleteProgram(noeliaDecode($_REQUEST['vg_id']), noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) { ?>
			<div class="box-body">
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Programa eliminado correctamente.
				</div>
			</div>
		<?php
		} else { ?>
			<div class="box-body">
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					El programa que intenta eliminar no existe.
				</div>
			</div>
		<?php
		}
	}
?>
