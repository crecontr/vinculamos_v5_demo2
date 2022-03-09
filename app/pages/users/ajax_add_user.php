<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canCreateUsers()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if( isset($_REQUEST['vg_nombre']) && isset($_REQUEST['vg_apellido'])
		&& isset($_REQUEST['vg_telefono']) && isset($_REQUEST['vg_correo_electronico'])
		&& isset($_REQUEST['vg_perfil']) && isset($_REQUEST['vg_nombre_usuario'])
		&& isset($_REQUEST['vg_contrasenia_1']) && isset($_REQUEST['vg_contrasenia_2']) && isset($_REQUEST['vg_estado']) ) {

		if($_REQUEST['vg_contrasenia_1'] != $_REQUEST['vg_contrasenia_2']) { ?>

			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Las contraseñas ingresadas deben ser iguales.
			</div>
		<?php
			return;
		} else {
			include_once("../../controller/medoo_users.php");
			$result = addUser($_REQUEST['vg_nombre'], $_REQUEST['vg_apellido'], $_REQUEST['vg_correo_electronico'],
				$_REQUEST['vg_telefono'], noeliaDecode($_REQUEST['vg_perfil']), $_REQUEST['vg_nombre_usuario'],
				$_REQUEST['vg_contrasenia_1'], $_REQUEST['vg_estado'], noeliaDecode($_REQUEST['vg_usuario']));

			//editUserInstitutionInformation($result[0]["nombre_usuario"], $_REQUEST['vg_tipo_institucion'], $_REQUEST['vg_sede_institucion'], $_REQUEST['vg_unidad']);

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
					El usuario que intenta agregar ya existe.
				</div>
			<?php
			}

		}
	}
?>
