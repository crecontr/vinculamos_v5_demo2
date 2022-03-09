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
		echo "<br>vg_encuesta: " . ($_REQUEST['vg_encuesta']);
		echo "<br>vg_encuesta deco: " . noeliaDecode($_REQUEST['vg_encuesta']);
		echo "<br>vg_usuario: " . noeliaDecode($_REQUEST['vg_usuario']);
		echo "<br>vg_titulo: " . $_REQUEST['vg_titulo'];
		echo "<br>vg_tipo_respuesta: " . $_REQUEST['vg_tipo_respuesta'];
		return;
	}

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_encuesta']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_survey_question.php");
		$result = addQuestion(noeliaDecode($_REQUEST['vg_encuesta']), $_REQUEST['vg_titulo'],
			$_REQUEST['vg_tipo_respuesta'], noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Pregunta creada correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				La pregunta que intenta agregar ya existe.
			</div>
		<?php
		}

	} else {
		echo "<br> Falta info para crear encuesta";
	}
?>
