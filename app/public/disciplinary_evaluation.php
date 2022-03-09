<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../utils/user_utils.php");
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../controller/initiatives.php");
	$datas = getInitiative($id);
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
	  	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	  	<!-- Font Awesome -->
	  	<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
	  	<!-- Ionicons -->
	  	<link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
	  	<!-- DataTables -->
	  	<link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	  	<!-- Theme style -->
	  	<link rel="stylesheet" href="../dist/css/AdminLTE.css">
	  	<!-- AdminLTE Skins. Choose a skin from the css/skins
	       folder instead of downloading all of them to reduce the load. -->
	  	<link rel="stylesheet" href="../dist/css/skins/_all-skins.css">

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
		          <a href="../../index2.html" class="navbar-brand"><b>Vinculamos</b></a>
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
		            <i class="fa fa-bars"></i>
		          </button>
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
	        		<?php echo $datas[0]["nombre"];?>
	        		<small>Evaluación disciplinar</small>
	      		</h1>
		    	</section>

		    	<!-- Main content -->
					<section class="content">
						<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
			    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Evaluación disciplinar</h3>
									</div>
									<!-- /.box-header -->

									<div class="box-body">
										<div id="loader"></div><!-- Carga los datos ajax -->


										<div class="modal-body">
											<form class="form-horizontal" method="post" id="answer" name="answer">
												<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> Correo electrónico</label>
													<div class="text-center col-sm-4"></div>
													<div class="text-center col-sm-4">
														<input type="email" class="form-control" id="vg_correo" name="vg_correo"
															placeholder="Correo electrónico" maxlength="100" required>
													</div>
													<div class="text-center col-sm-4"></div>
												</div>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> ¿Considera usted que la actividad ayudo a aumentar su capacidad de XXXXXXXXXX?</label>
													<input type="radio" id="vg_pregunta_1" name="vg_pregunta_1" value="Si" required> Si &nbsp;&nbsp;&nbsp;
													<input type="radio" id="vg_pregunta_1" name="vg_pregunta_1" value="No" required> No
												</div>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> ¿Considera usted que la actividad ayudo a aumentar su capacidad de XXXXXXXXXX?</label>
													<input type="radio" id="vg_pregunta_2" name="vg_pregunta_2" value="Si" required> Si &nbsp;&nbsp;&nbsp;
													<input type="radio" id="vg_pregunta_2" name="vg_pregunta_2" value="No" required> No
												</div>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> ¿Considera usted que la actividad ayudo a aumentar su capacidad de XXXXXXXXXX?</label>
													<input type="radio" id="vg_pregunta_3" name="vg_pregunta_3" value="Si" required> Si &nbsp;&nbsp;&nbsp;
													<input type="radio" id="vg_pregunta_3" name="vg_pregunta_3" value="No" required> No
												</div>

												<div class="form-group text-center">
													<label id="mensaje" class="col-sm-12"> ¿Considera usted que la actividad ayudo a aumentar su capacidad de XXXXXXXXXX?</label>
													<input type="radio" id="vg_pregunta_4" name="vg_pregunta_4" value="Si" required> Si &nbsp;&nbsp;&nbsp;
													<input type="radio" id="vg_pregunta_4" name="vg_pregunta_4" value="No" required> No
												</div>

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
						<b>Version 0.1-beta</b> <?php echo $currentVersion;?>
					</div>
				    <strong>Copyright &copy; 2019 <a href="http://www.vinculamos.cl/">Vinculamos</a>.</strong> Todos los derechos reservados.
				</footer>

				<!-- jQuery 3 -->
				<script src="../bower_components/jquery/dist/jquery.min.js"></script>
				<!-- Bootstrap 3.3.7 -->
				<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
				<!-- DataTables -->
				<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
				<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
				<!-- SlimScroll -->
				<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
				<!-- FastClick -->
				<script src="../bower_components/fastclick/lib/fastclick.js"></script>
				<!-- AdminLTE App -->
				<script src="../dist/js/adminlte.min.js"></script>
				<!-- AdminLTE for demo purposes -->
				<script src="../dist/js/demo.js"></script>
				<!-- page script -->
		</div>
		<!-- ./wrapper -->

<script>
	$(document).ready(function(){

	});

	$("#answer").submit(function( event ) {
		$('#answer').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_disciplinary_evaluation.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				if(datos.includes("correctamente")) {
					//$("#vg_rut").val("");
					//$("#vg_nombre").val("");
					//$("#vg_correo").val("");
					//$("#vg_telefono").val("");
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
