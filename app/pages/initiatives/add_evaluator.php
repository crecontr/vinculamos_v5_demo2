<?php
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');

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
	$id_evaluation = noeliaDecode($_GET["id_evaluation"]);

	if(false) {
		echo "<br> id: " . $id;
		echo "<br> id_evaluation: " . $id_evaluation;
		echo "<br> type: " . $type;
	}

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationByInitiativeIdEvaluation($id, $id_evaluation);

	include_once("../../controller/medoo_initiatives.php");
	$datas = getInitiative($id);

	include_once("../../controller/medoo_evaluation_types.php");
	$evaluatorTypes = getEvaluationTypes($institution);
	for ($i=0; $i < sizeof($evaluatorTypes); $i++) {
		if($evaluatorTypes[$i]["nombre"] == $evaluation[0]["tipo_evaluacion"]) {
			$evaluatorTypes[$i]["selected"] = "selected";
		}
	}

	/*
	include_once("../../controller/medoo_participation_real.php");
	$participacion_real = getVisibleRealParticipationByInitiative($datas[0]["id"]);

	$tipos_participantes = array();
	for ($i=0; $i < sizeof($participacion_real); $i++) {
		if(!in_array($participacion_real[$i]["tipo"], $tipos_participantes)) {
			$tipos_participantes[] = $participacion_real[$i]["tipo"];
		}
	}
	*/

?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "initiatives";
		include_once("../include/menu_side.php");

		include_once("modal_delete_evaluador.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
	  		<h1>
	    		Iniciativas
	    		<small>evaluaciones</small>
	  		</h1>
	  		<ol class="breadcrumb">
					<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
					<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
	    		<li class="active">Lista de Evaluadores</li>
	  		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Evaluaciones - Lista de Evaluadores</h3>
							</div>
							<!-- /.box-header -->

							<div class="box-body">
								<?php
								 	if(sizeof($evaluatorTypes) == 0) { ?>
										<p><strong>Para agregar evaluadores, primero debe ingresar el paso 3: Participantes de la iniciativa.</strong></p>
										<div class="modal-footer">
											<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
											<?php
												$data = noeliaEncode("data" . $id);
											?>

											<?php
				      					if(canUpdateInitiatives()) { ?>
													<a href="edit_initiative_step1.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-table"></i> Editar iniciativa</a>
											<?php
												} ?>
										</div>
								<?php
									} else { ?>

										<div class="row">
											<div class="col-md-12">
												<div id="mensaje_resultados"></div>
											</div>

											<div class="col-md-4">
												<div>
													<label for="vg_tipo_evaluador">Tipo de evaluador:</label>
													<select class="selectpicker form-control" id="vg_tipo_evaluador" name="vg_tipo_evaluador"
														title="Tipo de evaluador" onchange="load()">
														<?php
															for ($i=0; $i < sizeof($evaluatorTypes); $i++) { ?>
																<option value='<?php echo$evaluatorTypes[$i]["nombre"]?>' <?php echo$evaluatorTypes[$i]["selected"]?>><?php echo$evaluatorTypes[$i]["nombre"]?></option>
														<?php
															} ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="box-body">
												<div id="loader"></div><!-- Carga los datos ajax -->
												<div class="col-md-8">
													<form class="form-horizontal" method="post" id="add_evaluator" name="add_evaluator">
														<?php echo "<input type='hidden' value='".($nombre_usuario)."' id='vg_usuario' name='vg_usuario' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($id_evaluation)."' id='vg_id_evaluation' name='vg_id_evaluation' />"; ?>
														<?php echo "<input type='hidden' value='' id='vg_tipo' name='vg_tipo' />"; ?>

														<div class="col-md-12">
															<div class="row">
																<h4>Cargar manualmente</h4>
																<div class="col-xs-6 col-md-6">
																	<label for="vg_nombre">Nombre completo</label>
																	<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
																		placeholder="Nombre completo" maxlength="100" required>
																</div>
																<div class="col-xs-6 col-md-6">
																	<label for="vg_correo">Correo electrónico</label>
																	<input type="email" class="form-control" id="vg_correo" name="vg_correo"
																		placeholder="Correo electrónico" maxlength="100" required>
																</div>
															</div>
															<div class="row">
																<div class="ol-md-12 pull-right">
																	<br>
																	<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Guardar</button>
																</div>
															</div>
														</div>
													</form>
												</div>

												<div class="col-md-4">
													<form class="form-horizontal" method="post" id="add_evaluator_excel" name="add_evaluator_excel">
														<?php echo "<input type='hidden' value='".($nombre_usuario)."' id='vg_usuario' name='vg_usuario' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($id_evaluation)."' id='vg_id_evaluation' name='vg_id_evaluation' />"; ?>
														<?php echo "<input type='hidden' value='' id='vg_tipo2' name='vg_tipo2' />"; ?>

														<h4>Cargar desde archivo</h4>
														<div class="col-xs-12 col-md-12">
															<label for="vg_rut">Archivo (<a href="../../templates_upload/evaluadores.xlsx">descargar plantilla</a>)</label>
															<input class="form-control" type="file" id="vg_excel" name="vg_excel" accept=".xls,.xlsx">
														</div>
														<div class="row">
															<div class="ol-md-12 pull-right">
																<br>
																<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Guardar</button>
															</div>
														</div>
													</form>
												</div>

												<br><div id="resultados_evaluadores"></div>

											</div>
										</div>

								<?php
									} ?>

							</div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>
	$(document).ready(function(){
		load()
	});

	function load() {
		$("#vg_tipo").val($("#vg_tipo_evaluador").val());
		$("#vg_tipo2").val($("#vg_tipo_evaluador").val());
		loadEvaluatorsList($("#vg_tipo_evaluador").val())
		//$("#loader").html("");
		//$("#resultados_esperados").html("");
	}

	function loadEvaluatorsList(tipo) {
		var parametros = {
			"id_initiative" : btoa(<?php echo$id;?>),
			"id_evaluation" : btoa(<?php echo$id_evaluation;?>),
			"tipo" : btoa(tipo)
    };
		$.ajax({
			type: "POST",
      url: "./ajax_view_evaluators.php",
      data:  parametros,
      beforeSend: function () {
        $("#resultados_evaluadores").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#resultados_evaluadores").html(response);

				$("#tableEvaluators").DataTable({
					'language': {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					'paging'      : true,
					'lengthChange': true,
					'searching'   : true,
					'ordering'    : true,
					'info'        : true,
					'autoWidth'   : true
				})
      },
			error: function() {
				$("#resultados_evaluadores").html(response);
			}
    });
	}

	$("#add_evaluator").submit(function( event ) {
		$('#add_evaluator').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_evaluator.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				if(datos.includes("correctamente")) {
					$("#vg_nombre").val("");
					$("#vg_correo").val("");

					load();
				}
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$("#delete_evaluator").submit(function( event ) {
		$('#delete_evaluator').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_evaluator.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				if(datos.includes("correctamente")) {
					$('#deleteEvaluator').modal('hide');
					load();
				}
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteEvaluator').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		$("#loader").html("");
	})

	$("#add_evaluator_excel").submit(function( event ) {
		$('#add_evaluator_excel').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_evaluator_excel.php",
			data: new FormData(this),
			processData: false,
			contentType: false,
			beforeSend: function(objeto) {
				$("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			},
			success: function(datos) {
				$('#add_evaluator_excel').attr("disabled", false);
				$("#loader").html(datos);

				load();
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
