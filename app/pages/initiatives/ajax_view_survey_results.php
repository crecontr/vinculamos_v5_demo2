
<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../../utils/user_utils.php");

	$id_initiative = noeliaDecode($_POST['id_initiative']);
	$id_survey = noeliaDecode($_POST['id_survey']);

	include_once("../../controller/medoo_survey.php");
	$encuesta = getSurvey($id_survey);

	include_once("../../controller/medoo_initiatives.php");
	$iniciativa = getInitiative($id_initiative);

	include_once("../../controller/medoo_survey_question.php");
	$preguntas = getVisibleQuestionsBySurvey($id_survey);

	include_once("../../controller/medoo_survey_answer.php");

	//echo "<br>id_initiative: " . $id_initiative;
?>

  <div class="box-body table-responsive">

		<?php
		 	for ($i=0; $i < sizeof($preguntas); $i++) { ?>

				<?php
					$respuestas = getVisibleAnswersBySurveyQuestion($id_survey, $preguntas[$i]["id"]);
					$tipoRespuestas = $preguntas[$i]["tipo_respuesta"];

					if($tipoRespuestas == "Si o No") {
						$respuestasSi = countByAnswer("Si", $respuestas);
						$respuestasNo = countByAnswer("No", $respuestas);
						$totalSiNo = $respuestasSi + $respuestasNo; ?>

						<table id="tableAttendance" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Pregunta</th>
									<th colspan="3" style="width:30%" class="text-center">Alternativas</th>
									<th style="width:25%" class="text-center">Resultado obtenido</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th rowspan="3"><?php echo$preguntas[$i]["titulo"];?></th>
									<td class="text-center">Si</td>
									<td class="text-center"><?php echo $respuestasSi;?></td>
									<td class="text-center"><?php echo round($respuestasSi / $totalSiNo) * 100;?>%</td>
									<td rowspan="3" class="text-center">
										<?php
											$miPorcentaje = round($respuestasSi / $totalSiNo) * 100;
										?>
										<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#3c8dbc' data-width='80' data-height='80'>
										<div class="knob-label">% Resultado</div>
									</td>
								</tr>
								<tr>
									<td class="text-center">No</td>
									<td class="text-center"><?php echo $respuestasNo;?></td>
									<td class="text-center"><?php echo round($respuestasNo / $totalSiNo, 2) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center"><strong>Total</strong></td>
									<td class="text-center"><strong><?php echo $totalSiNo;?></strong></td>
									<td class="text-center"><strong><?php echo round($totalSiNo / $totalSiNo, 2) * 100;?>%</strong></td>
								</tr>
							<tbody>
						</table>
				<?php
					}

					if($tipoRespuestas == "Escala 1 a 7") {
						$respuestas0 = countByAnswer("-", $respuestas);
						$respuestas1 = countByAnswer("1", $respuestas);
						$respuestas2 = countByAnswer("2", $respuestas);
						$respuestas3 = countByAnswer("3", $respuestas);
						$respuestas4 = countByAnswer("4", $respuestas);
						$respuestas5 = countByAnswer("5", $respuestas);
						$respuestas6 = countByAnswer("6", $respuestas);
						$respuestas7 = countByAnswer("7", $respuestas);
						$total1a7 = $respuestas0 + $respuestas1 + $respuestas2 + $respuestas3 + $respuestas4
							+ $respuestas5 + $respuestas6 + $respuestas7; ?>

						<table id="tableAttendance" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Pregunta</th>
									<th colspan="3" style="width:30%" class="text-center">Alternativas</th>
									<th style="width:25%" class="text-center">Resultado obtenido</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th rowspan="9"><?php echo$preguntas[$i]["titulo"];?></th>
									<td class="text-center">No Aplica</td>
									<td class="text-center"><?php echo $respuestas0;?></td>
									<td class="text-center"><?php echo round($respuestas0 / $total1a7) * 100;?>%</td>
									<td rowspan="9" class="text-center">
										<?php
											$miPorcentaje = (1*$respuestas1 + 2*$respuestas2 + 3*$respuestas3 + 4*$respuestas4
												+ 5*$respuestas5 + 6*$respuestas6 + 7*$respuestas7) / ($total1a7 - $respuestas0);
											$miPorcentaje = round($miPorcentaje/7 * 100);
										?>
										<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#3c8dbc' data-width='80' data-height='80'>
										<div class="knob-label">% Resultado</div>
									</td>
								</tr>
								<tr>
									<td class="text-center">1</td>
									<td class="text-center"><?php echo $respuestas1;?></td>
									<td class="text-center"><?php echo round($respuestas1 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">2</td>
									<td class="text-center"><?php echo $respuestas2;?></td>
									<td class="text-center"><?php echo round($respuestas2 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">3</td>
									<td class="text-center"><?php echo $respuestas3;?></td>
									<td class="text-center"><?php echo round($respuestas3 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">4</td>
									<td class="text-center"><?php echo $respuestas4;?></td>
									<td class="text-center"><?php echo round($respuestas4 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">5</td>
									<td class="text-center"><?php echo $respuestas5;?></td>
									<td class="text-center"><?php echo round($respuestas5 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">6</td>
									<td class="text-center"><?php echo $respuestas6;?></td>
									<td class="text-center"><?php echo round($respuestas6 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">7</td>
									<td class="text-center"><?php echo $respuestas7;?></td>
									<td class="text-center"><?php echo round($respuestas7 / $total1a7) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center"><strong>Total</strong></td>
									<td class="text-center"><strong><?php echo $total1a7;?></strong></td>
									<td class="text-center"><?php echo round($total1a7 / $total1a7) * 100;?>%</td>
								</tr>
							</tbody>
						</table>

				<?php
					}

					if($tipoRespuestas == "Caritas 1 a 5") {
						$respuestas0 = countByAnswer("-", $respuestas);
						$respuestas1 = countByAnswer("1", $respuestas);
						$respuestas2 = countByAnswer("2", $respuestas);
						$respuestas3 = countByAnswer("3", $respuestas);
						$respuestas4 = countByAnswer("4", $respuestas);
						$respuestas5 = countByAnswer("5", $respuestas);
						$total1a5 = $respuestas0 + $respuestas1 + $respuestas2 + $respuestas3 + $respuestas4 + $respuestas5; ?>

						<table id="tableAttendance" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Pregunta</th>
									<th colspan="3" style="width:30%" class="text-center">Alternativas</th>
									<th style="width:25%" class="text-center">Resultado obtenido</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th rowspan="8"><?php echo$preguntas[$i]["titulo"];?></th>
									<td class="text-center">No Aplica</td>
									<td class="text-center"><?php echo $respuestas0;?></td>
									<td class="text-center"><?php echo round($respuestas0 / $total1a5) * 100;?>%</td>
									<td rowspan="8" class="text-center">
										<?php
											$miPorcentaje = (1*$respuestas1 + 2*$respuestas2 + 3*$respuestas3 + 4*$respuestas4
												+ 5*$respuestas5) / ($total1a5 - $respuestas0);
											$miPorcentaje = round($miPorcentaje/5 * 100);
										?>
										<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$miPorcentaje?>' data-fgColor='#3c8dbc' data-width='80' data-height='80'>
										<div class="knob-label">% Resultado</div>
									</td>
								</tr>
								<tr>
									<td class="text-center">1</td>
									<td class="text-center"><?php echo $respuestas1;?></td>
									<td class="text-center"><?php echo round($respuestas1 / $total1a5) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">2</td>
									<td class="text-center"><?php echo $respuestas2;?></td>
									<td class="text-center"><?php echo round($respuestas2 / $total1a5) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">3</td>
									<td class="text-center"><?php echo $respuestas3;?></td>
									<td class="text-center"><?php echo round($respuestas3 / $total1a5) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">4</td>
									<td class="text-center"><?php echo $respuestas4;?></td>
									<td class="text-center"><?php echo round($respuestas4 / $total1a5) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center">5</td>
									<td class="text-center"><?php echo $respuestas5;?></td>
									<td class="text-center"><?php echo round($respuestas5 / $total1a5) * 100;?>%</td>
								</tr>
								<tr>
									<td class="text-center"><strong>Total</strong></td>
									<td class="text-center"><strong><?php echo $total1a5;?></strong></td>
									<td class="text-center"><?php echo round($total1a5 / $total1a5) * 100;?>%</td>
								</tr>
							</tbody>
						</table>

						<?php
							}

							if($tipoRespuestas == "Area de Texto") { ?>
								<table id="tableAttendance" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Pregunta</th>
											<th class="text-center">Resultado obtenido</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php
												$encuestasLargas = getVisibleAnswersBySurveyQuestion($id_survey, $preguntas[$i]["id"]);
											?>
											<th><?php echo$preguntas[$i]["titulo"];?></th>
											<td class="text-center" >
												<?php
												 	for ($x=0; $x < sizeof($encuestasLargas); $x++) {
											 			echo $encuestasLargas[$x]["respuesta"] . "<br>";
												 	}
												?>
											</td>
										</tr>
									</tbody>
								</table>
						<?php
							} ?>
					</tbody>
				</table>
				<br>
		<?php
			}?>

  </div>
  <!-- /.box-body -->


	<?php
	function countByAnswer($answer = null, $datas = null) {
		$respuestas = 0;
		for($i=0 ; $i<sizeof($datas) ; $i++) {
			if($datas[$i]["respuesta"] == $answer) {
				$respuestas++;
			}
		}
		return $respuestas;
	}
	 ?>
