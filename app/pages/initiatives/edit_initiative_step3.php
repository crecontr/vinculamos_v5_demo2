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
		include_once("modal_delete_participation_plan.php");
		include_once("modal_delete_participation_real.php");
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
        		<li class="active">Editar Iniciativa - Participantes</li>
      		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Participantes</h3>
							</div>
							<!-- /.box-header -->

							<div class="box-body">
								<div class="row">

									<div class="col-md-4">
										<div>
											<label for="fa_tipo_ingreso">Público participante:</label>
											<select class="selectpicker form-control" id="fa_tipo_ingreso" name="vg_tipo_ingreso"
												title="Esperados o Reales" onchange="load()">
												<option value='Esperado' selected>Esperado</option>
												<option value='Real'>Real</option>
											</select>
										</div>
									</div>
								</div>


								<div id="loader"></div><!-- Carga los datos ajax -->
								<div id="form"></div><!-- Carga los datos ajax -->

								<br>

								<div id='resultados_esperados'></div>

								<div class="modal-footer">
									<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
									<a href="edit_initiative_step2.php?data=<?php echo$dataEncoded;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-left"></i> Volver al paso anterior</a>
									<a href="edit_initiative_step4.php?data=<?php echo$dataEncoded;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-fw fa-chevron-right"></i>Siguiente</a>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script>
	$(document).ready(function(){
		loadPlanParticipation();
	});

	function load() {
		if($("#fa_tipo_ingreso").val() == "Esperado") {
			loadPlanParticipation();
		}

		if($("#fa_tipo_ingreso").val() == "Real") {
			loadRealParticipation();
		}
		$("#loader").html("");
		$("#resultados_esperados").html("");
	}

	function loadPlanParticipation() {
		var parametros = {
			"id_initiative" : btoa('<?php echo$id;?>')

    };
		var url = "./ajax_view_participation_plan.php";
		$.ajax({
			type: "POST",
      url: url,
      data:  parametros,
      beforeSend: function () {
        $("#resultados_esperados").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#resultados_esperados").html(response);
      },
			error: function() {
				$("#resultados_esperados").html(response);
			}
    });
	}

	function loadRealParticipation() {
		var parametros = {
			"id_initiative" : btoa('<?php echo$id;?>')

    };
		var url = "./ajax_view_participation_real.php";
		$.ajax({
			type: "POST",
      url: url,
      data:  parametros,
      beforeSend: function () {
        $("#resultados_esperados").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#resultados_esperados").html(response);
      },
			error: function() {
				$("#resultados_esperados").html(response);
			}
    });
	}

</script>

</body>
</html>
