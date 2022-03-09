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

	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_initiatives.php");
	$datas = getInitiative($id);
	$datasEncode = noeliaEncode($datas[0]["id"]);

?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<style type="text/css">
		.filaColor {
  		background-color: #fff7ea
		}
  </style>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "initiatives";
		include_once("../include/menu_side.php");

		include_once("modal_initiative_approve.php");
		include_once("modal_initiative_decline.php");

		include_once("modal_calculate_invi.php");
	?>

  <!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
  	<!-- Content Header (Page header) -->
  	<section class="content-header">
  		<h1>
    		Iniciativas
    		<small>revisar iniciativa</small>
  		</h1>
  		<ol class="breadcrumb">
				<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
				<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
    		<li class="active">Revisar Iniciativa</li>
  		</ol>
  	</section>

		<!-- Main content -->
		<section class="invoice">
			<div id="loader"></div>

  		<!-- title row -->
  		<div class="row">
    		<div class="col-xs-12">
    			<h2 class="page-header">
      			<?php echo $datas[0]["nombre"]?>

						<div class="pull-right">

							<a class="btn btn-orange" valign="right" data-toggle="modal"
								data-iniciativa='<?php echo noeliaEncode($id);?>'
								data-usuario='<?php echo ($_SESSION["nombre_usuario"]);?>'
								data-target="#calculateScoreVCM">
									Calcular INVI</a>

							<?php
								$data = noeliaEncode("data" . $id);
							?>
							<?php
								if(canSuperviseInitiatives()) {	?>
									<a href="#" class='btn btn-orange' title='Aprobar iniciativa'
										data-toggle="modal" data-target="#approveInitiative">
										<i class="text-green fa fa-check"></i>
									</a>

									<a href="#" class='btn btn-orange' title='Rechazar iniciativa'
										data-toggle="modal" data-target="#declineInitiative">
										<i class="text-red fa fa-close"></i>
									</a>

									<!--a href="edit_initiative_step2.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar Iniciativa'>
										<i class="text-green fa fa-check"></i>
									</a>
									<a href="edit_initiative_step2.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar Iniciativa'>
										<i class="text-red fa fa-close"></i>
									</a-->
							<?php
								} ?>

							<?php
								if(canReadInitiatives()) {	?>
									<a href="print_initiative.php?data=<?php echo$data;?>" target="_blank" class='btn btn-orange' title='Imprimir Iniciativa'>
										<i class="fa fa-print"></i>
									</a>
									<a href="excel_initiative.php?data=<?php echo$data;?>" target="_blank" class='btn btn-orange' title='Exportar a Excel'>
										<i class="fa fa-file-excel-o"></i>
									</a>
							<?php
								} ?>

							<?php
								if(canUpdateInitiatives()) {	?>
									<a href="edit_initiative_step1.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar Iniciativa'>
										<i class="fa fa-edit"></i>
									</a>
							<?php
								} ?>

						</div>
      		</h2>
    		</div>
    		<!-- /.col -->
  		</div>

			<!-- Table row -->
  		<div class="row">
				<?php
					include_once("../../controller/medoo_initiatives_ods.php");
					$myObjetives = getODSByInitiative($datas[0]['id']);
					//$myMeasures = getVisibleMeasuresByInitiative($id_initiative);
					for($i=0 ; $i<sizeof($myObjetives) ; $i++) {
						$contadorMetas = 0;
						for($j=0 ; $j<sizeof($myMeasures) ; $j++) {
							if($myObjetives[$i]["id"] == $myMeasures[$j]["id_objetivo"]) {
								$contadorMetas++;
								//echo "<br>Meta -> " . $myMeasures[$j]["nombre"];
							}
						}
						$myObjetives[$i]["cantidad_metas"] = $contadorMetas;
						//echo "<br>IDS " . $myObjetives[$i]["id"] . " " . $myObjetives[$i]["nombre_largo"] . " -- " . $myObjetives[$i]["cantidad_metas"];
						//echo "<br>";
					}

					if(sizeof($myObjetives) > 0) {
						echo "<h4>Objetivos de Desarrollo Sostenible donde contribuye</h4>";
					}

					for($i=0 ; $i<sizeof($myObjetives) ; $i++) {
							$imagen = "../../img/ods-" . $myObjetives[$i]["id"] . ".png";
							$url = "../objetives/view_objetive.php?data=" . $data = noeliaEncode("data" . $myObjetives[$i]["id"]);
							?>
							<div class="col-md-2">
								<a href="<?php echo$url?>">
									<img id="viga_logo" class="img-responsive" src="<?php echo$imagen?>" alt="User profile picture" width="100%">
								</a>
							</div>
				<?php
					}
				?>
			</div>

  		<!-- Table row -->
  		<div class="row">
  			<div class="col-xs-12 table-responsive">
  				<table class="table table-condensed">
  					<tr class="filaColor">
      				<td style="width:250px"><b>Fecha de inicio:</b></td>
      				<td>
								<?php
									$thisDate = new DateTime($datas[0]["fecha_inicio"]);
									echo $thisDate->format('d-m-Y');
								?>
							</td>
      			</tr>
						<tr>
      				<td style="width:250px"><b>Fecha de finalización:</b></td>
      				<td>
								<?php
									$thisDate = new DateTime($datas[0]["fecha_finalizacion"]);
									echo $thisDate->format('d-m-Y');
								?>
							</td>
      			</tr>

						<?php
							include_once("../../controller/medoo_colleges.php");
							$myColleges = getCollegesByInitiative($datas[0]['id']);
						?>
						<tr class="filaColor">
      				<td><b>Unidad institucional</b></td>
							<?php
								$collegesText = "";
								for($j=0 ; $j<sizeof($myColleges) ; $j++) {
									$collegesText .= $myColleges[$j]["nombre"];
									if($j<(sizeof($myColleges)-1))
										$collegesText .= ", ";
								}
							?>
							<td><?php echo $collegesText;?></td>
      			</tr>
						<?php
							include_once("../../controller/medoo_campus.php");
							$myCampus = getCampusByInitiative($datas[0]['id']);
							//$myCoUnits = getCoexecutorUnitsByInitiative($datas[0]['id']);
						?>
						<tr>
      				<td><b>Sede</b></td>
							<?php
								$campusText = "";
								for($j=0 ; $j<sizeof($myCampus) ; $j++) {
									$campusText .= $myCampus[$j]["nombre"];
									if($j<(sizeof($myCampus)-1))
										$campusText .= ", ";
								}
							?>
							<td><?php echo $campusText;?></td>
      			</tr>

						<?php
							include_once("../../controller/medoo_carrers.php");
							$myCarrers = getCarrersByInitiative($datas[0]['id']);
							//$myCoUnits = getCoexecutorUnitsByInitiative($datas[0]['id']);
						?>
						<tr class="filaColor">
      				<td><b>Carrera</b></td>
							<?php
								$carrerText = "";
								for($j=0 ; $j<sizeof($myCarrers) ; $j++) {
									$carrerText .= $myCarrers[$j]["nombre"];
									if($j<(sizeof($myCarrers)-1))
										$carrerText .= ", ";
								}
							?>
							<td><?php echo $carrerText;?></td>
      			</tr>

						<?php
							include_once("../../controller/medoo_programs.php");
							$myProgram = getProgram($datas[0]["id_programa"]);
						?>
						<tr>
      				<td><b>Linea de acción</b></td>
							<td><?php echo $myProgram[0]["nombre"];?></td>
      			</tr>

						<?php
							$myProgramsSecondary = getProgramsByInitiative($datas[0]["id"]);
						?>
						<tr class="filaColor">
      				<td><b>Linea de acción relacionada</b></td>
							<?php
								$programSecondaryText = "";
								for($j=0 ; $j<sizeof($myProgramsSecondary) ; $j++) {
									$programSecondaryText .= $myProgramsSecondary[$j]["nombre"];
									if($j<(sizeof($myProgramsSecondary)-1))
										$programSecondaryText .= ", ";
								}
							?>
							<td><?php echo $programSecondaryText;?></td>
      			</tr>

						<?php
						 	if($myProgram[0]["id"] == 1) {?>
								<tr>
		      				<td><b>Carrera</b></td>
									<td><?php echo $datas[0]["as_carrera"]?></td>
		      			</tr>
								<tr class="filaColor">
		      				<td><b>Sección</b></td>
									<td><?php echo $datas[0]["as_seccion"]?></td>
		      			</tr>
								<tr>
		      				<td><b>Código del módulo</b></td>
									<td><?php echo $datas[0]["as_codigo_modulo"]?></td>
		      			</tr>
								<tr class="filaColor">
		      				<td><b>Docente a cargo</b></td>
									<td><?php echo $datas[0]["as_docente"]?></td>
		      			</tr>
						<?php
							} ?>

						<?php
							include_once("../../controller/medoo_invi_attributes.php");
							$mechanisms = getMechanism($datas[0]["id_mecanismo"]);
						?>
						<tr>
      				<td><b>Tipo de actividad</b></td>
							<td><?php echo $mechanisms[0]["nombre"]?></td>
      			</tr>

						<tr class="filaColor">
      				<td><b>Gestor de vínculo</b></td>
							<td><?php echo $datas[0]["gestor_vinculo"]?></td>
      			</tr>

						<tr>
      				<td><b>Nombre encargado responsable</b></td>
							<td><?php echo $datas[0]["responsable"]?></td>
      			</tr>

						<tr class="filaColor">
      				<td><b>Unidad encargado responsable</b></td>
							<td><?php echo $datas[0]["responsable_cargo"]?></td>
      			</tr>

						<tr>
      				<td><b>Formato de implementación</b></td>
							<td><?php echo $datas[0]["formato_implementacion"]?></td>
      			</tr>

						<?php
							$frecuencia = getFrecuency($datas[0]["id_frecuencia"]);
						?>
						<tr class="filaColor">
      				<td><b>Frecuencia</b></td>
							<td><?php echo $frecuencia[0]["nombre"]?></td>
      			</tr>

						<?php
							include_once("../../controller/medoo_geographic.php");
							$geoPaises = getCountriesByInitiative($datas[0]["id"]);
							$geoRegiones = getRegionsByInitiative($datas[0]["id"]);
							$geoComunas = getCommunesByInitiative($datas[0]["id"]);
						?>
						<tr>
      				<td><b>País</b></td>
							<?php
								$paisText = "";
								for($j=0 ; $j<sizeof($geoPaises) ; $j++) {
									$paisText .= $geoPaises[$j]["nombre"];
									if($j<(sizeof($geoPaises)-1))
										$paisText .= ", ";
								}
							?>
							<td><?php echo $paisText;?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Región</b></td>
							<?php
								$regionText = "";
								for($j=0 ; $j<sizeof($geoRegiones) ; $j++) {
									$regionText .= $geoRegiones[$j]["nombre"];
									if($j<(sizeof($geoRegiones)-1))
										$regionText .= ", ";
								}
							?>
							<td><?php echo $regionText;?></td>
      			</tr>
						<tr>
      				<td><b>Comuna</b></td>
							<?php
								$comunaText = "";
								for($j=0 ; $j<sizeof($geoComunas) ; $j++) {
									$comunaText .= $geoComunas[$j]["nombre"];
									if($j<(sizeof($geoComunas)-1))
										$comunaText .= ", ";
								}
							?>
							<td><?php echo $comunaText;?></td>
      			</tr>

						<?php
							include_once("../../controller/medoo_environment.php");
							$myEnvironments = getEnvironmentsByInitiative($datas[0]["id"]);
						?>
						<tr class="filaColor">
      				<td><b>Entorno significativo</b></td>
							<?php
								$environmentText = "";
								for($j=0 ; $j<sizeof($myEnvironments) ; $j++) {
									$environmentText .= $myEnvironments[$j]["nombre"];
									if($j<(sizeof($myEnvironments)-1))
										$environmentText .= ", ";
								}
							?>
							<td><?php echo $environmentText;?></td>
      			</tr>

						<tr>
      				<td><b>Nombre de instituciones</b></td>
							<td><?php echo $datas[0]["entorno_detalle"];?></td>
						</tr>

						<tr class="filaColor">
      				<td><b>Nombre de la iniciativa:</b></td>
      				<td><?php echo $datas[0]["nombre"]?></td>
      			</tr>

     				<tr>
      				<td><b>Objetivo</b></td>
      				<td><?php echo $datas[0]["objetivo"]?></td>
      			</tr>

						<tr class="filaColor">
      				<td><b>Descripción</b></td>
      				<td><?php echo $datas[0]["descripcion"]?></td>
      			</tr>

						<?php
							if(strpos($myProgram[0]["nombre"], "complementario") !== false) { ?>
								<tr>
		      				<td><b>Resultado esperado</b></td>
		      				<td><?php echo $datas[0]["resultado_esperado"]?></td>
		      			</tr>
						<?php
							} else { ?>
								<tr>
		      				<td><b>Impacto esperado</b></td>
		      				<td><?php echo $datas[0]["impacto_esperado"]?></td>
		      			</tr>

								<?php
									include_once("../../controller/medoo_impact_internal.php");
									$myInternalImpacts = getInternalImpactByInitiative($datas[0]["id"]);
								?>
								<tr class="filaColor">
		      				<td><b>Tipos de impacto interno</b></td>
									<?php
										$internalText = "";
										for($j=0 ; $j<sizeof($myInternalImpacts) ; $j++) {
											$internalText .= $myInternalImpacts[$j]["nombre"];
											if($j<(sizeof($myInternalImpacts)-1))
												$internalText .= ", ";
										}
									?>
									<td><?php echo $internalText;?></td>
		      			</tr>

								<tr>
		      				<td><b>Impacto esperado interno logrado</b></td>
		      				<td><?php echo $datas[0]["impacto_logrado_interno"]?></td>
		      			</tr>

								<?php
									include_once("../../controller/medoo_impact_external.php");
									$myExternalImpacts = getExternalImpactByInitiative($datas[0]["id"]);
								?>
								<tr class="filaColor">
		      				<td><b>Tipos de impacto externo</b></td>
									<?php
										$externalText = "";
										for($j=0 ; $j<sizeof($myExternalImpacts) ; $j++) {
											$externalText .= $myExternalImpacts[$j]["nombre"];
											if($j<(sizeof($myExternalImpacts)-1))
												$externalText .= ", ";
										}
									?>
									<td><?php echo $externalText;?></td>
		      			</tr>

								<tr>
		      				<td><b>Impacto esperado externo logrado</b></td>
		      				<td><?php echo $datas[0]["impacto_logrado_externo"]?></td>
		      			</tr>
						<?php
							} ?>

						<?php
							include_once("../../controller/medoo_participation_plan.php");
							$participation = getVisiblePlanParticipationByInitiative($datas[0]["id"]);

							$participationText = "";
							$totalParticipation = 0;
							$totalSexoHombres = 0;
							$totalSexoMujeres = 0;
							$totalSexoOtro = 0;

							$totalEdadNinos = 0;
							$totalEdadJovenes = 0;
							$totalEdadAdultos = 0;
							$totalEdadAdultosMayores = 0;

							$totalProcedenciaRural = 0;
							$totalProcedenciaUrbana = 0;

							$totalVulnerabilidadPueblo = 0;
							$totalVulnerabilidadDiscapacidad = 0;
							$totalVulnerabilidadPobreza = 0;
							for($i=0; $i<sizeof($participation); $i++) {
								if(strpos($participationText, $participation[$i]["tipo"]) == false) {
									$participationText .= $participation[$i]["tipo"];
									if($i<(sizeof($participation)-1))
										$participationText .= ", ";
								}

								$totalParticipation += intval($participation[$i]["publico_general"]);

								if($participation[$i]["aplica_sexo"] == "on") {
									$totalSexoHombres += intval($participation[$i]["sexo_masculino"]);
									$totalSexoMujeres += intval($participation[$i]["sexo_femenino"]);
									$totalSexoOtro += intval($participation[$i]["sexo_otro"]);
								}

								if($participation[$i]["aplica_edad"] == "on") {
									$totalEdadNinos += intval($participation[$i]["edad_ninos"]);
									$totalEdadJovenes += intval($participation[$i]["edad_jovenes"]);
									$totalEdadAdultos += intval($participation[$i]["edad_adultos"]);
									$totalEdadAdultosMayores += intval($participation[$i]["edad_adultos_mayores"]);
								}

								if($participation[$i]["aplica_procedencia"] == "on") {
									$totalProcedenciaRural += intval($participation[$i]["procedencia_rural"]);
									$totalProcedenciaUrbana += intval($participation[$i]["procedencia_urbano"]);
								}

								if($participation[$i]["aplica_vulnerabilidad"] == "on") {
									$totalVulnerabilidadPueblo += intval($participation[$i]["vulnerabilidad_pueblo"]);
									$totalVulnerabilidadDiscapacidad += intval($participation[$i]["vulnerabilidad_discapacidad"]);
									$totalVulnerabilidadPobreza += intval($participation[$i]["vulnerabilidad_pobreza"]);
								}
							}
						?>
						<tr class="filaColor">
      				<td><b>Tipo de asistente</b></td>
							<td><?php echo $participationText;?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de participantes esperados</b></td>
      				<td><?php echo $totalParticipation?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Cantidad de hombres</b></td>
      				<td><?php echo $totalSexoHombres?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de mujeres</b></td>
      				<td><?php echo $totalSexoMujeres?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Cantidad de otra condición sexual</b></td>
      				<td><?php echo $totalSexoOtro?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de niños</b></td>
      				<td><?php echo $totalEdadNinos?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Cantidad de jóvenes</b></td>
      				<td><?php echo $totalEdadJovenes?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de adultos</b></td>
      				<td><?php echo $totalEdadAdultos?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Cantidad de adultos mayores</b></td>
      				<td><?php echo $totalEdadAdultosMayores?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de procedencia rural</b></td>
      				<td><?php echo $totalProcedenciaRural?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Cantidad de procedencia urbana</b></td>
      				<td><?php echo $totalProcedenciaUrbana?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de personas pertenecientes a pueblos originarios</b></td>
      				<td><?php echo $totalVulnerabilidadPueblo?></td>
      			</tr>
						<tr class="filaColor">
      				<td><b>Cantidad de personas con discapacidad</b></td>
      				<td><?php echo $totalVulnerabilidadDiscapacidad?></td>
      			</tr>
						<tr>
      				<td><b>Cantidad de personas en situación de pobreza</b></td>
      				<td><?php echo $totalVulnerabilidadPobreza?></td>
      			</tr>

						<tr>
      				<td><b>Objetivos de Desarrollo Sostenible</b></td>
							<?php
								$objetivesText = "";
								for($j=0 ; $j<sizeof($myObjetives) ; $j++) {
									$objetivesText .= $myObjetives[$j]["nombre"];
									if($j<(sizeof($myObjetives)-1))
										$objetivesText .= ", ";
								}
							?>
							<td><?php echo $objetivesText;?></td>
      			</tr>

						<?php
							include_once("../../controller/medoo_invi.php");
							$inviResult = calculateInviByInitiative($datas[0]['id']);
						?>
						<tr class="filaColor">
      				<td><b>INVI</b></td>
							<td><?php echo $inviResult["invi"]["total"];?></td>
      			</tr>

						<tr>
      				<td><b>INVI - Tipo de actividad</b></td>
							<td><?php echo $inviResult["mecanismo"]["valor"];?></td>
      			</tr>

						<tr class="filaColor">
      				<td><b>INVI - Cobertura</b></td>
							<?php
								$cobertura = (0.3 * $inviResult["cobertura_territorialidad"]["valor"]) + (0.4 * $inviResult["cobertura_pertinencia"]["valor"]) + (0.3 * $inviResult["cobertura_cantidad"]["valor"]);
							?>
							<td><?php echo $cobertura;?></td>
      			</tr>

						<tr>
      				<td><b>INVI - Frecuencia</b></td>
							<td><?php echo $inviResult["frecuencia"]["valor"];?></td>
      			</tr>

						<tr class="filaColor">
      				<td><b>INVI - Evaluación</b></td>
							<td><?php echo $inviResult["evaluacion"]["valor"];?></td>
      			</tr>

   				</table>
   			</div>
   		</div>
		</section>
  </div>
  <!-- /.content-wrapper -->

  <?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>
	$(document).ready(function(){
		//var iniciativa = '<?php echo$id;?>';
		loadODS();
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

	$("#approve_initiative").submit(function( event ) {
		$('#approve_initiative').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_initiative_approve.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$('#approveInitiative').modal('hide');
				$("#loader").html(datos);
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$("#decline_initiative").submit(function( event ) {
		$('#decline_initiative').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_initiative_decline.php",
			data: parametros,
			beforeSend: function(objeto) {
				$('#declineInitiative').modal('hide');
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

	/*
	function loadODS() {
		var parametros = {
			"id_initiative" : '<?php echo$datasEncode;?>'
    };

		$.ajax({
			type: "POST",
        url:'./ajax_load_ods.php',
        data:  parametros,
        beforeSend: function () {
            $("#load_ods").html("Obteniendo información, espere por favor.");
        },
        success:  function (response) {
            $("#load_ods").html(response);

            $('#table').DataTable({
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
					$("#load_ods").html(response);
				}
      });
	}
	*/
</script>

</body>
</html>
