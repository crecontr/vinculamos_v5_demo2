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

	if(false) {
		echo "<br>vg_initiative: " . noeliaDecode($_REQUEST['vg_initiative']);
		echo "<br>vg_id: " . ($_REQUEST['vg_id']);
		echo "<br>vg_id deco: " . noeliaDecode($_REQUEST['vg_id']);
		echo "<br>vg_usuario: " . noeliaDecode($_REQUEST['vg_usuario']);
		echo "<br>vg_titulo: " . $_REQUEST['vg_titulo'];
		echo "<br>vg_descripcion: " . $_REQUEST['vg_descripcion'];
		return;
	}

	if( isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_initiative']) &&
		isset($_REQUEST['vg_titulo']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_survey.php");
		$result = editSurvey(noeliaDecode($_REQUEST['vg_id']), noeliaDecode($_REQUEST['vg_initiative']),
			$_REQUEST['vg_titulo'], $_REQUEST['vg_descripcion'], noeliaDecode($_REQUEST['vg_usuario'])) ;

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Encuesta guardada correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				La encuesta que intenta agregar no existe.
			</div>
		<?php
		}

	} else {
		echo "<br> Falta info para modificar encuesta";
	}
?>
