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
	$id_evaluation = base64_decode($_POST['id_evaluation']);
	$tipo = base64_decode($_POST['tipo']);

	//echo "<br> id_initiative: " . $id_initiative;
	//echo "<br> id_evaluation: " . $id_evaluation;
	//echo "<br> tipo: " . $tipo;

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationByInitiativeType($id_initiative, $tipo);

	include_once("../../controller/medoo_evaluation_evaluators.php");
	$datas = getVisibleEvaluatorsByInitiativeIdEvaluation($id_initiative, $evaluation[0]["id"]);

	include_once("../../controller/medoo_survey.php");
	include_once("../../controller/medoo_survey_answer.php");
?>

  <div class="box-body table-responsive">

		<div id="result_human_resources_detail"></div>
		<table id="tableEvaluators" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nombre</th>
					<th>Correo electrónico</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
						<tr>
							<td><?php echo $datas[$i]['id'];?></td>
							<td><?php echo $datas[$i]['nombre'];?></td>
							<td><?php echo $datas[$i]['correo_electronico'];?></td>
							<td>
								<?php
									$data = noeliaEncode("data" . $id_initiative) . "&id_evaluation=" . noeliaEncode($evaluation[0]["id"]) . "&type=" . noeliaEncode($tipo) . "&id=" . noeliaEncode($datas[$i]['id']);
								?>
								<a href="send_evaluation_one.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-send"></i> </a>

								<?php
									if(canUpdateInitiatives()) {
										$data = base64_encode("data" . $datas[$i]['id']); ?>
										<a href="#" class='btn btn-orange' title='Eliminar'
											data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'
											data-toggle="modal" data-target="#deleteEvaluator">
											<i class="glyphicon glyphicon-trash"></i></a>
								<?php
									} ?>

								<?php
									include_once("../../controller/medoo_evaluation_answer.php");
									$respuestaEncuestaActual = getVisibleEvaluationAnswerByInitiativeIdEvaluationEmail(
										$id_initiative, $evaluation[0]["id"], $datas[$i]['correo_electronico']);

									if(sizeof($respuestaEncuestaActual) > 0) { ?>
										<i class="glyphicon glyphicon-ok text-green"></i>
								<?php
							} else {
								//echo "Aún no contesta";
							}?>
							</td>
						</tr>
				<?php
					} ?>

			</tbody>
		</table>

		<div class="col-md-12">
			<div class="box-body">
				<div id="loader"></div><!-- Carga los datos ajax -->

				<br><div id="resultados_encuesta"></div>

				<div class="modal-footer">
					<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
					<?php
						$data = noeliaEncode("data" . $id_initiative) . "&id_evaluation=" . noeliaEncode($evaluation[0]["id"]) . "&type=" . noeliaEncode($tipo);
					?>
					<a href="add_evaluation.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-paste"></i> Ver evaluaciones</a>

					<a href="send_evaluation_all.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-send"></i> Enviar a todos</a>
				</div>

				<hr style="height: 2px; border: 0;" class="btn-orange"/>
			</div>
		</div>

  </div>
  <!-- /.box-body -->
