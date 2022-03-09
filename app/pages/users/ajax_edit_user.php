<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateUsers()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}
	
	$institucion = getInstitution();

	if( isset($_REQUEST['vg_nombre']) && isset($_REQUEST['vg_apellido'])
		&& isset($_REQUEST['vg_telefono']) && isset($_REQUEST['vg_correo_electronico'])
		&& isset($_REQUEST['vg_perfil']) && isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_estado']) ) {

		include_once("../../controller/medoo_users.php");
		$result = editUser($_REQUEST['vg_nombre'], $_REQUEST['vg_apellido'], $_REQUEST['vg_correo_electronico'],
			$_REQUEST['vg_telefono'], noeliaDecode($_REQUEST['vg_perfil']), noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_estado'], noeliaDecode($_REQUEST['vg_usuario']));

		//editUserInstitutionInformation($_REQUEST['vg_nombre_usuario'], $_REQUEST['vg_tipo_institucion'], $_REQUEST['vg_sede_institucion'], $_REQUEST['vg_unidad']);

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Usuario guardado correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimos actualizar la información.
			</div>
		<?php
		}
	}

?>
