
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
					$respuestasComplianceSi = countByAnswer(100, $respuestas);
					$respuestasComplianceNo = countByAnswer(0, $respuestas);
					$respuestasComplianceSiNo = $respuestasComplianceSi + $respuestasComplianceNo;
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
					<th rowspan="3"><?php echo$preguntasCompliance[$index]["texto"];?></th>
					<td class="text-center">Si</td>
					<td class="text-center"><?php echo $respuestasComplianceSi;?></td>
					<td class="text-center"><?php echo round($respuestasComplianceSi / $respuestasComplianceSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPorcentaje = round(($respuestasComplianceSi / $respuestasComplianceSiNo) * 100);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#F1943D' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center"><?php echo $respuestasComplianceNo;?></td>
					<td class="text-center"><?php echo round($respuestasComplianceNo / $respuestasComplianceSiNo, 2) * 100;?>%</td>
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
					$respuestasComplianceSi = countByAnswer(100, $respuestas);
					$respuestasComplianceNo = countByAnswer(0, $respuestas);
					$respuestasComplianceSiNo = $respuestasComplianceSi + $respuestasComplianceNo;
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
				<tr>
					<th rowspan="3"><?php echo$preguntasCompliance[$index]["texto"];?></th>
					<td class="text-center">Si</td>
					<td class="text-center"><?php echo $respuestasComplianceSi;?></td>
					<td class="text-center"><?php echo round($respuestasComplianceSi / $respuestasComplianceSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPorcentaje = round(($respuestasComplianceSi / $respuestasComplianceSiNo) * 100);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#F1943D' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center"><?php echo $respuestasComplianceNo;?></td>
					<td class="text-center"><?php echo round($respuestasComplianceNo / $respuestasComplianceSiNo, 2) * 100;?>%</td>
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
					$respuestasComplianceSi = countByAnswer(100, $respuestas);
					$respuestasComplianceNo = countByAnswer(0, $respuestas);
					$respuestasComplianceSiNo = $respuestasComplianceSi + $respuestasComplianceNo;
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
					<th rowspan="3"><?php echo$preguntasCompliance[$index]["texto"];?></th>
					<td class="text-center">Si</td>
					<td class="text-center"><?php echo $respuestasComplianceSi;?></td>
					<td class="text-center"><?php echo round($respuestasComplianceSi / $respuestasComplianceSiNo) * 100;?>%</td>
					<td rowspan="3" class="text-center">
						<?php
							$miPorcentaje = round(($respuestasComplianceSi / $respuestasComplianceSiNo) * 100);
						?>
						<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#F1943D' data-width='80' data-height='80'>
						<div class="knob-label">% Resultado</div>
					</td>
				</tr>
				<tr>
					<td class="text-center">No</td>
					<td class="text-center"><?php echo $respuestasComplianceNo;?></td>
					<td class="text-center"><?php echo round($respuestasComplianceNo / $respuestasComplianceSiNo, 2) * 100;?>%</td>
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
