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

	if( isset($_REQUEST['vg_usuario']) && isset($_REQUEST['vg_id']) &&
		isset($_REQUEST['vg_contrasenia_1']) && isset($_REQUEST['vg_contrasenia_2']) ) {

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
			$result = changePassword(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_contrasenia_1'], noeliaDecode($_REQUEST['vg_usuario']));

			if($result != null) { ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Contraseña cambiada correctamente.
				</div>
			<?php
			} else { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					No pudimos cambiar la contraseña.
				</div>
			<?php
			}

		}
	}
?>
