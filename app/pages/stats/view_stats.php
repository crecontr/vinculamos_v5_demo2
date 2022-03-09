<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canReadStats()) {
		header('Location: ../../index.php');
	}

	$institucion = getInstitution();
	$refreshVal = rand();


	include_once("../../controller/medoo_initiatives.php");
	$initiatives = getVisibleInitiativesByInstitution($institucion);

	include_once("../../controller/medoo_colleges.php");
	$colleges = getVisibleCollegesByInstitution($institucion);

	include_once("../../controller/medoo_campus.php");
	$campus = getVisibleCampusByInstitution($institucion);

	include_once("../../controller/medoo_programs.php");
	$programs = getVisibleProgramsByInstitution($institucion);

	include_once("../../controller/medoo_invi_attributes.php");
	$mechanisms = getVisibleMechanism();
	$frecuencies = getVisibleFrecuency();

	include_once("../../controller/medoo_attributes.php");
	$linkManagerTypes = getVisibleLinksManagerType();
	$implementationFormats = getVisibleImplementationFormats();
	$executionStatus = getVisibleExecutionStatus();
	$fillmentStatus = getVisibleFillmentStatus();

	include_once("../../controller/medoo_environment.php");
	$environments = getVisibleEnvironments();

	include_once("../../controller/medoo_geographic.php");
	$countries = getVisibleCountries();
	$regions = getVisibleRegions();
	$communes = getVisibleCommunes();

	//include_once("../../controller/medoo_covenants.php");
	//$covenants = getVisibleCovenantsByInstitution($institucion);

	include_once("../../controller/medoo_objetives.php");
	$objetives = getVisibleObjetives();
?>

<!DOCTYPE html>
<html>
<?php include_once("../../config/settings.php")?>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

	<?php
		$activeMenu = "stats";
		include_once("../include/menu_side.php");

		include_once("../initiatives/modal_calculate_invi.php");
		include_once("../initiatives/modal_edit_status_execution.php");
		include_once("../initiatives/modal_edit_status_fillment.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		 Análisis según Iniciativas
        		<small>Análisis de datos</small>
      		</h1>
					<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Análisis de datos</li>
        		<li class="active">Análisis según Iniciativas</li>
      		</ol>
    	</section>

    	<!-- Main content -->
    	<section class="content">
      	<!-- Small boxes (Stat box) -->
      	<div class="row">
        	<div class="col-lg-3 col-xs-6">
          	<!-- small box -->
          	<div class="small-box bg-aqua">
            	<div class="inner">
              	<h3><?php echo sizeof($initiatives); ?></h3>
              	<p>Iniciativas</p>
            	</div>
            	<div class="icon">
              	<i class="fa fa-briefcase"></i>
            	</div>
            	<a href="../initiatives/view_initiatives.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
          	</div>
        	</div>
      		<!-- ./col -->
      		<div class="col-lg-3 col-xs-6">
        			<!-- small box -->
        			<div class="small-box bg-green">
          			<div class="inner">
            				<h3><?php echo sizeof($colleges); ?></h3>
            				<p>Unidad institucional</p>
          			</div>
          			<div class="icon">
            				<i class="fa fa-building"></i>
          			</div>
         				<a href="../parameters/view_colleges.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        			</div>
      		</div>
      		<!-- ./col -->
      		<div class="col-lg-3 col-xs-6">
        			<!-- small box -->
        			<div class="small-box bg-yellow">
          			<div class="inner">
            				<h3><?php echo sizeof($campus); ?></h3>
            				<p>Sedes</p>
          			</div>
          			<div class="icon">
            				<i class="fa fa-folder-open"></i>
          			</div>
          			<a href="../parameters/view_campus.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        			</div>
      		</div>
      		<!-- ./col -->
      		<div class="col-lg-3 col-xs-6">
        			<!-- small box -->
        			<div class="small-box bg-red">
          			<div class="inner">
            				<h3><?php echo sizeof($programs); ?></h3>
            				<p>Lineas de acción</p>
          			</div>
          		<div class="icon">
            			<i class="fa fa-user"></i>
          		</div>
          		<a href="../parameters/view_programs.php" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
        		</div>
        	</div>
        	<!-- ./col -->
				</div>
      	<!-- /.row -->

      	<div class="row">
					<div class="col-lg-12 col-xs-6">
						<div class="box box-default">
							<div class="box-header with-border">
							  <h3 class="box-title">Estadísticas generales por filtros</h3>
							  <div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							  </div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
							  <div class="row">
									<form id="filter_initiative" name="filter_initiative" method="post">
										<div class="col-xs-2">
											<label for="responsible">Unidad institucional</label>
												<select class="selectpicker form-control" id="college[]" name="college[]"
													title="Unidad institucional" data-live-search="true" multiple>
													<?php
														echo "<option value='0'>No aplica para esta actividad</option>";
														foreach($colleges as $college) {
															echo "<option value='" . $college['id'] . "' >" . $college['nombre']. "</option>";
														}
													?>
												</select>
										</div>
										<div class="col-xs-2">
											<label for="unit">Sede</label>
												<select class="selectpicker form-control" id="campus[]" name="campus[]"
													title="Sede" data-live-search="true" multiple>
													<?php
														echo "<option value='0'>Nivel Central</option>";
														foreach($campus as $campu) {
															echo "<option value='" . $campu['id'] . "' >" . $campu['nombre']. "</option>";
														}
													?>
												</select>
										</div>
										<div class="col-xs-2">
											<label for="program">Linea de acción</label>
												<select class="selectpicker form-control" id="program[]" name="program[]"
													title="Linea de acción" data-live-search="true" multiple>
													<?php
														foreach($programs as $program) {
															echo "<option value='" . $program['id'] . "' >" . $program['nombre']. "</option>";
														}
													?>
												</select>
										</div>
										<div class="col-xs-2">
											<label for="mechanism">Tipo de acción</label>
												<select class="selectpicker form-control" id="mechanism[]" name="mechanism[]"
													title="Tipo de acción" data-live-search="true" multiple>
													<?php
														foreach($mechanisms as $mechanism) {
															echo "<option value='" . $mechanism['id'] . "'>" . $mechanism['nombre']. "</option>";
														}
													?>
												</select>
										</div>
										<div class="col-xs-2">
											<label for="counit">Gestor de vínculo</label>
												<select class="selectpicker form-control" id="linkManagerType[]" name="linkManagerType[]"
													title="Gestor de vínculo" data-live-search="true" multiple>
													<?php
														foreach($linkManagerTypes as $linkManagerType) {
															echo "<option value='" . $linkManagerType['nombre'] . "'>" . $linkManagerType['nombre']. "</option>";
														}
													?>
												</select>
										</div>
										<div class="col-xs-2">
											<label for="frecuency">Frecuencia</label>
												<select class="selectpicker form-control" id="frecuency[]" name="frecuency[]"
													title="Gestor de vínculo" data-live-search="true" multiple>
													<?php
														foreach($frecuencies as $frecuency) {
															echo "<option value='" . $frecuency['id'] . "' >" . $frecuency['nombre']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-4">
											<label for="counit">Formato de implementación</label>
												<select class="selectpicker form-control" id="implementationFormat[]" name="implementationFormat[]"
													title="Formato de implementación" data-live-search="true" multiple>
													<?php
														foreach($implementationFormats as $implementationFormat) {
															echo "<option value='" . $implementationFormat['nombre'] . "'>" . $implementationFormat['nombre']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-2">
											<label for="environment">Grupo de interés</label>
												<select class="selectpicker form-control" id="environment[]" name="environment[]"
													title="Grupo de interés" data-live-search="true" multiple>
													<?php
														foreach($environments as $environment) {
															echo "<option value='" . $environment['id'] . "'>" . $environment['nombre']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-2">
											<label for="country">País</label>
												<select class="selectpicker form-control" id="country[]" name="country[]"
													title="País" data-live-search="true" multiple>
													<?php
														foreach($countries as $country) {
															echo "<option value='" . $country['id'] . "'>" . $country['nombre']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-2">
											<label for="country">Región</label>
												<select class="selectpicker form-control" id="region[]" name="region[]"
													title="Región" data-live-search="true" multiple>
													<?php
														foreach($regions as $region) {
															echo "<option value='" . $region['id'] . "'>" . $region['nombre']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-2">
											<label for="commune">Comuna</label>
												<select class="selectpicker form-control" id="commune[]" name="commune[]"
													title="Comuna" data-live-search="true" multiple>
													<?php
														foreach($communes as $commune) {
															echo "<option value='" . $commune['id'] . "'>" . $commune['nombre']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-6">
											<label for="mechanism">ODS</label>
												<select class="selectpicker form-control" id="objetivo[]" name="objetivo[]"
													title="ODS" data-live-search="true" data-container="body" multiple>
													<?php
														foreach($objetives as $objetive) {
															echo "<option value='" . $objetive['id'] . "'>" . $objetive['id'] . " " . $objetive['nombre_largo']. "</option>";
														}
													?>
												</select>
										</div>

										<div class="col-xs-2">
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

										<div class="col-xs-2">
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

										<div class="col-xs-2">
											<br>
											<a class="btn btn-orange" onclick="loadInitiativesByFilters();">Consultar</a>
										</div>


									</form>
									<br>
									<div class="col-lg-12">
										<div id="mostrar_resultados"></div>
									</div>

								<!-- /.col -->
								</div>
							  <!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>

    	</section>
    	<!-- /.content -->
  	</div>
  	<!-- /.content-wrapper -->

  <?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->

<script src="../../../template/bower_components/chart.js/Chart.js"></script>
<script src="../../../template/bower_components/jquery-knob/js/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

<script>
	$(document).ready(function(){
		loadInitiativesByFilters();
	});

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
			url: "../initiatives/ajax_view_calculate_invi.php",
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

	function loadInitiativesByFilters() {
		var parametros = $("#filter_initiative").serialize();

		$.ajax({
			type: "POST",
				url:'./ajax_view_stats_by_filters.php',
				data:  parametros,
				beforeSend: function () {
						$('#mostrar_resultados').html('<img src="../../img/ajax-loader.gif"> Obteniendo información, espere por favor. Cargando...');
						//$("#resultado").html("");
				},
				success:  function (response) {
						$('#mostrar_resultados').html('');
						$("#mostrar_resultados").html(response);

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

						/* GRAFICO BARRA UNIDADES */
						var barChartDataUnidades = {
							labels: etiquetasUnidades,
							datasets: [{
								label: 'Número de iniciativas',
								backgroundColor: '#F39200',
								data: cantidadesUnidades
							}]
						};

						var chartGraficoBarra1 = document.getElementById("graficoBarra1");
						var myChart1 = new Chart(chartGraficoBarra1, {
							type: 'horizontalBar',
							data: barChartDataUnidades,
							options: {
								title: {
									display: true,
									text: "Número de iniciativas"
								},
								tooltips: {
									mode: 'index',
									intersect: true,
									footerFontStyle: 'normal'
								},
								legend: {
									display: false
								},
								responsive: true,
								scales: {
									xAxes: [{
										stacked: false,
										ticks: {
											autoSkip: false
										},
										scaleLabel: {
											display: true,
											labelString: "Unidades institucionales",
											fontStyle: "bold"
											}
									}],
									yAxes: [{
										stacked: false,
										ticks: {
											min: 0,
											//fixedStepSize: 1
										},
										position: 'top',
										scaleLabel: {
											display: false,
											labelString: "Nº de iniciativas",
											fontStyle: "bold"
											}
									}]
								},
								scaleShowGridlines: true
							}
						});

						/* GRAFICO BARRA ENTORNOS */
						var barChartDataEntornos = {
							labels: etiquetasEntornos,
							datasets: [{
								label: 'Número de iniciativas',
								backgroundColor: '#337ab7',
								data: cantidadesEntornos
							}]
						};

						var chartGraficoBarra2 = document.getElementById("graficoBarra2");
						var myChart1 = new Chart(chartGraficoBarra2, {
							type: 'horizontalBar',
							data: barChartDataEntornos,
							options: {
								title: {
									display: true,
									text: "Número de iniciativas"
								},
								tooltips: {
									mode: 'index',
									intersect: true,
									footerFontStyle: 'normal'
								},
								legend: {
									display: false
								},
								responsive: true,
								scales: {
									xAxes: [{
										stacked: false,
										ticks: {
											autoSkip: false
										},
										scaleLabel: {
											display: true,
											labelString: "Grupo de interés",
											fontStyle: "bold"
											}
									}],
									yAxes: [{
										stacked: false,
										ticks: {
											min: 0,
											//fixedStepSize: 1
										},
										position: 'top',
										scaleLabel: {
											display: false,
											labelString: "Nº de iniciativas",
											fontStyle: "bold"
											}
									}]
								},
								scaleShowGridlines: true
							}
						});

						$(".knob").knob();

				},
				error: function() {
					$('#mostrar_resultados').html('');
					$("#mostrar_resultados").html(response);
				}
			});
	}

	$("#edit_execution_status").submit(function( event ) {
		$('#edit_execution_status').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "../initiatives/ajax_edit_initiative_status_execution.php",
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
			url: "../initiatives/ajax_edit_initiative_status_fillment.php",
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
</script>
</body>
</html>
