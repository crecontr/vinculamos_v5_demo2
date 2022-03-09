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
	$id_evaluation = noeliaDecode($_GET["id_evaluation"]);

	include_once("../../controller/medoo_initiatives.php");
	$iniciativa = getInitiative($id);
	$id_iniciativa_encoded = noeliaEncode($iniciativa[0]["id"]);

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationById($id_evaluation);
	$id_evaluation_encoded = noeliaEncode($evaluation[0]["id"]);

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
        		<li class="active">Editar Iniciativa - Consolidado evaluación de impacto</li>
      		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"><?php echo ($iniciativa[0]["nombre"] == "" ? "Editar iniciativa" : $iniciativa[0]["nombre"]);?> - Resultados para <?php echo $evaluation[0]["tipo_evaluacion"];?></h3>
							</div>
							<!-- /.box-header -->

							<div class="box-body">
								<div id="loader"></div><!-- Carga los datos ajax -->

								<br><div id='resultados_resumen'></div>

								<div class="modal-footer">
									<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
									<?php
										$data = noeliaEncode("data" . $id) . "&id_evaluation=" . noeliaEncode($evaluation[0]["id"]) . "&type=" . noeliaEncode($tipo);
									?>
									<a href="javascript:history.back()" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-left"></i> Volver</a>
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

  	<?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->
<script src="../../../template/bower_components/jquery-knob/js/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>
	$(document).ready(function(){
		loadAttendanceSurveyResult();
	});

	function loadAttendanceSurveyResult() {
		var parametros = {
			"id_initiative" : '<?php echo$id_iniciativa_encoded;?>',
			"id_evaluation" : '<?php echo$id_evaluation_encoded;?>'
    };
		$.ajax({
			type: "POST",
      url: "./ajax_view_evaluation_results.php",
      data:  parametros,
      beforeSend: function () {
        $("#resultados_resumen").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#resultados_resumen").html(response);
				$(".knob").knob();
      },
			error: function() {
				$("#resultados_resumen").html(response);
			}
    });

	}

</script>

</body>
</html>
