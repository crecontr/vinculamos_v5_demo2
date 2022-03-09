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

	include_once("../../controller/medoo_survey.php");
	$survey = getVisibleSurveyByInitiativeType($id_initiative, utf8_encode($tipo));

	include_once("../../controller/medoo_survey_question.php");
	$questions = getVisibleQuestionsBySurvey($survey[0]["id"]);
?>

  <div class="box-body table-responsive">

		<?php
		 	if($survey == null ) { ?>

				<?php
					if(canUpdateInitiatives()) { ?>
						<div class="btn-group pull-left">
							<button id="exportButton" name="exportButton" class="btn btn-orange pull-right"
								data-tipo='<?php echo utf8_encode($tipo);?>'
								data-toggle="modal" data-target="#addSurvey">
								<span class="fa fa-plus"></span> Agregar Encuesta
							</button>
						</div>
				<?php
					} ?>

		<?php
			} else { ?>

				<?php
					if(canUpdateInitiatives()) { ?>
						<div class="box-header">
							<div class="btn-group pull-right">
								<button id="edit" name="edit" class="btn btn-orange"
									data-encuesta='<?php echo noeliaEncode($survey[0]["id"]);?>'
									data-titulo='<?php echo $survey[0]["titulo"];?>'
									data-descripcion='<?php echo $survey[0]["descripcion"];?>'
									data-toggle="modal" data-target="#editSurvey">
									<span class="fa fa-edit"></span> Editar encuesta
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

								<a href="view_survey_to_print.php?data=<?php echo$data;?>" class="btn btn-orange" target="_blank">
									<span class="fa fa-eye"></span> Ver encuesta
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
									<td><?php echo ($i+1);?></td>
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
							} ?>

					</tbody>
				</table>




		<?php
			} ?>








  </div>
  <!-- /.box-body -->
