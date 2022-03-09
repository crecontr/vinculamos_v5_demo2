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

	include_once("../../controller/medoo_attendance_list.php");
	$datas = getVisibleAttendanceByInitiativeType($id_initiative, utf8_encode($tipo));

	include_once("../../controller/medoo_survey.php");
	include_once("../../controller/medoo_survey_answer.php");
?>

  <div class="box-body table-responsive">

		<div id="result_human_resources_detail"></div>
		<table id="tableAttendance" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Correo electrónico</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
						<tr>
							<td><?php echo ($i+1);?></td>
							<td><?php echo $datas[$i]['rut'];?></td>
							<td><?php echo $datas[$i]['nombre'];?></td>
							<td><?php echo $datas[$i]['correo_electronico'];?></td>
							<td>
								<?php
									$data = noeliaEncode("data" . $id_initiative) . "&type=" . noeliaEncode($tipo) . "&id=" . noeliaEncode($datas[$i]['id']);
								?>
								<a href="send_survey_one.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-send"></i> </a>

								<?php
									if(canUpdateInitiatives()) {
										$data = base64_encode("data" . $datas[$i]['id']); ?>
										<a href="#" class='btn btn-orange' title='Eliminar'
											data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'
											data-toggle="modal" data-target="#deleteParticipation">
											<i class="glyphicon glyphicon-trash"></i></a>
								<?php
									} ?>

								<?php
									$encuesta = getVisibleSurveyByInitiativeType($id_initiative, utf8_encode($tipo));

									$respuestaEncuestaActual = getVisibleAnswersBySurveyParticipation(
										$encuesta[0]["id"], $datas[$i]['id']);

									if(sizeof($respuestaEncuestaActual) > 0) { ?>
										<i class="glyphicon glyphicon-ok text-green"></i>
								<?php
									} ?>
							</td>
						</tr>
				<?php
					} ?>

			</tbody>
		</table>



  </div>
  <!-- /.box-body -->
