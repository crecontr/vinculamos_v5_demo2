<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../../utils/user_utils.php");
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_survey.php");
	$encuesta = getSurvey($id);

	include_once("../../controller/medoo_initiatives.php");
	$iniciativa = getInitiative($encuesta[0]["id_iniciativa"]);

	include_once("../../controller/medoo_survey_question.php");
	$preguntas = getVisibleQuestionsBySurvey($encuesta[0]["id"]);

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
	  	<link rel="stylesheet" href="../../../template/bower_components/bootstrap/dist/css/bootstrap.min.css">
	  	<!-- Font Awesome -->
	  	<link rel="stylesheet" href="../../../template/bower_components/font-awesome/css/font-awesome.min.css">
	  	<!-- Ionicons -->
	  	<link rel="stylesheet" href="../../../template/bower_components/Ionicons/css/ionicons.min.css">
	  	<!-- DataTables -->
	  	<link rel="stylesheet" href="../../../template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	  	<!-- Theme style -->
	  	<link rel="stylesheet" href="../../../template/dist/css/AdminLTE.css">
	  	<!-- AdminLTE Skins. Choose a skin from the css/skins
	       folder instead of downloading all of them to reduce the load. -->
	  	<link rel="stylesheet" href="../../../template/dist/css/skins/_all-skins.css">

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
	        		<?php echo $iniciativa[0]["nombre"];?>
	        	</h1>
		    	</section>

		    	<!-- Main content -->
					<section class="content">
						<div class="row">
							<div class="col-xs-0 col-md-2">
							</div>
							<div class="col-xs-12 col-md-8">
								<div class="box">
									<div class="box-body">
										<div class="col-md-12 text-center">
											<img src='http://demo2.vinculamosvm01.cl/vinculamos_v5_demo2/app/img/logo_texto.png' width='200px'>
											<br>
										</div>

										<h2 class="box-title"><?php echo $encuesta[0]["titulo"];?></h1>
										<p class="box-title" style="font-size:15px;"><?php echo str_replace("\n", "<br>", $encuesta[0]["descripcion"]);?></p>
										<p><span class="text-red">* Obligatorio</span></p>
									</div>
								</div>
								<div class="box">
									<div class="box-body">
										<div id="loader"></div><!-- Carga los datos ajax -->

										<div class="modal-body">
											<form class="form-horizontal" method="post" id="answer" name="answer">
												<?php echo "<input type='hidden' value='".noeliaEncode($encuesta[0]["id"])."' id='vg_data' name='vg_data' />"; ?>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> Correo electrónico</label>
													<div class="text-center col-sm-3"></div>
													<div class="text-center col-sm-6">
														<input type="email" class="form-control" id="vg_correo" name="vg_correo"
															placeholder="Correo electrónico" maxlength="100" required>
													</div>
													<div class="text-center col-sm-3"></div>
												</div>

												<?php
												 	for ($i=0; $i < sizeof($preguntas); $i++) {
														$idPregunta = ("vg_pregunta_" . $preguntas[$i]["id"]);
														if($preguntas[$i]["tipo_respuesta"] == "Si o No") { ?>

															<div class="row">
																<div class="form-group text-center">
																	<label id="mensaje" class="col-sm-12 col-md-12"> <?php echo$preguntas[$i]["titulo"]?></label>
																	<div class="row col-md-12">
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="Si" required> Si &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="No" required> No
																	</div>
																</div>
															<div class="row">

													<?php
														}

														if($preguntas[$i]["tipo_respuesta"] == "Escala 1 a 7") { ?>

															<div class="row">
																<div class="form-group text-center">
																	<label id="mensaje" class="col-sm-12 col-md-12"> <?php echo$preguntas[$i]["titulo"]?></label>
																	<div class="row col-md-12">
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="-" required> No Aplica &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="1" required> 1 &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="2" required> 2 &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="3" required> 3 &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="4" required> 4 &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="5" required> 5 &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="6" required> 6 &nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="7" required> 7 &nbsp;&nbsp;&nbsp;
																	</div>
																</div>
															</div>

													<?php
														}

														if($preguntas[$i]["tipo_respuesta"] == "Caritas 1 a 5") { ?>

															<div class="row">
																<div class="form-group text-center">
																	<label id="mensaje" class="col-sm-12 col-md-12"> <?php echo$preguntas[$i]["titulo"]?></label>
																	<div class="row col-md-12">
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="-" required> No aplica <img src="../../img/icono0.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="1" required> 1 <img src="../../img/icono1.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="2" required> 2 <img src="../../img/icono2.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="3" required> 3 <img src="../../img/icono3.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="4" required> 4 <img src="../../img/icono4.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<input type="radio" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" value="5" required> 5 <img src="../../img/icono5.png"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	</div>
																</div>
															</div>

													<?php
														}

														if($preguntas[$i]["tipo_respuesta"] == "Area de Texto") { ?>

															<div class="row">
																<div class="form-group text-center">
																	<label id="mensaje" class="col-sm-12 col-md-12"> <?php echo$preguntas[$i]["titulo"]?></label>
																	<div class="text-center col-sm-2"></div>
																	<div class="row col-md-8 pull-center">
																		<textarea class="form-control" id="<?php echo$idPregunta;?>" name="<?php echo$idPregunta;?>" maxlength="500"></textarea>
																	</div>
																</div>
															</div>

												<?php
														}
												 	} ?>

												<!--div class="form-group text-center">
													<button type="submit" class="btn btn-orange"> <i class="fa fa-send"></i> Responder</button>
												</div-->
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

				<!-- jQuery 3 -->
				<script src="../../../template/bower_components/jquery/dist/jquery.min.js"></script>
				<!-- Bootstrap 3.3.7 -->
				<script src="../../../template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
				<!-- DataTables -->
				<script src="../../../template/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
				<script src="../../../template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
				<!-- SlimScroll -->
				<script src="../../../template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
				<!-- FastClick -->
				<script src="../../../template/bower_components/fastclick/lib/fastclick.js"></script>
				<!-- AdminLTE App -->
				<script src="../../../template/dist/js/adminlte.min.js"></script>
				<!-- AdminLTE for demo purposes -->
				<script src="../../../template/dist/js/demo.js"></script>
				<!-- page script -->
		</div>
		<!-- ./wrapper -->

<script>
	$("#answer").submit(function( event ) {
		$('#answer').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_answer_survey.php",
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
