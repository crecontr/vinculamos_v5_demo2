<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];

	include_once("../../utils/user_utils.php");
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_survey.php");
	$encuesta = getSurvey($id);

	include_once("../../controller/medoo_initiatives.php");
	$initiativa = getInitiative($encuesta[0]["id_iniciativa"]);

	include_once("../../controller/medoo_programs.php");
	$programa = getProgram($initiativa[0]["id_programa"]);

	if(false) {
		echo "<br>id encuesta: " . $encuesta[0]["id"];
		echo "<br>titulo: " . $encuesta[0]["titulo"];
		echo "<br>descripcion: " . $encuesta[0]["descripcion"];
	}

	include_once("../../controller/medoo_attendance_list.php");
	$attendanceList = getVisibleAttendanceByInitiativeType($initiativa[0]["id"], $encuesta[0]["tipo"]);
?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="../../../template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "initiatives";
		include_once("../include/menu_side.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Iniciativas
        		<small>enviar encuesta</small>
      		</h1>
      		<ol class="breadcrumb">
						<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
        		<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
        		<li class="active">Enviar Encuesta</li>
      		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Enviar Encuesta a <?php echo $encuesta[0]["tipo"]?></h3>
							</div>
							<!-- /.box-header -->
						<form class="form-horizontal" method="post" id="disciplinary_evaluation" name="disciplinary_evaluation">
							<div class="box-body">
								<div id="loader"></div><!-- Carga los datos ajax -->

									<?php echo "<input type='hidden' value='".noeliaEncode($nombre_usuario)."' id='vg_usuario' name='vg_usuario' />"; ?>
									<?php echo "<input type='hidden' value='".noeliaEncode($initiativa[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>
									<?php echo "<input type='hidden' value='".noeliaEncode($encuesta[0]["id"])."' id='vg_id_encuesta' name='vg_id_encuesta' />"; ?>

									<div class="col-md-12">
										<div class="row">
											<?php
												$attendancesText = "";
												for($j=0 ; $j<sizeof($attendanceList) ; $j++) {
													$attendancesText .= ($attendanceList[$j]["nombre"] . "<" . $attendanceList[$j]["correo_electronico"] . ">");
													if($j<(sizeof($attendanceList)-1))
														$attendancesText .= ", ";
												}
											?>
											<div class="col-xs-12 col-md-12">
												<label for="vg_destinatario">Destinatarios:</label>
												<input type="text" class="form-control" id="vg_destinatario" name="vg_destinatario"
													placeholder="Destinatarios" maxlength="100" required value="<?php echo $attendancesText;?>" disabled>
											</div>
											<?php
												$iniciativaNombre = trim(str_replace("\"", "'", $initiativa[0]["nombre"]));
												$programaNombre = trim($programa[0]["nombre"]);
												$subjet = $encuesta[0]["correo_asunto"];
												if($subjet == "") {
													$subjet = "Encuesta de actividad " . str_replace("\"", "'", $initiativa[0]["nombre"]);
												}

												$data = noeliaEncode("data" . $encuesta[0]["id"]);

												$url = "http://sanagustin.vinculamosvm01.cl/vinculamos_v4_sanagustin/public/answer_survey.php?data=" . $data;
												$message = $encuesta[0]["correo_mensaje"];
												if($message == "") {
													$message = "Estimado/a,<br>";

													$message .= "En el marco de las actividades que el CFT San Agustín desarrolla en su línea de acción \"$programaNombre\", ";
													$message .= "hemos REALIZADO la actividad denominada \"" . $iniciativaNombre . "\", en la cual le agradecemos haber participado.<br>";

													$message .= "<br>Con el propósito de continuar mejorando nuestro trabajo, le pedimos que responda la siguiente <a href='$url'>encuesta</a>, que nos permitirá evaluar esta actividad.";
													$message .= "<br>Saluda atentamente a usted. <br><br>";
													$message .= "<img src='https://i0.wp.com/www.cftsanagustin.cl/wp-content/uploads/2018/11/logohead2x-e1542812192261.png?w=327&ssl=1' width='200px'>";

												}

											?>
											<div class="col-xs-12 col-md-12">
												<label for="vg_asunto">Asunto:</label>
												<input type="text" class="form-control" id="vg_asunto" name="vg_asunto"
													placeholder="Asunto" maxlength="100" required value="<?php echo$subjet?>">
											</div>

											<div class="col-xs-12 col-md-12">
												<label for="vg_mensaje">Mensaje</label>
												<textarea class="form-control textarea" placeholder="Mensaje" id="vg_mensaje" name="vg_mensaje"
                    			style="width: 100%; height: 230px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    			<?php echo $message; ?>
                    		</textarea>
											</div>

											<div class="col-xs-12 col-md-12">
												El link para acceder a la encuesta es el siguiente:<br>
												<?php echo $url;?>

											</div>
										</div>
									</div>

								<br>



						</div>
						<!-- /.box -->

						<div class="modal-footer">
							<?php
								$data = noeliaEncode("data" . $initiativa[0]["id"]);
							?>
							<a href="add_surveys.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-left"></i> Volver</a>
							<button type="submit" class="btn btn-orange"> <i class="fa fa-send"></i> Enviar</button>
						</div>
					</form>

						<hr style="height: 2px; border: 0;" class="btn-orange"/>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</section>
	    	<!-- /.content -->
	</div>
  	<!-- /.content-wrapper -->

  	<?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->

<script src="../../../template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
	$(document).ready(function(){
		loadAttendanceList();
	});

	$(function () {
		$("#vg_mensaje").wysihtml5();

	})

	$("#disciplinary_evaluation").submit(function( event ) {
		$('#disciplinary_evaluation').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_send_survey_all.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})
</script>

</body>
</html>
