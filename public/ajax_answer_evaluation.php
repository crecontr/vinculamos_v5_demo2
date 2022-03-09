<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../app/utils/user_utils.php");
	$institution = getInstitution();

	$id = noeliaDecode($_POST["vg_data"]);

	include_once("../app/controller/medoo_evaluation.php");
	$evaluation = getEvaluationById($id);

	include_once("../app/controller/medoo_initiatives.php");
	$initiative = getInitiative($evaluation[0]["id_iniciativa"]);

	include_once("../app/controller/medoo_evaluation_types_config.php");
	$evaluatorTypeConfig = getEvaluationTypesConfigByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_evaluation_knowledge_ori_questions.php");
	$OriKnowledgeQuestions = getKnowledgeOriQuestionByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_evaluation_compliance_ori_questions.php");
	$OriComplianceQuestions = getComplianceOriQuestionByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_impact_internal.php");
	$myInternalImpacts = getInternalImpactByInitiative($initiative[0]["id"]);

	include_once("../app/controller/medoo_impact_external.php");
	$myExternalImpacts = getExternalImpactByInitiative($initiative[0]["id"]);

	include_once("../app/controller/medoo_evaluation_competence_questions.php");
	$competenceQuestions = getCompetenceQuestionByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_evaluation_promises.php");
	$promises = getEvaluationPromises();

	include_once("../app/controller/medoo_survey_answer.php");

	if(true) {
		$answersArray = array();
		for ($i=0; $i < sizeof($evaluatorTypeConfig); $i++) {
			//echo "<br> Revisando " . $evaluatorTypeConfig[$i]["clave"];
			switch ($evaluatorTypeConfig[$i]["clave"]) {
				case 'CONOCIMIENTO_ORI':
					$arrayConocimiento = array("key" => "CONOCIMIENTO_O", "value" => $_POST["CONOCIMIENTO_O"]);
					$answersArray[] = $arrayConocimiento;

					$arrayCumplimiento = array("key" => "CUMPLIMIENTO_O", "value" => $_POST["CUMPLIMIENTO_O"]);
					$answersArray[] = $arrayCumplimiento;

					$arrayConocimiento = array("key" => "CONOCIMIENTO_R", "value" => $_POST["CONOCIMIENTO_R"]);
					$answersArray[] = $arrayConocimiento;

					$arrayCumplimiento = array("key" => "CUMPLIMIENTO_R", "value" => $_POST["CUMPLIMIENTO_R"]);
					$answersArray[] = $arrayCumplimiento;

					$arrayConocimiento = array("key" => "CONOCIMIENTO_I", "value" => $_POST["CONOCIMIENTO_I"]);
					$answersArray[] = $arrayConocimiento;

					$arrayCumplimiento = array("key" => "CUMPLIMIENTO_I", "value" => $_POST["CUMPLIMIENTO_I"]);
					$answersArray[] = $arrayCumplimiento;

					/*
					for ($j=0; $j < sizeof($myInternalImpacts); $j++) {
						$key = "CONOCIMIENTO_II_" . $myInternalImpacts[$j]['id'];
						$arrayImpactoInterno = array("key" => $key, "value" => $_POST[$key]);
						$answersArray[] = $arrayImpactoInterno;

						$key = "CUMPLIMIENTO_II_" . $myInternalImpacts[$j]['id'];
						$arrayImpactoInterno = array("key" => $key, "value" => $_POST[$key]);
						$answersArray[] = $arrayImpactoInterno;
					}

					for ($j=0; $j < sizeof($myExternalImpacts); $j++) {
						$key = "CONOCIMIENTO_IE_" . $myExternalImpacts[$j]['id'];
						$arrayImpactoInterno = array("key" => $key, "value" => $_POST[$key]);
						$answersArray[] = $arrayImpactoInterno;

						$key = "CUMPLIMIENTO_IE_" . $myExternalImpacts[$j]['id'];
						$arrayImpactoInterno = array("key" => $key, "value" => $_POST[$key]);
						$answersArray[] = $arrayImpactoInterno;
					}
					*/
					break;

				case 'CALIDAD_EJECUCION':
					for ($j=0; $j < sizeof($promises); $j++) {
						$key = "COMPROMISO_" . $promises[$j]['id'];
						$arrayConocimiento = array("key" => $key, "value" => $_POST[$key]);
						$answersArray[] = $arrayConocimiento;
					}
					break;

				case 'APORTE_COMPETENCIAS':
					$competeneces = array();
					$competeneces[] = "Capacidad para ejecutar las actividades.";
					$competeneces[] = "Actitud positiva para ejecutar actividades.";
					$competeneces[] = "Habilidad para resolver problemas";
					for ($j=0; $j < sizeof($competeneces); $j++) {
						$key = "COMPETENCIA_" . ($j+1);
						$arrayCompetencias = array("key" => $key, "value" => $_POST[$key]);
						$answersArray[] = $arrayCompetencias;
					}
					break;
			}
		}

		/*
		echo "<br> Datos:";
		echo "<br> id_iniciativa: " . $initiative[0]["id"];
		echo "<br> id_evaluacion: " . $evaluation[0]["id"];
		echo "<br> correo_evaluador: " . $_REQUEST['vg_correo'];
		echo "<br>";

		echo "<br> Respuestas:";
		for ($i=0; $i < sizeof($answersArray); $i++) {
			echo "<br>" . $answersArray[$i]["key"] . ": " . $answersArray[$i]["value"];
		}
		*/
		//return;
	}

	if( isset($_REQUEST['vg_correo']) ) {

		include_once("../app/controller/medoo_evaluation_answer.php");
		$respuestaActual = getVisibleEvaluationAnswerByInitiativeIdEvaluationEmail(
			$initiative[0]["id"], $evaluation[0]["id"], $_REQUEST['vg_correo']);

		include_once("../app/controller/medoo_evaluation_evaluators.php");
		$evaluador = getVisibleEvaluatorsByInitiativeIdEvaluationEmail(
			$initiative[0]["id"], $evaluation[0]["id"], $_REQUEST['vg_correo']);

		if(sizeof($evaluador) == 0) { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No se pudo recuperar su información.
			</div>
		<?php
			return;
		} else {

			if($respuestaActual != null) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Usted ya respondió esta encuesta. Muchas gracias.
				</div>
			<?php
			} else {

				for ($i=0; $i < sizeof($answersArray); $i++) {
					$result = addEvaluationAnswer($initiative[0]["id"], $evaluation[0]["id"],
						$_REQUEST['vg_correo'], $answersArray[$i]["key"], $answersArray[$i]["value"], $_REQUEST['vg_correo']);
				}

				if($result != null) { ?>
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
