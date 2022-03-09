<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateInitiatives()) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];
	$institucion = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_initiatives.php");
	$datas = getInitiative($id);

	include_once("../../controller/medoo_colleges.php");
	$colleges = getVisibleCollegesByInstitution($institucion);
	$myCollegues = getCollegesByInitiative($datas[0]["id"]);
	$collegeFound = false;
	for($i=0; $i<sizeof($colleges); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myCollegues); $j++) {
			if($colleges[$i]["id"] == $myCollegues[$j]["id"]) {
				$found = true;
				$collegeFound = true;
			}
		}
		if($found == true)
			$colleges[$i]["selected"] = "selected";
		else
			$colleges[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_campus.php");
	$campuses = getVisibleCampusByInstitution($institucion);
	$myCampus = getCampusByInitiative($datas[0]["id"]);
	$campusFound = false;
	for($i=0; $i<sizeof($campuses); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myCampus); $j++) {
			if($campuses[$i]["id"] == $myCampus[$j]["id"]) {
				$found = true;
				$campusFound = true;
			}
		}
		if($found == true)
			$campuses[$i]["selected"] = "selected";
		else
			$campuses[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_carrers.php");
	$carrers = getVisibleCarrersByInstitution($institucion);
	$myCarrers = getCarrersByInitiative($datas[0]["id"]);
	$carrerFound = false;
	for($i=0; $i<sizeof($carrers); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myCarrers); $j++) {
			if($carrers[$i]["id"] == $myCarrers[$j]["id"]) {
				$found = true;
				$campusFound = true;
			}
		}
		if($found == true)
			$carrers[$i]["selected"] = "selected";
		else
			$carrers[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_programs.php");
	$programs = getVisibleProgramsByInstitution($institucion);
	$programs_secondary = array();
	for($i=0; $i<sizeof($programs); $i++) {
		if($programs[$i]["id"] != $datas[0]["id_programa"]) {
			$programs_secondary[] = $programs[$i];
		}
	}
	$myProgramsSecondary = getProgramsByInitiative($datas[0]["id"]);
	$programSecondaryFound = false;
	for($i=0; $i<sizeof($programs_secondary); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myProgramsSecondary); $j++) {
			if($programs_secondary[$i]["id"] == $myProgramsSecondary[$j]["id"]) {
				$found = true;
				$programSecondaryFound = true;
			}
		}
		if($found == true)
			$programs_secondary[$i]["selected"] = "selected";
		else
			$programs_secondary[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_invi_attributes.php");
	$mechanisms = getVisibleMechanism();
	for ($i=0; $i < sizeof($mechanisms); $i++) {
		if($datas[0]["id_mecanismo"] == $mechanisms[$i]['id']) {
			$mechanisms[$i]["selected"] = "selected";
		} else {
			$mechanisms[$i]["selected"] = "";
		}
	}

	$frecuencies = getVisibleFrecuency();
	for ($i=0; $i < sizeof($frecuencies); $i++) {
		if($datas[0]["id_frecuencia"] == $frecuencies[$i]['id']) {
			$frecuencies[$i]["selected"] = "selected";
		} else {
			$frecuencies[$i]["selected"] = "";
		}
	}

	include_once("../../controller/medoo_attributes.php");
	$managerPositions = getVisibleManagerPositions();
	for ($i=0; $i < sizeof($managerPositions); $i++) {
		if($datas[0]["responsable_cargo"] == $managerPositions[$i]['nombre']) {
			$managerPositions[$i]["selected"] = "selected";
		} else {
			$managerPositions[$i]["selected"] = "";
		}
	}

	$implementationFormats = getVisibleImplementationFormats();
	for ($i=0; $i < sizeof($implementationFormats); $i++) {
		if($datas[0]["formato_implementacion"] == $implementationFormats[$i]['nombre']) {
			$implementationFormats[$i]["selected"] = "selected";
		} else {
			$implementationFormats[$i]["selected"] = "";
		}
	}

	include_once("../../controller/medoo_covenants.php");
	$covenants = getVisibleCovenantsByInstitution($institucion);
	$myCovenants = getCovenantsByInitiative($datas[0]["id"]);
	for($i=0; $i<sizeof($covenants); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myCovenants); $j++) {
			if($covenants[$i]["id"] == $myCovenants[$j]["id"])
				$found = true;
		}
		if($found == true)
			$covenants[$i]["selected"] = "selected";
		else
			$covenants[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_geographic.php");
	$countries = getVisibleCountries();
	$myCountries = getCountriesByInitiative($datas[0]["id"]);
	for($i=0; $i<sizeof($countries); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myCountries); $j++) {
			if($countries[$i]["id"] == $myCountries[$j]["id"])
				$found = true;
		}
		if($found == true)
			$countries[$i]["selected"] = "selected";
		else
			$countries[$i]["selected"] = "";
	}

	$regions = array();
	for($i=0; $i<sizeof($myCountries); $i++) {
		$result = getVisibleRegionsByCountry($myCountries[$i]["id"]);
		$regions = array_merge($regions, $result);
	}
	$myRegions = getRegionsByInitiative($datas[0]["id"]);
	for($i=0; $i<sizeof($regions); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myRegions); $j++) {
			if($regions[$i]["id"] == $myRegions[$j]["id"])
				$found = true;
		}
		if($found == true)
			$regions[$i]["selected"] = "selected";
		else
			$regions[$i]["selected"] = "";
	}

	$communes = array();
	for($i=0; $i<sizeof($myRegions); $i++) {
		$result = getVisibleCommuneByRegion($myRegions[$i]["id"]);
		$communes = array_merge($communes, $result);
	}
	$myCommunes = getCommunesByInitiative($datas[0]["id"]);
	for($i=0; $i<sizeof($communes); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myCommunes); $j++) {
			if($communes[$i]["id"] == $myCommunes[$j]["id"])
				$found = true;
		}
		if($found == true)
			$communes[$i]["selected"] = "selected";
		else
			$communes[$i]["selected"] = "";
	}

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
      		<small>editar iniciativa</small>
    		</h1>
    		<ol class="breadcrumb">
					<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
					<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
      		<li class="active">Editar Iniciativa - Paso 1</li>
    		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?></h3>
						</div>
						<!-- /.box-header -->

						<div class="box-body">
							<div id="loader"></div><!-- Carga los datos ajax -->

    						<form class="form-horizontal" method="post" id="edit_initiative_step1" name="edit_initiative_step1">
								<?php echo "<input type='hidden' value='".$nombre_usuario."' id='vg_autor' name='vg_autor' />"; ?>
								<?php echo "<input type='hidden' value='".noeliaEncode($id)."' id='vg_id' name='vg_id' />"; ?>

								<div class="row">
									<div class="col-xs-12 col-md-10">
                		<label for="vg_nombre">Nombre de actividad <span class="text-red">*</span></label>
										<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
											placeholder="Nombre" maxlength="500" required value='<?php echo$datas[0]["nombre"];?>'>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_fecha_inicio">Fecha de inicio <span class="text-red">*</span></label>
                  	<input type="date" class="form-control" id="vg_fecha_inicio" name="vg_fecha_inicio"
											placeholder="Fecha de inicio" required value='<?php echo$datas[0]["fecha_inicio"];?>'>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_fecha_finalizacion">Fecha de finalización</label>
                  	<input type="date" class="form-control" id="vg_fecha_finalizacion" name="vg_fecha_finalizacion"
											placeholder="Fecha de finalización" value='<?php echo$datas[0]["fecha_finalizacion"];?>'>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_escuela">Unidad Institucional creadora <span class="text-red">*</span></label>
                  	<select class="selectpicker form-control" id="vg_escuela[]" name="vg_escuela[]"
											title="Unidad Institucional creadora" multiple required data-live-search="true">
											<?php
												if($collegeFound == true) {
													echo "<option value=''>No aplica para esta actividad</option>";
												} else {
													echo "<option value='' selected>No aplica para esta actividad</option>";
												}
												foreach($colleges as $college) {
													echo "<option value='" . $college['id'] . "' ".$college['selected'].">" . $college['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_sede">Sede </label>
                  	<select class="selectpicker form-control" id="vg_sede[]" name="vg_sede[]"
											title="Sede" multiple data-live-search="true">
											<?php
												if($campusFound == true) {
													echo "<option value=''>Nivel Central</option>";
												} else {
													echo "<option value='' selected>Nivel Central</option>";
												}
												foreach($campuses as $campus) {
													echo "<option value='" . $campus['id'] . "' ".$campus['selected'].">" . $campus['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_sede">Carrera </label>
                  	<select class="selectpicker form-control" id="vg_carrera[]" name="vg_carrera[]"
											title="Carrera" multiple data-live-search="true">
											<?php
												foreach($carrers as $carrer) {
													echo "<option value='" . $carrer['id'] . "' ".$carrer['selected'].">" . $carrer['nombre']. "</option>";
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-5">
                		<label for="vg_programa">Linea de acción <span class="text-red">*</span></label>
                		<select class="selectpicker form-control" id="vg_programa" name="vg_programa"
											title="Linea de acción" required data-live-search="true" onchange="selectProgram();">
										<?php
											foreach($programs as $program) {
												if($datas[0]["id_programa"] == $program['id']) {
													echo "<option value=" . $program['id'] ." selected>" . $program['nombre']. "</option>";
												} else {
													echo "<option value=" . $program['id'] .">" . $program['nombre']. "</option>";
												}
											}
										?>
										</select>
                  </div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_programa_secundario">¿Se relaciona con otra línea de acción?</label>
                		<select class="selectpicker form-control" id="vg_programa_secundario" name="vg_programa_secundario[]"
											title="¿Se relaciona con otra línea de acción?" multiple data-live-search="true">
											<?php
												if($programSecondaryFound == true) {
													echo "<option value=''>No</option>";
												} else {
													echo "<option value='' selected>No</option>";
												}
												foreach($programs_secondary as $program_secondary) {
													echo "<option value='" . $program_secondary['id'] . "' ".$program_secondary['selected'].">" . $program_secondary['nombre']. "</option>";
												}
											?>
										</select>
                  </div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_mecanismo">Tipo de acción <span class="text-red">*</span></label>
                  	<select class="selectpicker form-control" id="vg_mecanismo" name="vg_mecanismo"
											title="Tipo de acción" data-live-search="true" required>
											<?php
											foreach($mechanisms as $mechanism) {
												echo "<option value='" . $mechanism['id'] . "' ".$mechanism['selected'].">" . $mechanism['nombre']. "</option>";
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
													echo "<option value='" . $frecuency['id'] . "' ".$frecuency['selected'].">" . $frecuency['nombre']. "</option>";
												}
											?>
										</select>
                  </div>
									<div class="col-xs-6 col-md-4">
                		<label for="vg_formato_implementacion">Formato de implementación</label>
                  	<select class="selectpicker form-control" id="vg_formato_implementacion" name="vg_formato_implementacion"
											title="Formato de implementación" data-live-search="true">
											<?php
												foreach($implementationFormats as $implementationFormat) {
													if($datas[0]["formato_implementacion"] == $implementationFormat['nombre']) {
														echo "<option value='" . $implementationFormat['nombre'] . "' selected>" . $implementationFormat['nombre']. "</option>";
													} else {
														echo "<option value='" . $implementationFormat['nombre'] . "'>" . $implementationFormat['nombre']. "</option>";
													}
												}
											?>
										</select>
                	</div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_encargado">Nombre encargado responsable</label>
										<input type="text" class="form-control" id="vg_encargado" name="vg_encargado"
											placeholder="Nombre encargado responsable" maxlength="100" value='<?php echo$datas[0]["responsable"];?>'>
                  </div>
									<div class="col-xs-6 col-md-3">
                		<label for="vg_encargado_cargo">Cargo encargado responsable</label>
                  	<select class="selectpicker form-control" id="vg_encargado_cargo" name="vg_encargado_cargo"
											title="Cargo encargado responsable" data-live-search="true">
											<?php
												foreach($managerPositions as $managerPosition) {
													if($datas[0]["responsable_cargo"] == $managerPosition['nombre']) {
														echo "<option value='" . $managerPosition['nombre'] . "' selected>" . $managerPosition['nombre']. "</option>";
													} else {
														echo "<option value='" . $managerPosition['nombre'] . "'>" . $managerPosition['nombre']. "</option>";
													}
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
													echo "<option value='" . $covenant['id'] . "' ".$covenant['selected'].">" . $covenant['nombre']. "</option>";
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
											title="Región" data-live-search="true" multiple onchange="selectRegion();" data-container="body" data-actions-box="true">
											<?php
												foreach($regions as $region) {
													echo "<option value='" . $region['id'] . "' ".$region['selected'].">" . $region['nombre']. "</option>";
												}
											?>
										</select>
									</div>
									<div class="col-xs-6 col-md-4">
										<label for="vg_comuna">Comuna</label>
										<select class="selectpicker form-control" id="vg_comuna" name="vg_comuna[]"
											title="Comuna" data-live-search="true" multiple data-container="body" data-actions-box="true">
											<?php
												foreach($communes as $commune) {
													echo "<option value='" . $commune['id'] . "' ".$commune['selected'].">" . $commune['nombre']. "</option>";
												}
											?>
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
		//selectProgram();
		//selectCountry();
	});

	function selectProgram() {
		var parametros = $("#edit_initiative_step1").serialize();

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
		var parametros = $("#edit_initiative_step1").serialize();

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
		var parametros = $("#edit_initiative_step1").serialize();

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

	$("#edit_initiative_step1").submit(function( event ) {
		$('#edit_initiative_step1').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_initiative_step1.php",
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
