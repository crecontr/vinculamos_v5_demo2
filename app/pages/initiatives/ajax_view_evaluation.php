<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");
	if(!canReadInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$id_initiative = base64_decode($_POST['id_initiative']);
	$tipo = base64_decode($_POST['tipo']);

	//echo "<br> id_initiative: " . $id_initiative;
	//echo "<br> tipo: " . $tipo;

	include_once("../../controller/medoo_initiatives.php");
	$initiative = getInitiative($id_initiative);

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationByInitiativeType($id_initiative, utf8_encode($tipo));

	include_once("../../controller/medoo_evaluation_types_config.php");
	$evaluatorTypeConfig = getEvaluationTypesConfigByType(utf8_encode($tipo));

	include_once("../../controller/medoo_evaluation_knowledge_ori_questions.php");
	$OriKnowledgeQuestions = getKnowledgeOriQuestionByType(utf8_encode($tipo));

	include_once("../../controller/medoo_evaluation_compliance_ori_questions.php");
	$OriComplianceQuestions = getComplianceOriQuestionByType(utf8_encode($tipo));

	include_once("../../controller/medoo_impact_internal.php");
	$myInternalImpacts = getInternalImpactByInitiative($id_initiative);

	include_once("../../controller/medoo_impact_external.php");
	$myExternalImpacts = getExternalImpactByInitiative($id_initiative);

	include_once("../../controller/medoo_evaluation_competence_questions.php");
	$competenceQuestions = getCompetenceQuestionByType(utf8_encode($tipo));

	include_once("../../controller/medoo_evaluation_promises.php");
	$promises = getEvaluationPromises();

	include_once("../../controller/medoo_programs.php");
	$program = getProgram($initiative[0]["id_programa"]);
	//include_once("../../controller/medoo_survey.php");
	//$survey = getVisibleSurveyByInitiativeType($id_initiative, utf8_encode($tipo));

	//include_once("../../controller/medoo_survey_question.php");
	//$questions = getVisibleQuestionsBySurvey($survey[0]["id"]);
?>

  <div class="box-body table-responsive">

		<?php
		 	if($evaluation == null || sizeof($evaluation) == 0) { ?>

				<?php
					if(canUpdateInitiatives()) { ?>
						<div class="btn-group pull-left">
							<button id="exportButton" name="exportButton" class="btn btn-orange pull-right"
								data-tipo='<?php echo utf8_encode($tipo);?>'
								data-toggle="modal" data-target="#addEvaluation">
								<span class="fa fa-plus"></span> Agregar Evaluación
							</button>
						</div>
				<?php
					} ?>

		<?php
			} else { ?>

				<div class="row">
					<div class="col-md-12">
						<?php
							$nombreTipoEvaluador = ("<strong>" . $tipo . "</strong>");
							$nombreIniciativa = ("<strong>" . $initiative[0]["nombre"] . "</strong>");
							$nombreFechaDesde = ("<strong>" . $initiative[0]["fecha_inicio"] . "</strong>");
							$nombreFechaHasta = ("<strong>" . $initiative[0]["fecha_finalizacion"] . "</strong>");
							$nombrePrograma = ("<strong>" . $program[0]["nombre"] . "</strong>");

						?>
						<h4>PROPUESTA EVALUACIÓN VINCULAMOS</h4>
						<p>
							Estimado/a,
							<br>
							En el marco de las actividades que el CFT San Agustín desarrolla en su línea de acción "<?php echo$nombrePrograma?>",
							hemos realizado la actividad denominada <?php echo$nombreIniciativa?>, en la cual le agradecemos haber participado.
							<br>
							Con el propósito de continuar mejorando nuestro trabajo, le pedimos que responda la siguiente encuesta, que nos permitirá evaluar esta actividad.
							<br>
							Saluda atentamente a usted.
							<br><br>
							<strong>CFT San Agustín</strong>
						</p>
					</div>

					<?php
					 	for ($i=0; $i < sizeof($evaluatorTypeConfig); $i++) {
							switch ($evaluatorTypeConfig[$i]["clave"]) {
								case 'CONOCIMIENTO_ORI': ?>
									<div class="col-md-12">
										<h5>CONOCIMIENTO DE LA INICIATIVA</h5>
										<table id="tableOriQuestion" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th width="40%"><?php echo $OriKnowledgeQuestions[0]["texto"];?></th>
													<th width="20%">¿Sí o No?</th>
													<th width="40%"><?php echo $OriComplianceQuestions[0]["texto"];?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $initiative[0]["objetivo"];?></td>
													<td>
														<input type="radio" id="vg_pregunta_2" name="vg_CONOCIMIENTO_O" value="100" required> Si &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CONOCIMIENTO_O" value="0" required> No</td>
													<td>
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_0" value="0" required> 0% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_0" value="25" required> 25% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_0" value="50" required> 50% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_0" value="75" required> 75% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_0" value="100" required> 100%
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="col-md-12">
										<table id="tableOriQuestion" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th width="40%"><?php echo $OriKnowledgeQuestions[1]["texto"];?></th>
													<th width="20%">¿Sí o No?</th>
													<th width="40%"><?php echo $OriComplianceQuestions[1]["texto"];?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $initiative[0]["resultado_esperado"];?></td>
													<td>
														<input type="radio" id="vg_pregunta_2" name="vg_CONOCIMIENTO_R" value="100" required> Si &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CONOCIMIENTO_R" value="0" required> No</td>
													<td>
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_R" value="0" required> 0% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_R" value="25" required> 25% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_R" value="50" required> 50% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_R" value="75" required> 75% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_R" value="100" required> 100%
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="col-md-12">
										<table id="tableOriQuestion" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th width="40%"><?php echo $OriKnowledgeQuestions[2]["texto"];?></th>
													<th width="20%">¿Sí o No?</th>
													<th width="40%"><?php echo $OriComplianceQuestions[2]["texto"];?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $initiative[0]["impacto_esperado"];?></td>
													<td>
														<input type="radio" id="vg_pregunta_2" name="vg_CONOCIMIENTO_I" value="100" required> Si &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CONOCIMIENTO_I" value="0" required> No</td>
													<td>
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_I" value="0" required> 0% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_I" value="25" required> 25% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_I" value="50" required> 50% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_I" value="75" required> 75% &nbsp;&nbsp;&nbsp;
														<input type="radio" id="vg_pregunta_2" name="vg_CUMPLIMIENTO_I" value="100" required> 100%
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<!--div class="col-md-12">
										<table id="tableOriQuestion" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th width="40%"><?php echo $OriKnowledgeQuestions[2]["texto"];?></th>
													<th width="20%">¿Sí o No?</th>
													<th width="40%"><?php echo $OriComplianceQuestions[2]["texto"];?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												 	for ($j=0; $j < sizeof($myInternalImpacts); $j++) { ?>
														<tr>
															<td><?php echo $myInternalImpacts[$j]['nombre'];?></td>
															<td>
																<input type="radio" id="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="100" required> Si &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="0" required> No &nbsp;&nbsp;&nbsp;
															</td>
															<td>
																<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="100" required> 100%
															</td>
														</tr>
												<?php
												 	}?>

												<?php
												 	for ($j=0; $j < sizeof($myExternalImpacts); $j++) { ?>
														<tr>
															<td><?php echo $myExternalImpacts[$j]['nombre'];?></td>
															<td>
																<input type="radio" id="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="100" required> Si &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="0" required> No &nbsp;&nbsp;&nbsp;
															</td>
															<td>
																<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="100" required> 100%
															</td>
														</tr>
												<?php
												 	}?>

											</tbody>
										</table>
									</div-->
								<?php
									break;
								case 'CUMPLIMIENTO_ORI':
									// code...
									break;

								case 'CALIDAD_EJECUCION': ?>
									<div class="col-md-12">
										<h5>CALIDAD DE LA EJECUCIÓN</h5>
										<p>
											A continuación le pedimos que evalúe de 0 a 3 la calidad en la ejecución de la actividad,
											según los compromisos asumidos por CFT San Agustín, en que 0= no cumple, 1= cumple mínimamente;
											2= cumple medianamente y 3= cumple totalmente lo comprometido.
											<br>
											Si considera que algunos ítemes no estaban comprometidos, marque No Aplica.
										</p>

										<table id="tableOriQuestion" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th width="45%">Con qué nota evalúa usted la calidad en la ejecución de la actividad, en las siguientes dimensiones:</th>
													<th width="45%">Cumplimiento</th>
												</tr>
											</thead>
											<tbody>
												<?php
												 	for ($j=0; $j < sizeof($promises); $j++) { ?>
														<tr>
															<td><?php echo $promises[$j]['nombre'];?></td>
															<td>
																<input type="radio" id="vg_pregunta_2" name="vg_COMPROMISO_<?php echo$promises[$j]['id'];?>" value="0" required> 0 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPROMISO_<?php echo$promises[$j]['id'];?>" value="1" required> 1 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPROMISO_<?php echo$promises[$j]['id'];?>" value="2" required> 2 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPROMISO_<?php echo$promises[$j]['id'];?>" value="3" required> 3 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPROMISO_<?php echo$promises[$j]['id'];?>" value="-" required> No Aplica
															</td>
														</tr>
												<?php
												 	}?>
											</tbody>
										</table>
									</div>

								<?php
									break;

								case 'APORTE_COMPETENCIAS': ?>
									<div class="col-md-12">
										<h5>COMPETENCIA DE ESTUDIANTES</h5>
										<p>
											Le pedimos a continuación que evalúe de 0 a 3, competencia para la ejecución de él o los estudiantes,
											en que 0= dimensión desarrollada; 1= mínimamente desarrollada; 2= medianamente desarrollada y
											3= completamente desarrollada.
											<br>
											Si considera que alguna de las dimensiones no pudo observarlas, marque No Aplica.
										</p>

										<table id="tableOriQuestion" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th width="45%"><?php echo$competenceQuestions[0]["texto"]?></th>
													<th width="45%">Cumplimiento</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$competeneces = array();
													$competeneces[] = "Capacidad para ejecutar las actividades.";
													$competeneces[] = "Actitud positiva para ejecutar actividades.";
													$competeneces[] = "Habilidad para resolver problemas";
													for ($j=0; $j < sizeof($competeneces); $j++) { ?>
														<tr>
															<td><?php echo $competeneces[$j];?></td>
															<td>
																<input type="radio" id="vg_pregunta_2" name="vg_COMPETENCIA_<?php echo($j+1);?>" value="0" required> 0 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPETENCIA_<?php echo($j+1);?>" value="1" required> 1 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPETENCIA_<?php echo($j+1);?>" value="2" required> 2 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPETENCIA_<?php echo($j+1);?>" value="3" required> 3 &nbsp;&nbsp;&nbsp;
																<input type="radio" id="vg_pregunta_2" name="vg_COMPETENCIA_<?php echo($j+1);?>" value="-" required> No Aplica
															</td>
														</tr>
												<?php
													}?>
											</tbody>
										</table>
									</div>
								<?php
									break;
								default:
									// code...
									break;
							}?>

					<?php
					 	}?>


						<div class="col-md-12">
							<div class="box-body">
								<div id="loader"></div><!-- Carga los datos ajax -->

								<br><div id="resultados_encuesta"></div>

								<div class="modal-footer">
									<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
									<?php
										$data = noeliaEncode("data" . $id_initiative) . "&id_evaluation=" . noeliaEncode($evaluation[0]["id"]);
									?>
									<a href="add_evaluator.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-users"></i> Ver evaluadores</a>
									<a href="view_evaluation_results.php?data=<?php echo$data;?>" class="btn btn-orange">
										<span class="fa fa-bar-chart"></span> Ver resultados
									</a>
								</div>

								<hr style="height: 2px; border: 0;" class="btn-orange"/>
							</div>
						</div>


				</div>






				<?php
					/*
					if(canUpdateInitiatives()) { ?>
						<div class="box-header">
							<div class="btn-group pull-right">
								<button id="edit" name="edit" class="btn btn-orange"
									data-encuesta='<?php echo noeliaEncode($survey[0]["id"]);?>'
									data-titulo='<?php echo $survey[0]["titulo"];?>'
									data-descripcion='<?php echo $survey[0]["descripcion"];?>'
									data-toggle="modal" data-target="#editSurvey">
									<span class="fa fa-edit"></span> Editar evaluación
								</button>
								<?php
								 	$data = noeliaEncode("data" . $survey[0]["id"]);
								?>
								<a href="send_survey_all.php?data=<?php echo$data;?>" class="btn btn-orange">
									<span class="fa fa-send"></span> Enviar encuesta
								</a>

								<a href="view_survey_results.php?data=<?php echo$data;?>" class="btn btn-orange">
									<span class="fa fa-bar-chart"></span> Ver resultados
								</a>

								<button id="exportButton" name="exportButton" class="btn btn-orange"
									data-encuesta='<?php echo noeliaEncode($survey[0]["id"]);?>'
									data-toggle="modal" data-target="#addQuestion">
									<span class="fa fa-plus"></span> Agregar Pregunta
								</button>
							</div>
						</div>
				<?php
					} ?>

				<table id="tableAttendance" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Pregunta</th>
							<th>Tipo de respuesta</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
							for($i=0 ; $i<sizeof($questions) ; $i++) { ?>
								<tr>
									<td><?php echo $questions[$i]['id'];?></td>
									<td><?php echo $questions[$i]['titulo'];?></td>
									<td><?php echo $questions[$i]['tipo_respuesta'];?></td>
									<td>
										<?php
											$data = base64_encode("data" . $id_initiative) . "&id=" . base64_encode($datas[$i]['id']);
										?>

										<?php
											if(canUpdateInitiatives()) {
												$data = base64_encode("data" . $datas[$i]['id']); ?>
												<a href="#" class='btn btn-orange' title='Editar pregunta'
													data-id='<?php echo noeliaEncode($questions[$i]['id']);?>'
													data-encuesta='<?php echo noeliaEncode($survey[0]["id"]);?>'
													data-titulo='<?php echo $questions[$i]['titulo'];?>'
													data-tipo_respuesta='<?php echo $questions[$i]['tipo_respuesta'];?>'
													data-toggle="modal" data-target="#editQuestion">
													<i class="glyphicon glyphicon-edit"></i></a>

												<a href="#" class='btn btn-orange' title='Eliminar pregunta'
													data-id='<?php echo noeliaEncode($questions[$i]['id']);?>'
													data-encuesta='<?php echo noeliaEncode($survey[0]["id"]);?>'
													data-titulo='<?php echo $questions[$i]['titulo'];?>'
													data-toggle="modal" data-target="#deleteQuestion">
													<i class="glyphicon glyphicon-trash"></i></a>
										<?php
											} ?>

										<?php
											if($datas[$i]['estado'] == "Respondido") { ?>
												<i class="glyphicon glyphicon-ok text-green"></i>
										<?php
											} ?>
									</td>
								</tr>
						<?php
					} */ ?>

					</tbody>
				</table>




		<?php
			} ?>








  </div>
  <!-- /.box-body -->
