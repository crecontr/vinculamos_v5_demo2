<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../app/utils/user_utils.php");
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../app/controller/medoo_evaluation.php");
	$evaluation = getEvaluationById($id);

	include_once("../app/controller/medoo_initiatives.php");
	$initiative = getInitiative($evaluation[0]["id_iniciativa"]);

	include_once("../app/controller/medoo_evaluation_types_config.php");
	$evaluatorTypeConfig = getEvaluationTypesConfigByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_evaluation_knowledge_ori_questions.php");
	$OriKnowledgeQuestions = getKnowledgeOriQuestionByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_evaluation_compliance_ori_questions.php");
	$OriComplianceQuestions = getComplianceOriQuestionByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_impact_internal.php");
	$myInternalImpacts = getInternalImpactByInitiative($initiative[0]["id"]);

	include_once("../app/controller/medoo_impact_external.php");
	$myExternalImpacts = getExternalImpactByInitiative($initiative[0]["id"]);

	include_once("../app/controller/medoo_evaluation_competence_questions.php");
	$competenceQuestions = getCompetenceQuestionByType(utf8_encode($evaluation[0]["tipo_evaluacion"]));

	include_once("../app/controller/medoo_evaluation_promises.php");
	$promises = getEvaluationPromises();

	include_once("../app/controller/medoo_programs.php");
	$program = getProgram($initiative[0]["id_programa"]);

	//include_once("../app/controller/medoo_survey_question.php");
	//$preguntas = getVisibleQuestionsBySurvey($evaluation[0]["id"]);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<title>Vinculamos</title>
	  	<!-- Tell the browser to be responsive to screen width -->
	  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  	<!-- Bootstrap 3.3.7 -->
	  	<link rel="stylesheet" href="../template/bower_components/bootstrap/dist/css/bootstrap.min.css">
	  	<!-- Font Awesome -->
	  	<link rel="stylesheet" href="../template/bower_components/font-awesome/css/font-awesome.min.css">
	  	<!-- Ionicons -->
	  	<link rel="stylesheet" href="../template/bower_components/Ionicons/css/ionicons.min.css">
	  	<!-- DataTables -->
	  	<link rel="stylesheet" href="../template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	  	<!-- Theme style -->
	  	<link rel="stylesheet" href="../template/dist/css/AdminLTE.css">
	  	<!-- AdminLTE Skins. Choose a skin from the css/skins
	       folder instead of downloading all of them to reduce the load. -->
	  	<link rel="stylesheet" href="../template/dist/css/skins/_all-skins.css">

			<!-- Google Font -->
	  	<link rel="stylesheet"
	        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>


	<body class="hold-transition skin-green layout-top-nav">
		<div class="wrapper">

			<header class="main-header">
		    <nav class="navbar navbar-static-top">
		      <div class="container">
		        <div class="navbar-header">
		          <a href="#" class="navbar-brand"><b>Vinculamos</b></a>
		        </div>
		        <!-- /.navbar-custom-menu -->
		      </div>
		      <!-- /.container-fluid -->
		    </nav>
		  </header>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
		    	<!-- Content Header (Page header) -->
		    	<section class="content-header">
	      		<h1>
	        		<?php echo "Evaluación";?>
	        	</h1>
		    	</section>

		    	<!-- Main content -->
					<section class="content">
						<div class="row">
							<div class="col-xs-2">
							</div>
							<div class="col-xs-8">
								<div class="box">
									<div class="box-body">
										<h2 class="box-title"><?php echo $initiative[0]["nombre"];?></h1>
										<?php
											$nombreTipoEvaluador = ("<strong>" . $evaluation[0]["tipo_evaluacion"] . "</strong>");
											$nombreIniciativa = ("<strong>" . $initiative[0]["nombre"] . "</strong>");
											$nombreFechaDesde = ("<strong>" . $initiative[0]["fecha_inicio"] . "</strong>");
											$nombreFechaHasta = ("<strong>" . $initiative[0]["fecha_finalizacion"] . "</strong>");
											$nombrePrograma = ("" . $program[0]["nombre"] . "");

										?>
										<p class="box-title" style="font-size:15px;">
											<div class="col-md-12 text-center">
												<img src='https://i0.wp.com/www.cftsanagustin.cl/wp-content/uploads/2018/11/logohead2x-e1542812192261.png?w=327&ssl=1' width='200px'>
											</div>
											<br>

											Estimado/a,
											<br>
											En el marco de las actividades que el CFT San Agustín desarrolla en su línea de acción "<?php echo$nombrePrograma?>",
											hemos realizado la actividad denominada <?php echo$nombreIniciativa?>, en la cual le agradecemos haber participado.
											<br>
											Con el propósito de continuar mejorando nuestro trabajo, le pedimos que responda la siguiente encuesta, que nos permitirá evaluar esta actividad.
											<br>
											Saluda atentamente a usted.
											<br><br>
											<strong>CFT San Agustín</strong>
										</p>
										<p>
											<span class="text-red">* Obligatorio</span>
										</p>
									</div>
								</div>
								<div class="box">
									<div class="box-body">


										<div class="modal-body">
											<form class="form-horizontal" method="post" id="answer" name="answer">
												<?php echo "<input type='hidden' value='".noeliaEncode($evaluation[0]["id"])."' id='vg_data' name='vg_data' />"; ?>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> Correo electrónico <span class="text-red">*</span></label>
													<div class="text-center col-sm-3"></div>
													<div class="text-center col-sm-6">
														<input type="email" class="form-control" id="vg_correo" name="vg_correo"
															placeholder="Correo electrónico" maxlength="100" required>
													</div>
													<div class="text-center col-sm-4"></div>
												</div>

												<div class="row">

													<?php
													 	for ($i=0; $i < sizeof($evaluatorTypeConfig); $i++) {
															switch ($evaluatorTypeConfig[$i]["clave"]) {
																case 'CONOCIMIENTO_ORI': ?>
																	<div class="col-md-12">
																		<h5>CONOCIMIENTO DE LA INICIATIVA</h5>
																		<table id="tableOriQuestion" class="table table-bordered table-hover">
																			<thead>
																				<tr>
																					<th width="40%"><?php echo $OriKnowledgeQuestions[0]["texto"];?></th>
																					<th width="20%">¿Sí o No? <span class="text-red">*</span></th>
																					<th width="40%"><?php echo $OriComplianceQuestions[0]["texto"];?> <span class="text-red">*</span></th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																					<td><?php echo $initiative[0]["objetivo"];?></td>
																					<td>
																						<input type="radio" id="CONOCIMIENTO_O" name="CONOCIMIENTO_O" value="100" required> Si &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CONOCIMIENTO_O" name="CONOCIMIENTO_O" value="0" required> No</td>
																					<td>
																						<input type="radio" id="CUMPLIMIENTO_O" name="CUMPLIMIENTO_O" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_O" name="CUMPLIMIENTO_O" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_O" name="CUMPLIMIENTO_O" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_O" name="CUMPLIMIENTO_O" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_O" name="CUMPLIMIENTO_O" value="100" required> 100%
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>

																	<div class="col-md-12">
																		<table id="tableOriQuestion" class="table table-bordered table-hover">
																			<thead>
																				<tr>
																					<th width="40%"><?php echo $OriKnowledgeQuestions[1]["texto"];?></th>
																					<th width="20%">¿Sí o No? <span class="text-red">*</span></th>
																					<th width="40%"><?php echo $OriComplianceQuestions[1]["texto"];?> <span class="text-red">*</span></th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																					<td><?php echo $initiative[0]["resultado_esperado"];?></td>
																					<td>
																						<input type="radio" id="CONOCIMIENTO_R" name="CONOCIMIENTO_R" value="100" required> Si &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CONOCIMIENTO_R" name="CONOCIMIENTO_R" value="0" required> No</td>
																					<td>
																						<input type="radio" id="CUMPLIMIENTO_R" name="CUMPLIMIENTO_R" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_R" name="CUMPLIMIENTO_R" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_R" name="CUMPLIMIENTO_R" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_R" name="CUMPLIMIENTO_R" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_R" name="CUMPLIMIENTO_R" value="100" required> 100%
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>

																	<div class="col-md-12">
																		<table id="tableOriQuestion" class="table table-bordered table-hover">
																			<thead>
																				<tr>
																					<th width="40%"><?php echo $OriKnowledgeQuestions[2]["texto"];?></th>
																					<th width="20%">¿Sí o No?</th>
																					<th width="40%"><?php echo $OriComplianceQuestions[2]["texto"];?></th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																					<td><?php echo $initiative[0]["impacto_esperado"];?></td>
																					<td>
																						<input type="radio" id="CONOCIMIENTO_I" name="CONOCIMIENTO_I" value="100" required> Si &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CONOCIMIENTO_I" name="CONOCIMIENTO_I" value="0" required> No</td>
																					<td>
																						<input type="radio" id="CUMPLIMIENTO_I" name="CUMPLIMIENTO_I" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_I" name="CUMPLIMIENTO_I" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_I" name="CUMPLIMIENTO_I" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_I" name="CUMPLIMIENTO_I" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																						<input type="radio" id="CUMPLIMIENTO_I" name="CUMPLIMIENTO_I" value="100" required> 100%
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>

																	<!--div class="col-md-12">
																		<table id="tableOriQuestion" class="table table-bordered table-hover">
																			<thead>
																				<tr>
																					<th width="40%"><?php echo $OriKnowledgeQuestions[2]["texto"];?></th>
																					<th width="20%">¿Sí o No? <span class="text-red">*</span></th>
																					<th width="40%"><?php echo $OriComplianceQuestions[2]["texto"];?> <span class="text-red">*</span></th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				 	for ($j=0; $j < sizeof($myInternalImpacts); $j++) { ?>
																						<tr>
																							<td><?php echo $myInternalImpacts[$j]['nombre'];?></td>
																							<td>
																								<input type="radio" id="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="100" required> Si &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="0" required> No &nbsp;&nbsp;&nbsp;
																							</td>
																							<td>
																								<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_II_<?php echo$myInternalImpacts[$j]['id'];?>" value="100" required> 100%
																							</td>
																						</tr>
																				<?php
																				 	}?>

																				<?php
																				 	for ($j=0; $j < sizeof($myExternalImpacts); $j++) { ?>
																						<tr>
																							<td><?php echo $myExternalImpacts[$j]['nombre'];?></td>
																							<td>
																								<input type="radio" id="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="100" required> Si &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CONOCIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="0" required> No &nbsp;&nbsp;&nbsp;
																							</td>
																							<td>
																								<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="0" required> 0% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="25" required> 25% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="50" required> 50% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="75" required> 75% &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" name="CUMPLIMIENTO_IE_<?php echo$myExternalImpacts[$j]['id'];?>" value="100" required> 100%
																							</td>
																						</tr>
																				<?php
																				 	}?>
																			</tbody>
																		</table>
																	</div-->
																<?php
																	break;
																case 'CUMPLIMIENTO_ORI':
																	// code...
																	break;

																case 'CALIDAD_EJECUCION': ?>
																	<div class="col-md-12">
																		<h5>CALIDAD DE LA EJECUCIÓN</h5>
																		<p>
																			A continuación le pedimos que evalúe de 0 a 3 la calidad en la ejecución de la actividad,
																			según los compromisos asumidos por CFT San Agustín, en que 0= no cumple, 1= cumple mínimamente;
																			2= cumple medianamente y 3= cumple totalmente lo comprometido.
																			<br>
																			Si considera que algunos ítemes no estaban comprometidos, marque No Aplica.
																		</p>

																		<table id="tableOriQuestion" class="table table-bordered table-hover">
																			<thead>
																				<tr>
																					<th width="45%">Con qué nota evalúa usted la calidad en la ejecución de la actividad, en las siguientes dimensiones:</th>
																					<th width="45%">Cumplimiento <span class="text-red">*</span></th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																				 	for ($j=0; $j < sizeof($promises); $j++) { ?>
																						<tr>
																							<td><?php echo $promises[$j]['nombre'];?></td>
																							<td>
																								<input type="radio" id="COMPROMISO_<?php echo$promises[$j]['id'];?>" name="COMPROMISO_<?php echo$promises[$j]['id'];?>" value="0" required> 0 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPROMISO_<?php echo$promises[$j]['id'];?>" name="COMPROMISO_<?php echo$promises[$j]['id'];?>" value="1" required> 1 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPROMISO_<?php echo$promises[$j]['id'];?>" name="COMPROMISO_<?php echo$promises[$j]['id'];?>" value="2" required> 2 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPROMISO_<?php echo$promises[$j]['id'];?>" name="COMPROMISO_<?php echo$promises[$j]['id'];?>" value="3" required> 3 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPROMISO_<?php echo$promises[$j]['id'];?>" name="COMPROMISO_<?php echo$promises[$j]['id'];?>" value="" required> No Aplica
																							</td>
																						</tr>
																				<?php
																				 	}?>
																			</tbody>
																		</table>
																	</div>

																<?php
																	break;

																case 'APORTE_COMPETENCIAS': ?>
																	<div class="col-md-12">
																		<h5>COMPETENCIA DE ESTUDIANTES</h5>
																		<p>
																			Le pedimos a continuación que evalúe de 0 a 3, competencia para la ejecución de él o los estudiantes,
																			en que 0= dimensión desarrollada; 1= mínimamente desarrollada; 2= medianamente desarrollada y
																			3= completamente desarrollada.
																			<br>
																			Si considera que alguna de las dimensiones no pudo observarlas, marque No Aplica.
																		</p>

																		<table id="tableOriQuestion" class="table table-bordered table-hover">
																			<thead>
																				<tr>
																					<th width="45%"><?php echo$competenceQuestions[0]["texto"]?></th>
																					<th width="45%">Cumplimiento</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																					$competeneces = array();
																					$competeneces[] = "Capacidad para ejecutar las actividades.";
																					$competeneces[] = "Actitud positiva para ejecutar actividades.";
																					$competeneces[] = "Habilidad para resolver problemas";
																					for ($j=0; $j < sizeof($competeneces); $j++) { ?>
																						<tr>
																							<td><?php echo $competeneces[$j];?></td>
																							<td>
																								<input type="radio" id="COMPETENCIA_<?php echo($j+1);?>" name="COMPETENCIA_<?php echo($j+1);?>" value="0" required> 0 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPETENCIA_<?php echo($j+1);?>" name="COMPETENCIA_<?php echo($j+1);?>" value="1" required> 1 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPETENCIA_<?php echo($j+1);?>" name="COMPETENCIA_<?php echo($j+1);?>" value="2" required> 2 &nbsp;&nbsp;&nbsp;
																								<input type="radio" id="COMPETENCIA_<?php echo($j+1);?>" name="COMPETENCIA_<?php echo($j+1);?>" value="3" required> 3 &nbsp;&nbsp;&nbsp;
																							</td>
																						</tr>
																				<?php
																					}?>
																			</tbody>
																		</table>
																	</div>
																<?php
																	break;
																default:
																	// code...
																	break;
															}?>

													<?php
													 	}?>

												</div>

												<div id="loader"></div><!-- Carga los datos ajax -->

												<div class="form-group text-center">
													<button type="submit" class="btn btn-orange"> <i class="fa fa-send"></i> Responder</button>
												</div>
											</form>
										</div>

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

				<footer class="main-footer">
					<div class="pull-right hidden-xs">
						<b>Version 4.0-beta</b> <?php echo $currentVersion;?>
					</div>
				    <strong>Copyright &copy; 2019 <a href="http://www.vinculamos.cl/">Vinculamos</a>.</strong> Todos los derechos reservados.
				</footer>

				<!-- jQuery 3 -->
				<script src="../template/bower_components/jquery/dist/jquery.min.js"></script>
				<!-- Bootstrap 3.3.7 -->
				<script src="../template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
				<!-- DataTables -->
				<script src="../template/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
				<script src="../template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
				<!-- SlimScroll -->
				<script src="../template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
				<!-- FastClick -->
				<script src="../template/bower_components/fastclick/lib/fastclick.js"></script>
				<!-- AdminLTE App -->
				<script src="../template/dist/js/adminlte.min.js"></script>
				<!-- AdminLTE for demo purposes -->
				<script src="../template/dist/js/demo.js"></script>
				<!-- page script -->
		</div>
		<!-- ./wrapper -->

<script>
	$("#answer").submit(function( event ) {
		$('#answer').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_answer_evaluation.php",
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
