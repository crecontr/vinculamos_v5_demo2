<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canCreateInitiatives()) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];
	$institucion = getInstitution();

	include_once("../../controller/medoo_colleges.php");
	$colleges = getVisibleCollegesByInstitution($institucion);

	include_once("../../controller/medoo_campus.php");
	$campuses = getVisibleCampusByInstitution($institucion);

	include_once("../../controller/medoo_carrers.php");
	$carrers = getVisibleCarrersByInstitution($institucion);

	include_once("../../controller/medoo_programs.php");
	$programs = getVisibleProgramsByInstitution($institucion);

	include_once("../../controller/medoo_invi_attributes.php");
	$mechanisms = getVisibleMechanism();
	$frecuencies = getVisibleFrecuency();

	include_once("../../controller/medoo_attributes.php");
	$managerPositions = getVisibleManagerPositions();
	$implementationFormats = getVisibleImplementationFormats();

	include_once("../../controller/medoo_covenants.php");
	$covenants = getVisibleCovenantsByInstitution($institucion);

	include_once("../../controller/medoo_geographic.php");
	$countries = getVisibleCountries();
	$countries[0]["selected"] = "selected";

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
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Iniciativas
        		<small>crear iniciativa</small>
      		</h1>
      		<ol class="breadcrumb">
        		<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
        		<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
        		<li class="active">Agregar Iniciativa</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title">Nueva iniciativa</h3>
						</div>
						<!-- /.box-header -->

						<div class="box-body">
							<div id="loader"></div><!-- Carga los datos ajax -->

    						<form class="form-horizontal" method="post" id="add_initiative" name="add_initiative">
								<?php echo "<input type='hidden' value='".$nombre_usuario."' id='vg_autor' name='vg_autor' />"; ?>

								<div class="row">
									<div class="col-xs-12 col-md-10">
                		<label for="vg_nombre">Nombre de actividad <span class="text-red">*</span></label>
										<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
											placeholder="Nombre" maxlength="500" required >
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_fecha_inicio">Fecha de inicio <span class="text-red">*</span></label>
                  	<input type="date" class="form-control" id="vg_fecha_inicio" name="vg_fecha_inicio"
											placeholder="Fecha de inicio" required>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_fecha_finalizacion">Fecha de finalización</label>
                  	<input type="date" class="form-control" id="vg_fecha_finalizacion" name="vg_fecha_finalizacion"
											placeholder="Fecha de finalización">
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_escuela">Unidad Institucional creadora <span class="text-red">*</span></label>
                  	<select class="selectpicker form-control" id="vg_escuela[]" name="vg_escuela[]"
											title="Unidad Institucional creadora" multiple required data-live-search="true">
											<?php
												echo "<option value=''>No aplica para esta actividad</option>";
												foreach($colleges as $college) {
													echo "<option value=" . $college['id'] .">" . $college['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_sede">Sede </label>
                  	<select class="selectpicker form-control" id="vg_sede[]" name="vg_sede[]"
											title="Sede" multiple data-live-search="true">
											<?php
												echo "<option value=''>Nivel Central</option>";
												foreach($campuses as $campus) {
													echo "<option value=" . $campus['id'] .">" . $campus['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-12 col-md-3">
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
									<div class="col-xs-12 col-md-5">
                		<label for="vg_programa">Linea de acción <span class="text-red">*</span></label>
                		<select class="selectpicker form-control" id="vg_programa" name="vg_programa"
											title="Linea de acción" required data-live-search="true" onchange="selectProgram();">
										<?php
											foreach($programs as $program) {
												echo "<option value=" . $program['id'] .">" . $program['nombre']. "</option>";
											}
										?>
										</select>
                  </div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_programa_secundario">¿Se relaciona con otra línea de acción?</label>
                		<select class="selectpicker form-control" id="vg_programa_secundario" name="vg_programa_secundario[]"
											title="¿Se relaciona con otra línea de acción?" multiple data-live-search="true">
										</select>
                  </div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_mecanismo">Mecanismo <span class="text-red">*</span></label>
                  	<select class="selectpicker form-control" id="vg_mecanismo" name="vg_mecanismo"
											title="Mecanismo" data-live-search="true" required>
											<?php
												foreach($mechanisms as $mechanism) {
													echo "<option value='" . $mechanism['id'] . "'>" . $mechanism['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_frecuencia">Frecuencia <span class="text-red">*</span></label>
                  	<select class="selectpicker form-control" id="vg_frecuencia" name="vg_frecuencia"
											title="Frecuencia" required data-live-search="true">
											<?php
												foreach($frecuencies as $frecuency) {
													echo "<option value=" . $frecuency['id'] .">" . $frecuency['nombre']. "</option>";
												}
											?>
										</select>
                  </div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_formato_implementacion">Formato de implementación </label>
                  	<select class="selectpicker form-control" id="vg_formato_implementacion" name="vg_formato_implementacion"
											title="Formato de implementación" data-live-search="true">
											<?php
												foreach($implementationFormats as $implementationFormat) {
													echo "<option value='" . $implementationFormat['nombre'] . "'>" . $implementationFormat['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_encargado">Nombre encargado responsable</label>
										<input type="text" class="form-control" id="vg_encargado" name="vg_encargado"
											placeholder="Nombre encargado responsable" maxlength="100">
                  </div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_encargado_cargo">Cargo encargado responsable</label>
                  	<select class="selectpicker form-control" id="vg_encargado_cargo" name="vg_encargado_cargo"
											title="Cargo encargado responsable" data-live-search="true">
											<?php
												foreach($managerPositions as $managerPosition) {
													echo "<option value='" . $managerPosition['nombre'] . "'>" . $managerPosition['nombre']. "</option>";
												}
											?>
										</select>
                	</div>

									<div class="col-xs-6 col-md-3" style="visibility: hidden">
                		<label for="vg_convenios">Convenios</label>
                  	<select class="selectpicker form-control" id="vg_convenios[]" name="vg_convenios[]"
											title="Convenios" multiple data-live-search="true">
											<?php
												foreach($covenants as $covenant) {
													echo "<option value=" . $covenant['id'] .">" . $covenant['nombre']. "</option>";
												}
											?>
										</select>
                	</div>

									<div class="col-xs-6 col-md-4">
										<label for="vg_pais">País</label>
										<select class="selectpicker form-control" id="vg_pais" name="vg_pais[]" required
											title="País" data-live-search="true" multiple onchange="selectCountry();">
										<?php
											foreach($countries as $country) {
												echo "<option value='" . $country['id'] . "' ".$country['selected'].">" . $country['nombre']. "</option>";
											}
										?>
										</select>
									</div>
									<div class="col-xs-6 col-md-4">
										<label for="vg_region">Región</label>
										<select class="selectpicker form-control" id="vg_region" name="vg_region[]"
											title="Región" data-live-search="true" multiple onchange="selectRegion();" data-container="body" data-actions-box="true"
											data-none-selected-text="please select...">
										</select>
									</div>
									<div class="col-xs-6 col-md-4">
										<label for="vg_comuna">Comuna</label>
										<select class="selectpicker form-control" id="vg_comuna" name="vg_comuna[]"
											title="Comuna" data-live-search="true" multiple data-container="body" data-actions-box="true">
										</select>
									</div>

								</div>
								<br>
								<div class="modal-footer">
									<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
									<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Siguiente</button>
								</div>

							</form>

							<hr style="height: 2px; border: 0;" class="btn-orange"/>

							<div id="loader"></div>

    				</div>
    				<!-- /.box-body -->
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
		selectProgram();
		selectCountry();
	});

	function selectProgram() {
		var parametros = $("#add_initiative").serialize();

		$.ajax({
			type: "POST",
      url:'../json/json_programs_secondary.php',
			data: parametros,
      beforeSend: function () {
        $("#loader").html("Realizando búsqueda, espere por favor.");
      },
      success:  function (response) {
        $("#loader").html("");

				var myJSON = JSON.parse(response);
				var options = "";
				options += '<option value="" title="No">No</option>';
        for (var i = 0; i < myJSON.length; i++) {
					var region = myJSON[i];
					options += '<option value="' + region.id + '" title="' + region.nombre + '">' + region.nombre + '</option>';
				}

      	$("#vg_programa_secundario")
			   .html(options)
			   .selectpicker('refresh');
      },
			error: function() {
				$("#loader").html(response);
			}
		});
	}

	function selectCountry() {
		var parametros = $("#add_initiative").serialize();

		$.ajax({
			type: "POST",
      url:'../json/json_regions.php',
			data: parametros,
      beforeSend: function () {
        $("#loader").html("Realizando búsqueda, espere por favor.");
      },
      success:  function (response) {
        $("#loader").html("");

				var myJSON = JSON.parse(response);
				var options = "";
        for (var i = 0; i < myJSON.length; i++) {
					var region = myJSON[i];
					options += '<option value="' + region.id + '" title="' + region.nombre + '">' + region.nombre + '</option>';
				}

      	$("#vg_region")
			   .html(options)
			   .selectpicker('refresh');
      },
			error: function() {
				$("#loader").html(response);
			}
		});
	}

	function selectRegion() {
		var parametros = $("#add_initiative").serialize();

		$.ajax({
			type: "POST",
      url:'../json/json_commune.php',
			data: parametros,
      beforeSend: function () {
        $("#loader").html("Realizando búsqueda, espere por favor.");
      },
      success:  function (response) {
        $("#loader").html("");

				var myJSON = JSON.parse(response);
				var options = "";
        for (var i = 0; i < myJSON.length; i++) {
					var region = myJSON[i];
					options += '<option value="' + region.id + '" title="' + region.nombre + '">' + region.nombre + '</option>';
				}

      	$("#vg_comuna")
			   .html(options)
				 .selectpicker('refresh');
      },
			error: function() {
				$("#loader").html(response);
			}
		});
	}

	$("#add_initiative").submit(function( event ) {
		$('#add_initiative').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_initiative.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html("");

				if (datos != "-1") {
     			window.location.href = "./edit_initiative_step2.php?data=" + datos;
				}
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
