<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../app/utils/user_utils.php");
	$institution = getInstitution();

	$id = noeliaDecode($_POST["vg_data"]);

	include_once("../app/controller/medoo_survey.php");
	$encuesta = getSurvey($id);

	include_once("../app/controller/medoo_initiatives.php");
	$iniciativa = getInitiative($encuesta[0]["id_iniciativa"]);

	include_once("../app/controller/medoo_survey_question.php");
	$preguntas = getVisibleQuestionsBySurvey($encuesta[0]["id"]);
	for ($i=0; $i < sizeof($preguntas); $i++) {
		$idPregunta = ("vg_pregunta_" . $preguntas[$i]["id"]);
		$preguntas[$i]["respuesta"] = $_POST[$idPregunta];
	}

	include_once("../app/controller/medoo_survey_answer.php");

	if(false) {
		for ($i=0; $i < sizeof($preguntas); $i++) {
			$idPregunta = ("vg_pregunta_" . $preguntas[$i]["id"]);
			$preguntas[$i]["respuesta"] = $_POST[$idPregunta];
			echo "<br> " . $preguntas[$i]["titulo"] . ": " . $preguntas[$i]["respuesta"];
		}
		return;
	}

	if( isset($_REQUEST['vg_correo']) ) {

		include_once("../app/controller/medoo_attendance_list.php");
		$participante = getVisibleAttendanceByInitiativeAttendanceType($iniciativa[0]["id"], $_REQUEST['vg_correo'], $encuesta[0]["tipo"]);

		if(sizeof($participante) == 0) { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No se pudo recuperar su información.
			</div>
		<?php
			return;
		} else {
			$respuestaEncuestaActual = getVisibleAnswersBySurveyParticipation(
				$encuesta[0]["id"], $participante[0]["id"]);

			if($respuestaEncuestaActual != null) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Usted ya respondió esta encuesta. Muchas gracias.
				</div>
			<?php
			} else {
				$contadorRespuestasGuardadas = 0;
				for ($i=0; $i < sizeof($preguntas); $i++) {
					$resultAnswer = addAnswer($encuesta[0]["id"], $preguntas[$i]["id"], $participante[0]["id"], $preguntas[$i]["respuesta"]);
					if($resultAnswer != null) {
						$contadorRespuestasGuardadas++;
					}
				}

				if($contadorRespuestasGuardadas == sizeof($preguntas)) { ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						Respuesta enviada correctamente. Muchas gracias.
					</div>
				<?php
				} else { ?>
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						No pudimos enviar su respuesta.
					</div>
				<?php
				}
			}
	}
} else {
		echo "<br> Falta info";
	}
?>
