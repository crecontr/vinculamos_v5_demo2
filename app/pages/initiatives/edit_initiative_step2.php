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
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_initiatives.php");
	$datas = getInitiative($id);
	$dataEncoded = noeliaEncode("data" . $datas[0]['id']);

	include_once("../../controller/medoo_programs.php");
	$programa = getProgram($datas[0]["id_programa"]);

	include_once("../../controller/medoo_environment.php");
	$environments = getVisibleEnvironments();
	$myEnvironments = getEnvironmentsByInitiative($datas[0]["id"]);
	for($i=0; $i<sizeof($environments); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myEnvironments); $j++) {
			if($environments[$i]["id"] == $myEnvironments[$j]["id"])
				$found = true;
		}
		if($found == true)
			$environments[$i]["selected"] = "selected";
		else
			$environments[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_environment_sub.php");
	$environments_sub = array();
	for($i=0; $i<sizeof($myEnvironments); $i++) {
		$result = getVisibleEnvironmentsSubByEnvironment($myEnvironments[$i]["id"]);
		$environments_sub = array_merge($environments_sub, $result);
	}
	$myEnvironmentsSubs = getEnvironmentsSubsByInitiative($datas[0]["id"]);
	for($i=0; $i<sizeof($environments_sub); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myEnvironmentsSubs); $j++) {
			if($environments_sub[$i]["id"] == $myEnvironmentsSubs[$j]["id"])
				$found = true;
		}
		if($found == true)
			$environments_sub[$i]["selected"] = "selected";
		else
			$environments_sub[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_impact_internal.php");
	$myInternalImpacts = getInternalImpactByInitiative($datas[0]["id"]);

	include_once("../../controller/medoo_attributes.php");
	$internalImpactTypes = getVisibleInternalImpactTypes();
	for($i=0; $i<sizeof($internalImpactTypes); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myInternalImpacts); $j++) {
			if($internalImpactTypes[$i]["id"] == $myInternalImpacts[$j]["id"])
				$found = true;
		}
		if($found == true)
			$internalImpactTypes[$i]["selected"] = "selected";
		else
			$internalImpactTypes[$i]["selected"] = "";
	}

	include_once("../../controller/medoo_impact_external.php");
	$myExternalImpacts = getExternalImpactByInitiative($datas[0]["id"]);

	$externalImpactTypes = getVisibleExternalImpactTypes();
	for($i=0; $i<sizeof($externalImpactTypes); $i++) {
		$found = false;
		for($j=0; $j<sizeof($myExternalImpacts); $j++) {
			if($externalImpactTypes[$i]["id"] == $myExternalImpacts[$j]["id"])
				$found = true;
		}
		if($found == true)
			$externalImpactTypes[$i]["selected"] = "selected";
		else
			$externalImpactTypes[$i]["selected"] = "";
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
      		<li class="active">Editar Iniciativa - Paso 2</li>
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

	    					<form class="form-horizontal" method="post" id="edit_initiative_step2" name="edit_initiative_step2">
									<?php echo "<input type='hidden' value='".$nombre_usuario."' id='vg_usuario' name='vg_usuario' />"; ?>
									<?php echo "<input type='hidden' value='".base64_encode($id)."' id='vg_id' name='vg_id' />"; ?>
									<div class="row">
										<div class="col-md-3">
											<div>
												<label for="fa_nombre">Entorno relevante <span class="text-red">*</span></label>
												<select class="selectpicker form-control" id="vg_entorno" name="vg_entorno[]"
													title="Entorno relevante" multiple required data-live-search="true" onchange="selectEnvironment();">
													<?php
														foreach($environments as $environment) {
															echo "<option value='" . $environment['id'] . "' ".$environment['selected'].">" . $environment['nombre']. "</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-xs-6 col-md-3">
	                		<label for="vg_entorno_sub">Sub entorno relevante </label>
											<select class="selectpicker form-control" id="vg_entorno_sub" name="vg_entorno_sub[]"
												title="Sub entorno relevante" data-live-search="true" multiple>
												<?php
													foreach($environments_sub as $environment_sub) {
														echo "<option value='" . $environment_sub['id'] . "' ".$environment_sub['selected'].">" . $environment_sub['nombre']. "</option>";
													}
												?>
											</select>
	                  </div>
										<div class="col-md-6">
	                		<label for="vg_nombre">Nombre de organizaciones vinculadas</label>
											<input type="text" class="form-control" id="vg_entorno_detalle" name="vg_entorno_detalle"
												placeholder="Nombre de organizaciones vinculadas" maxlength="200" value='<?php echo$datas[0]["entorno_detalle"];?>'>
	                	</div>
									</div>

									<div class="row">
										<?php
											if(strpos($programa[0]["nombre"], "complementario") !== false) { ?>
												<div class="col-md-6">
			                		<label for="vg_objetivo">Objetivo <span class="text-blue">* Tibutación a ODS</span></label>
			                  	<textarea class="form-control textarea" placeholder="Objetivo" id="vg_objetivo" name="vg_objetivo" minlength=0
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["objetivo"];?></textarea>
			                	</div>
												<div class="col-md-6">
			                		<label for="vg_descripcion">Descripción</label>
			                  	<textarea class="form-control textarea" placeholder="Descripción" id="vg_descripcion" name="vg_descripcion" minlength=0
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["descripcion"];?></textarea>
			                	</div>
												<div class="col-md-6">
			                		<label for="vg_resultado_esperado">Resultados esperados</label>
			                  	<textarea class="form-control textarea" placeholder="Resultados Esperados" id="vg_resultado_esperado" name="vg_resultado_esperado" minlength=0
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["resultado_esperado"];?></textarea>
			                	</div>
										<?php
											} else { ?>
												<div class="col-md-6">
			                		<label for="vg_objetivo">Objetivo de la actividad (desafío identificado) <span class="text-blue">* Tributación a ODS</span></label>
			                  	<textarea class="form-control textarea" placeholder="Objetivo de la actividad (desafío identificado)" id="vg_objetivo" name="vg_objetivo" minlength=0
														title="Objetivo de la actividad (desafío identificado)"
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["objetivo"];?></textarea>
			                	</div>
												<div class="col-md-6">
			                		<label for="vg_descripcion">Descripción de la actividad (¿Qué se hará para lograr el objetivo?) <span class="text-blue">* Tributación a ODS</span></label>
			                  	<textarea class="form-control textarea" placeholder="Descripción de la actividad (¿Qué se hará para lograr el objetivo?)" id="vg_descripcion" name="vg_descripcion"
														title="Descripción de la actividad (¿Qué se hará para lograr el objetivo?)" minlength=0
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["descripcion"];?></textarea>
			                	</div>
												<div class="col-md-6">
			                		<label for="vg_resultado_esperado">Resultado esperado <span class="text-blue">* Tributación a ODS</span></label>
			                  	<textarea class="form-control textarea" placeholder="Resultados Esperados" id="vg_resultado_esperado" name="vg_resultado_esperado" minlength=0
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["resultado_esperado"];?></textarea>
			                	</div>
												<div class="col-md-6">
			                		<label for="vg_resultado_esperado">Impacto esperado asociado a la actividad<span class="text-blue">* Tributación a ODS</span></label>
			                  	<textarea class="form-control textarea" placeholder="Impacto esperado asociado a la actividad" id="vg_impacto_esperado" name="vg_impacto_esperado" minlength=0
														style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["impacto_esperado"];?></textarea>
			                	</div>
												<div class="col-md-12">
			                		<label for="vg_tipo_impacto_interno">Impacto interno asociado a la política</label>
			                  	<select class="selectpicker form-control" id="vg_tipo_impacto_interno[]" name="vg_tipo_impacto_interno[]"
														title="Tipo de impacto interno" multiple data-live-search="true">
														<?php
														foreach($internalImpactTypes as $internalImpactType) {
															echo "<option value='" . $internalImpactType['id'] . "' ".$internalImpactType['selected'].">" . $internalImpactType['nombre']. "</option>";
														}
														?>
													</select>
			                	</div>
												<!--div class="col-md-12">
			                		<textarea class="form-control textarea" placeholder="¿Cómo logrará el impacto interno?" id="vg_impacto_interno" name="vg_impacto_interno" minlength=0
														style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["impacto_logrado_interno"];?></textarea>
			                	</div-->

												<div class="col-md-12">
			                		<label for="vg_tipo_impacto_externo">Impacto externo asociado a la política</label>
			                  	<select class="selectpicker form-control" id="vg_tipo_impacto_externo[]" name="vg_tipo_impacto_externo[]"
														title="Tipo de impacto externo" multiple data-live-search="true">
														<?php
														foreach($externalImpactTypes as $externalImpactType) {
															echo "<option value='" . $externalImpactType['id'] . "' ".$externalImpactType['selected'].">" . $externalImpactType['nombre']. "</option>";
														}
														?>
													</select>
			                	</div>
												<!--div class="col-md-12">
			                		<textarea class="form-control textarea" placeholder="¿Cómo logrará el impacto externo?" id="vg_impacto_externo" name="vg_impacto_externo" minlength=0
														style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["impacto_logrado_externo"];?></textarea>
			                	</div-->
										<?php
											} ?>

									</div>

									<br>
									<div class="modal-footer">
										<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
										<a href="edit_initiative_step1.php?data=<?php echo$dataEncoded;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-left"></i> Volver al paso anterior</a>
										<button type="submit" class="btn btn-orange"><i class="fa fa-fw fa-save"></i><i class="fa fa-fw fa-chevron-right"></i> Siguiente</button>
									</div>

								</form>

								<hr style="height: 2px; border: 0;" class="btn-orange"/>


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

	});

	function selectEnvironment() {
		var parametros = $("#edit_initiative_step2").serialize();

		$.ajax({
			type: "POST",
      url:'../json/json_environment_subs.php',
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

      	$("#vg_entorno_sub")
			   .html(options)
			   .selectpicker('refresh');
      },
			error: function() {
				$("#loader").html(response);
			}
		});

	}

	$("#edit_initiative_step2").submit(function( event ) {
		$('#edit_initiative_step2').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_initiative_step2.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				sleep(1000).then(() => {
					var data =  "<?php echo$dataEncoded?>";
     			window.location.href = "./edit_initiative_step3.php?data=" + data;
				});
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	const sleep = (milliseconds) => {
	  return new Promise(resolve => setTimeout(resolve, milliseconds))
	}
</script>

</body>
</html>
