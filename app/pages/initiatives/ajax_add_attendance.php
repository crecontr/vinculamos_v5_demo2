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

	if( isset($_REQUEST['vg_id_initiative']) && isset($_REQUEST['vg_rut']) && isset($_REQUEST['vg_nombre']) &&
		isset($_REQUEST['vg_correo']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_attendance_list.php");
		$result = addAttendance(noeliaDecode($_REQUEST['vg_id_initiative']), $_REQUEST['vg_tipo'], $_REQUEST['vg_rut'], $_REQUEST['vg_nombre'],
			$_REQUEST['vg_correo'], $_REQUEST['vg_telefono'], noeliaDecode($_REQUEST['vg_usuario']));

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
