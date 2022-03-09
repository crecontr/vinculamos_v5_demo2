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

	$id_initiative = str_replace("data", "", noeliaDecode($_GET["data"]));
	$id_evaluation = str_replace("data", "", noeliaDecode($_GET["id_evaluation"]));
	$type = noeliaDecode($_GET["type"]);
	$id_evaluator = noeliaDecode($_GET["id"]);

	include_once("../../controller/medoo_initiatives.php");
	$initiativa = getInitiative($id_initiative);

	include_once("../../controller/medoo_programs.php");
	$programa = getProgram($initiativa[0]["id_programa"]);

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationByInitiativeIdEvaluation($initiativa[0]["id"], $id_evaluation);

	if(false) {
		echo "<br> id_initiative: " . $id_initiative;
		echo "<br> id_evaluation: " . $id_evaluation;
		echo "<br> type: " . $type;
		echo "<br> id_evaluator: " . $id_evaluator;
		echo "<br>titulo: " . $evaluation[0]["titulo"];
		echo "<br>descripcion: " . $evaluation[0]["descripcion"];
	}

	include_once("../../controller/medoo_evaluation_evaluators.php");
	$evaluadores = getVisibleEvaluatorsByInitiativeIdEvaluation($initiativa[0]["id"], $id_evaluation);
	//$evaluador = getEvaluator($id_evaluator);
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

		include_once("modal_delete_attendance.php");
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
	    						<h3 class="box-title"><?php echo ($initiativa[0]["nombre"] == "" ? "Editar iniciativa" : $initiativa[0]["nombre"]);?> - Evaluaciones - Enviar evaluación de <?php echo $type?></h3>
							</div>
							<!-- /.box-header -->
						<form class="form-horizontal" method="post" id="vinculamos_evaluation" name="vinculamos_evaluation">
							<div class="box-body">
								<div id="loader"></div><!-- Carga los datos ajax -->

									<?php echo "<input type='hidden' value='".($nombre_usuario)."' id='vg_usuario' name='vg_usuario' />"; ?>
									<?php echo "<input type='hidden' value='".noeliaEncode($initiativa[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>
									<?php echo "<input type='hidden' value='".noeliaEncode($evaluation[0]["id"])."' id='id_evaluation' name='id_evaluation' />"; ?>
									<?php echo "<input type='hidden' value='".noeliaEncode($id_evaluator)."' id='vg_id_evaluador' name='vg_id_evaluador' />"; ?>

									<div class="col-md-12">
										<div class="row">
											<?php
												$attendancesText = "";
												for($j=0 ; $j<sizeof($evaluadores) ; $j++) {
													$attendancesText .= ($evaluadores[$j]["nombre"] . "<" . $evaluadores[$j]["correo_electronico"] . ">");
													if($j<(sizeof($evaluadores)-1))
														$attendancesText .= ", ";
												}
											?>

											<div class="col-xs-12 col-md-12">
												<label for="vg_destinatario">Destinatario(s):</label>
												<input type="text" class="form-control" id="vg_destinatario" name="vg_destinatario"
													placeholder="Destinatarios" maxlength="100" required value="<?php echo $attendancesText;?>" disabled>
											</div>
											<?php
												$iniciativaNombre = trim(str_replace("\"", "'", $initiativa[0]["nombre"]));
												$programaNombre = trim($programa[0]["nombre"]);
												$subjet = $encuesta[0]["correo_asunto"];
												if($subjet == "") {
													$subjet = "Evaluación de actividad " . str_replace("\"", "'", $initiativa[0]["nombre"]);
												}

												$data = noeliaEncode("data" . $evaluation[0]["id"]);

												$url = "http://demo2.vinculamosvm01.cl/vinculamos_v5_demo2/public/answer_evaluation.php?data=" . $data;
												$message = $encuesta[0]["correo_mensaje"];
												if($message == "") {
													$message = "Estimado/a,<br>";

													$message .= "En el marco de las actividades que la universidad desarrolla en su línea de acción \"$programaNombre\", ";
													$message .= "hemos realizado la actividad denominada \"" . $iniciativaNombre . "\", en la cual le agradecemos haber participado.<br>";

													$message .= "<br>Con el propósito de continuar mejorando nuestro trabajo, le pedimos que responda la siguiente <a href='$url'>encuesta</a>, que nos permitirá evaluar esta actividad.";
													$message .= "<br>Saluda atentamente a usted. <br><br>";
													$message .= "<img src='http://demo2.vinculamosvm01.cl/vinculamos_v5_demo2/app/img/logo_texto.png' width='200px'>";
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
												El link para acceder a la evaluación es el siguiente:<br>
												<a href="#" class="btn btn-orange" onclick="copyLink()"> <i class="fa fa-copy"></i> Copiar enlace</a>
											</div>
										</div>
									</div>

								<br>



						</div>
						<!-- /.box -->

						<div class="modal-footer">
							<?php
								$data = noeliaEncode("data" . $initiativa[0]["id"]);
								$data = noeliaEncode("data" . $id_initiative) . "&id_evaluation=" . noeliaEncode($evaluation[0]["id"]);
							?>
							<a href="add_evaluator.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-left"></i> Volver</a>
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

	});

	$(function () {
		$("#vg_mensaje").wysihtml5();
	})

	$("#vinculamos_evaluation").submit(function( event ) {
		$('#vinculamos_evaluation').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_send_evaluation_all.php",
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

	function copyLink() {
		var copyText = "<?php echo$url?>";

		var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(copyText).select();
    document.execCommand("copy");
    $temp.remove();
	}
</script>

</body>
</html>
