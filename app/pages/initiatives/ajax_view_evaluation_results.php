
<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../../utils/user_utils.php");

	$id_initiative = noeliaDecode($_POST['id_initiative']);
	$id_evaluation = noeliaDecode($_POST['id_evaluation']);

	include_once("../../controller/medoo_evaluation.php");
	$evaluacion = getEvaluationById($id_evaluation);

	include_once("../../controller/medoo_initiatives.php");
	$iniciativa = getInitiative($id_initiative);

	include_once("../../controller/medoo_evaluation_knowledge_ori_questions.php");
	$preguntasKnowledge = getKnowledgeOriQuestionByType($evaluacion[0]["tipo_evaluacion"]);

	include_once("../../controller/medoo_evaluation_compliance_ori_questions.php");
	$preguntasCompliance = getComplianceOriQuestionByType($evaluacion[0]["tipo_evaluacion"]);

	include_once("../../controller/medoo_evaluation_answer.php");

	//echo "Testing";
	//echo "<br> id_evaluation: " . $id_evaluation;

?>

  <div class="box-body table-responsive">
		<h4>CONOCIMIENTO DE LA INICIATIVA</h4>

		<table id="tableAttendance" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Pregunta</th>
					<th colspan="3" style="width:30%" class="text-center">Alternativas</th>
					<th style="width:25%" class="text-center">Resultado obtenido</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "CONOCIMIENTO_O%");
					$respuestasKnowledgeSi = countByAnswer(100, $respuestas);
					$respuestasKnowledgeNo = countByAnswer(0, $respuestas);
					$respuestasKnowledgeSiNo = $respuestasKnowledgeSi + $respuestasKnowledgeNo;

					$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "CUMPLIMIENTO_O%");
					$respuestasCompliance0 = countByAnswer(0, $respuestas);
					$respuestasCompliance25 = countByAnswer(25, $respuestas);
					$respuestasCompliance50 = countByAnswer(50, $respuestas);
					$respuestasCompliance75 = countByAnswer(75, $respuestas);
					$respuestasCompliance100 = countByAnswer(100, $respuestas);
					$respuestasComplianceSiNo = $respuestasCompliance0 + $respuestasCompliance25 +
						$respuestasCompliance50 + $respuestasCompliance75 + $respuestasCompliance100;
					$index = 0;
				?>
				<tr>
					<th rowspan="3"><?php echo$preguntasKnowledge[$index]["texto"];?></th>
					<td class="text-center">Si</td>
					<td class="text-center"><?php echo $respuestasKnowledgeSi;?></td>
					<td class="text-center"><?php echo round($respuestasKnowledgeSi / $respuestasKnowledgeSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPorcentaje = round(($respuestasKnowledgeSi / $respuestasKnowledgeSiNo) * 100);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#3c8dbc' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center"><?php echo $respuestasKnowledgeNo;?></td>
					<td class="text-center"><?php echo round($respuestasKnowledgeNo / $respuestasKnowledgeSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $respuestasKnowledgeSiNo;?></strong></td>
					<td class="text-center"><strong><?php echo round($respuestasKnowledgeSiNo / $respuestasKnowledgeSiNo, 2) * 100;?>%</strong></td>
				</tr>

				<!-- CUMPLIMIENTO -->
				<tr>
					<th rowspan="6"><?php echo$preguntasCompliance[$index]["texto"];?></th>
					<td class="text-center">0%</td>
					<td class="text-center"><?php echo $respuestasCompliance0;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance0 / $respuestasComplianceSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPuntaje = (0 * $respuestasCompliance0) + (25 * $respuestasCompliance25) +
								(50 * $respuestasCompliance50) + (75 * $respuestasCompliance75) + (100 * $respuestasCompliance100);
							$maxPuntaje = $respuestasComplianceSiNo*100;
							$miPorcentaje = round(($miPuntaje / $maxPuntaje) * 100, 1);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#F1943D' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">25%</td>
					<td class="text-center"><?php echo $respuestasCompliance25;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance25 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">50%</td>
					<td class="text-center"><?php echo $respuestasCompliance50;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance50 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">75%</td>
					<td class="text-center"><?php echo $respuestasCompliance75;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance75 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">100%</td>
					<td class="text-center"><?php echo $respuestasCompliance100;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance100 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $respuestasComplianceSiNo;?></strong></td>
					<td class="text-center"><strong><?php echo round($respuestasComplianceSiNo / $respuestasComplianceSiNo, 2) * 100;?>%</strong></td>
				</tr>
			<tbody>
		</table>

		<table id="tableAttendance" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Pregunta</th>
					<th colspan="3" style="width:30%" class="text-center">Alternativas</th>
					<th style="width:25%" class="text-center">Resultado obtenido</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "CONOCIMIENTO_R%");
					$respuestasKnowledgeSi = countByAnswer(100, $respuestas);
					$respuestasKnowledgeNo = countByAnswer(0, $respuestas);
					$respuestasKnowledgeSiNo = $respuestasKnowledgeSi + $respuestasKnowledgeNo;

					$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "CUMPLIMIENTO_R%");
					$respuestasCompliance0 = countByAnswer(0, $respuestas);
					$respuestasCompliance25 = countByAnswer(25, $respuestas);
					$respuestasCompliance50 = countByAnswer(50, $respuestas);
					$respuestasCompliance75 = countByAnswer(75, $respuestas);
					$respuestasCompliance100 = countByAnswer(100, $respuestas);
					$respuestasComplianceSiNo = $respuestasCompliance0 + $respuestasCompliance25 +
						$respuestasCompliance50 + $respuestasCompliance75 + $respuestasCompliance100;
					$index = 1;
				?>
				<tr>
					<th rowspan="3"><?php echo$preguntasKnowledge[$index]["texto"];?></th>
					<td class="text-center">Si</td>
					<td class="text-center"><?php echo $respuestasKnowledgeSi;?></td>
					<td class="text-center"><?php echo round($respuestasKnowledgeSi / $respuestasKnowledgeSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPorcentaje = round(($respuestasKnowledgeSi / $respuestasKnowledgeSiNo) * 100);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#3c8dbc' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center"><?php echo $respuestasKnowledgeNo;?></td>
					<td class="text-center"><?php echo round($respuestasKnowledgeNo / $respuestasKnowledgeSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $respuestasKnowledgeSiNo;?></strong></td>
					<td class="text-center"><strong><?php echo round($respuestasKnowledgeSiNo / $respuestasKnowledgeSiNo, 2) * 100;?>%</strong></td>
				</tr>

				<!-- CUMPLIMIENTO -->
				<!-- CUMPLIMIENTO -->
				<tr>
					<th rowspan="6"><?php echo$preguntasCompliance[$index]["texto"];?></th>
					<td class="text-center">0%</td>
					<td class="text-center"><?php echo $respuestasCompliance0;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance0 / $respuestasComplianceSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPuntaje = (0 * $respuestasCompliance0) + (25 * $respuestasCompliance25) +
								(50 * $respuestasCompliance50) + (75 * $respuestasCompliance75) + (100 * $respuestasCompliance100);
							$maxPuntaje = $respuestasComplianceSiNo*100;
							$miPorcentaje = round(($miPuntaje / $maxPuntaje) * 100, 1);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#F1943D' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">25%</td>
					<td class="text-center"><?php echo $respuestasCompliance25;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance25 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">50%</td>
					<td class="text-center"><?php echo $respuestasCompliance50;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance50 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">75%</td>
					<td class="text-center"><?php echo $respuestasCompliance75;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance75 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">100%</td>
					<td class="text-center"><?php echo $respuestasCompliance100;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance100 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $respuestasComplianceSiNo;?></strong></td>
					<td class="text-center"><strong><?php echo round($respuestasComplianceSiNo / $respuestasComplianceSiNo, 2) * 100;?>%</strong></td>
				</tr>
			<tbody>
		</table>

		<table id="tableAttendance" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Pregunta</th>
					<th colspan="3" style="width:30%" class="text-center">Alternativas</th>
					<th style="width:25%" class="text-center">Resultado obtenido</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "CONOCIMIENTO_I%");
					$respuestasKnowledgeSi = countByAnswer(100, $respuestas);
					$respuestasKnowledgeNo = countByAnswer(0, $respuestas);
					$respuestasKnowledgeSiNo = $respuestasKnowledgeSi + $respuestasKnowledgeNo;

					$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "CUMPLIMIENTO_I%");
					$respuestasCompliance0 = countByAnswer(0, $respuestas);
					$respuestasCompliance25 = countByAnswer(25, $respuestas);
					$respuestasCompliance50 = countByAnswer(50, $respuestas);
					$respuestasCompliance75 = countByAnswer(75, $respuestas);
					$respuestasCompliance100 = countByAnswer(100, $respuestas);
					$respuestasComplianceSiNo = $respuestasCompliance0 + $respuestasCompliance25 +
						$respuestasCompliance50 + $respuestasCompliance75 + $respuestasCompliance100;
					$index = 2;
				?>
				<tr>
					<th rowspan="3"><?php echo$preguntasKnowledge[$index]["texto"];?></th>
					<td class="text-center">Si</td>
					<td class="text-center"><?php echo $respuestasKnowledgeSi;?></td>
					<td class="text-center"><?php echo round($respuestasKnowledgeSi / $respuestasKnowledgeSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPorcentaje = round(($respuestasKnowledgeSi / $respuestasKnowledgeSiNo) * 100);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#3c8dbc' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center"><?php echo $respuestasKnowledgeNo;?></td>
					<td class="text-center"><?php echo round($respuestasKnowledgeNo / $respuestasKnowledgeSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $respuestasKnowledgeSiNo;?></strong></td>
					<td class="text-center"><strong><?php echo round($respuestasKnowledgeSiNo / $respuestasKnowledgeSiNo, 2) * 100;?>%</strong></td>
				</tr>

				<!-- CUMPLIMIENTO -->
				<tr>
					<th rowspan="6"><?php echo$preguntasCompliance[$index]["texto"];?></th>
					<td class="text-center">0%</td>
					<td class="text-center"><?php echo $respuestasCompliance0;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance0 / $respuestasComplianceSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPuntaje = (0 * $respuestasCompliance0) + (25 * $respuestasCompliance25) +
								(50 * $respuestasCompliance50) + (75 * $respuestasCompliance75) + (100 * $respuestasCompliance100);
							$maxPuntaje = $respuestasComplianceSiNo*100;
							$miPorcentaje = round(($miPuntaje / $maxPuntaje) * 100, 1);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#F1943D' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">25%</td>
					<td class="text-center"><?php echo $respuestasCompliance25;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance25 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">50%</td>
					<td class="text-center"><?php echo $respuestasCompliance50;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance50 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">75%</td>
					<td class="text-center"><?php echo $respuestasCompliance75;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance75 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center">100%</td>
					<td class="text-center"><?php echo $respuestasCompliance100;?></td>
					<td class="text-center"><?php echo round($respuestasCompliance100 / $respuestasComplianceSiNo, 2) * 100;?>%</td>
				</tr>
				<tr>
					<td class="text-center"><strong>Total</strong></td>
					<td class="text-center"><strong><?php echo $respuestasComplianceSiNo;?></strong></td>
					<td class="text-center"><strong><?php echo round($respuestasComplianceSiNo / $respuestasComplianceSiNo, 2) * 100;?>%</strong></td>
				</tr>
			<tbody>
		</table>

  </div>
  <!-- /.box-body -->

	<?php
		include_once("../../controller/medoo_evaluation_promises.php");
		$promises = getEvaluationPromises();
	?>
	<div class="box-body table-responsive">
		<h4>CALIDAD DE LA EJECUCIÓN</h4>

		<table id="tableAttendance" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Pregunta</th>
					<th style="width:30%">Número de respuestas</th>
					<th style="width:25%" class="text-center">Resultado obtenido</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sumaRespuestas = 0;
					$totalRespuestas = 0;
				 	for ($i=0; $i < sizeof($promises); $i++) {
						$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "COMPROMISO_" . $promises[$i]['id']);
						$suma = sumByAnswer($respuestas);

						$sumaRespuestas += $suma;
						$totalRespuestas += sizeof($respuestas);

						$desempenio = $suma / (sizeof($respuestas) * 3);
						?>
						<tr>
							<td><?php echo $promises[$i]["nombre"]; ?></td>
							<td class="text-center"><?php echo sizeof($respuestas);?></td>
							<td class="text-center"><?php echo round($desempenio, 2) * 100;?>%</td>
						</tr>
				<?php
				 	} ?>
			<tbody>
		</table>
	</div>
  <!-- /.box-body -->

	<?php
		//include_once("../../controller/medoo_evaluation_competence_questions.php");
		//$competenceQuestions = getCompetenceQuestionByType($evaluacion[0]["tipo_evaluacion"]);

		$competeneces = array();
		$competeneces[] = "Capacidad para ejecutar las actividades.";
		$competeneces[] = "Actitud positiva para ejecutar actividades.";
		$competeneces[] = "Habilidad para resolver problemas";
	?>
	<div class="box-body table-responsive">
		<h4>COMPETENCIA DE ESTUDIANTES</h4>

		<table id="tableAttendance" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Pregunta</th>
					<th style="width:30%">Número de respuestas</th>
					<th style="width:25%" class="text-center">Resultado obtenido</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sumaRespuestas = 0;
					$totalRespuestas = 0;
				 	for ($i=0; $i < sizeof($competeneces); $i++) {
						$respuestas = getVisibleEvaluationAnswerByInitiativeKey($id_initiative, $id_evaluation, "COMPETENCIA_" . ($i+1));
						$suma = sumByAnswer($respuestas);

						$sumaRespuestas += $suma;
						$totalRespuestas += sizeof($respuestas);

						$desempenio = $suma / (sizeof($respuestas) * 3);
						?>
						<tr>
							<td><?php echo $competeneces[$i]; ?></td>
							<td class="text-center"><?php echo sizeof($respuestas);?></td>
							<td class="text-center"><?php echo round($desempenio, 2) * 100;?>%</td>
						</tr>
				<?php
				 	} ?>
			<tbody>
		</table>
	</div>
  <!-- /.box-body -->


	<?php
	function countByAnswer($answer = null, $datas = null) {
		$respuestas = 0;
		for($i=0 ; $i<sizeof($datas) ; $i++) {
			if($datas[$i]["valor"] == $answer) {
				$respuestas++;
			}
		}
		return $respuestas;
	}

	function sumByAnswer($datas = null) {
		$suma = 0;
		for($i=0 ; $i<sizeof($datas) ; $i++) {
			$suma += $datas[$i]["valor"];
		}
		return $suma;
	}
	 ?>
