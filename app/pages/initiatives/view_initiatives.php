<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];

	include_once("../../utils/user_utils.php");
	if(!canReadInitiatives()) {
		header('Location: ../../index.php');
		return;
	}
	$institucion = getInstitution();

	include_once("../../controller/medoo_attributes.php");
	$executionStatus = getVisibleExecutionStatus();
	$fillmentStatus = getVisibleFillmentStatus();

	include_once("../../controller/medoo_colleges.php");
	$colleges = getVisibleCollegesByInstitution($institucion);

	include_once("../../controller/medoo_campus.php");
	$campuses = getVisibleCampusByInstitution($institucion);

	include_once("../../controller/medoo_carrers.php");
	$carrers = getVisibleCarrersByInstitution($institucion);

	include_once("../../controller/medoo_programs.php");
	$programs = getVisibleProgramsByInstitution($institucion);

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

		include_once("modal_calculate_invi.php");
		include_once("modal_edit_status_execution.php");
		include_once("modal_edit_status_fillment.php");
		include_once("modal_delete_initiative.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Iniciativas
        		<small>todos las iniciativas</small>
      		</h1>
      		<ol class="breadcrumb">
						<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
        		<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
        		<li class="active">Ver Iniciativas</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title">Listado de iniciativas</h3>

    						<?php
    							if(canCreateInitiatives() && false) {?>
    								<div class="btn-group pull-right">
										<button id="exportButton" name="exportButton" class="btn btn-orange pull-right"
											data-toggle="modal"
											data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
											data-target="#addProcedure">
											<span class="fa fa-plus-circle"></span> Agregar Iniciativa
										</button>
									</div>
							<?php
								} ?>
						</div>
						<!-- /.box-header -->

						<div class="row">
							<div class="col-lg-12 col-xs-6">
								<form id="filter_initiative" name="filter_initiative" method="post">
									<div class="col-xs-3">
										<label for="counit">Estado de Ejecución</label>
											<select class="selectpicker form-control" id="executionStatus[]" name="executionStatus[]"
												title="Estado de Ejecución" data-live-search="true" multiple>
												<?php
													foreach($executionStatus as $executionState) {
														echo "<option value='" . $executionState['nombre'] . "'>" . $executionState['nombre']. "</option>";
													}
												?>
											</select>
									</div>

									<div class="col-xs-3">
										<label for="counit">Estado de Completitud</label>
											<select class="selectpicker form-control" id="fillmentStatus[]" name="fillmentStatus[]"
												title="Estado de Completitud" data-live-search="true" multiple>
												<?php
													foreach($fillmentStatus as $fillmentState) {
														echo "<option value='" . $fillmentState['nombre'] . "'>" . $fillmentState['nombre']. "</option>";
													}
												?>
											</select>
									</div>

									<div class="col-xs-3">
                		<label for="vg_fecha_inicio">Fecha de inicio</label>
                  	<input type="date" class="form-control" id="vg_fecha_inicio" name="vg_fecha_inicio"
											placeholder="Fecha de inicio">
                	</div>

									<div class="col-xs-3">
                		<label for="vg_fecha_finalizacion">Fecha de finalización</label>
                  	<input type="date" class="form-control" id="vg_fecha_finalizacion" name="vg_fecha_finalizacion"
											placeholder="Fecha de finalización">
                	</div>

									<div class="col-xs-3">
										<label for="vg_escuela">Unidad institucional</label>
										<select class="selectpicker form-control" id="vg_escuela[]" name="vg_escuela[]"
											title="Unidad institucional" multiple data-live-search="true">
											<?php
												foreach($colleges as $college) {
													echo "<option value=" . $college['id'] .">" . $college['nombre']. "</option>";
												}
											?>
										</select>
									</div>

									<div class="col-xs-2">
										<label for="vg_sede">Sede </label>
										<select class="selectpicker form-control" id="vg_sede[]" name="vg_sede[]"
											title="Sede" multiple data-live-search="true">
											<?php
												foreach($campuses as $campus) {
													echo "<option value=" . $campus['id'] .">" . $campus['nombre']. "</option>";
												}
											?>
										</select>
									</div>

									<div class="col-xs-3">
										<label for="vg_sede">Carrera </label>
										<select class="selectpicker form-control" id="vg_carrera[]" name="vg_carrera[]"
											title="Carrera" multiple data-live-search="true">
											<?php
												foreach($carrers as $carrer) {
													echo "<option value=" . $carrer['id'] .">" . $carrer['nombre']. "</option>";
												}
											?>
										</select>
									</div>

									<div class="col-xs-3">
										<label for="vg_programa">Linea de acción</label>
										<select class="selectpicker form-control" id="vg_programa[]" name="vg_programa[]"
											title="Linea de acción" multiple data-live-search="true" onchange="selectProgram();">
										<?php
											foreach($programs as $program) {
												echo "<option value=" . $program['id'] .">" . $program['nombre']. "</option>";
											}
										?>
										</select>
									</div>

									<div class="col-xs-1">
										<br>
										<a class="btn btn-orange" onclick="load();">Filtrar</a>
									</div>

								</form>
							</div>
						</div>

						<div class="col-md-12">
							<div id="mensaje_resultados"></div><!-- Carga los datos ajax -->
						</div>

						<span id="loader"></span>
						<div id="resultados"></div><!-- Carga los datos ajax -->
					</div>
					<!-- /.box -->
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
		load();
	});

	function load() {
		var parametros = $("#filter_initiative").serialize();

		$.ajax({
			type: "POST",
      url:'./ajax_view_initiatives.php',
      data: parametros,
      beforeSend: function () {
        $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
        $("#resultados").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $('#loader').html('');
        $("#resultados").html(response);

        $('#table').DataTable({
					'language': {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
  				'paging'      : true,
  				'lengthChange': true,
  				'searching'   : true,
  				'ordering'    : false,
  				'info'        : true,
  				'autoWidth'   : true
  			})
      },
			error: function() {
				$('#loader').html('');
				$("#resultados").html(response);
			}
    });
	}

	$('#calculateScoreVCM').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var iniciativa = button.data('iniciativa');
		var usuario = button.data('usuario');

		var modal = $(this);
		//modal.find('.modal-body #vg_usuario').val(usuario);
		//modal.find('.modal-body #vg_initiative').val(iniciativa);
		modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html("Prueba");

		var parametros = {
				"id_initiative" : iniciativa
		};

		$.ajax({
			type: "POST",
			url: "./ajax_view_calculate_invi.php",
			data: parametros,
			beforeSend: function(objeto) {
				modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html("Cargando...");
			},
			success: function(datos) {
				modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html(datos);
			},
			error: function() {
				modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html("Error en el registro");
			}
		});

	})

	$("#edit_execution_status").submit(function( event ) {
		$('#edit_execution_status').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_initiative_status_execution.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_estado_ejecucion").html("Cargando...");
			},
			success: function(datos) {
				$('#edit_execution_status').attr("disabled", false);
				$("#resultados_modal_estado_ejecucion").html("");

				var myJSON = JSON.parse(datos);
				var idEjecucion = ("#ejecucion" + myJSON.id);
				$(idEjecucion).html(myJSON.estado_ejecucion);
				$('#editStatusExecution').modal('hide');
			},
			error: function() {
				$("#resultados_modal_estado_ejecucion").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editStatusExecution').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id_iniciativa = button.data('id_iniciativa');
		var estado_ejecucion = button.data('estado_ejecucion');

		var modal = $(this);
		modal.find('.modal-body #vg_initiative').val(id_iniciativa);
		modal.find('.modal-body #vg_estado_ejecucion').selectpicker('val', estado_ejecucion);

		$("#resultados_modal_estado_ejecucion").html("");
	})

	$("#edit_fillment_status").submit(function( event ) {
		$('#edit_fillment_status').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_initiative_status_fillment.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_estado_completitud").html("Cargando...");
			},
			success: function(datos) {
				$('#edit_fillment_status').attr("disabled", false);
				$("#resultados_modal_estado_completitud").html("");

				var myJSON = JSON.parse(datos);
				var idCompletitud = ("#completitud" + myJSON.id);
				$(idCompletitud).html(myJSON.estado_completitud);
				$('#editStatusFillment').modal('hide');
			},
			error: function() {
				$("#resultados_modal_estado_completitud").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editStatusFillment').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id_iniciativa = button.data('id_iniciativa');
		var estado_completitud = button.data('estado_completitud');

		var modal = $(this);
		modal.find('.modal-body #vg_initiative').val(id_iniciativa);
		modal.find('.modal-body #vg_estado_completitud').selectpicker('val', estado_completitud);

		$("#resultados_modal_estado_completitud").html("");
	})

	$("#delete_initiative").submit(function( event ) {
		$('#delete_initiative').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_initiative.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$('#delete_initiative').attr("disabled", false);
				$('#deleteInitiative').modal('hide');
				$("#mensaje_resultados").html(datos);
				load();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteInitiative').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id_iniciativa = button.data('id_iniciativa');
		var nombre = button.data('nombre');
		var usuario = button.data('usuario');

		var modal = $(this);
		modal.find('.modal-body #vg_initiative').val(id_iniciativa);
		modal.find('.modal-body #vg_nombre').html(nombre);
		modal.find('.modal-body #vg_usuario').val(usuario);

		$("#resultados_modal_eliminar").html("");
	})

</script>
</body>
</html>
