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

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "initiatives";
		include_once("../include/menu_side.php");
		include_once("modal_add_evidence.php");

		include_once("modal_delete_evidence.php");
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
        		<li class="active">Editar Iniciativa - Evidencias</li>
      		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    					<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Evidencias</h3>

								<?php
									if(canUpdateInitiatives()) { ?>
										<div class="btn-group pull-right">
											<button id="exportButton" name="exportButton" class="btn btn-orange pull-right" data-toggle="modal" data-target="#addEvidence">
												<span class="fa fa-plus"></span> Agregar Evidencia
											</button>
										</div>
								<?php
									} ?>
							</div>
							<!-- /.box-header -->

							<div class="box-body">

								<div class="col-xs-12">
									<div id="loader"></div><!-- Carga los datos ajax -->
									<br>

									<div id='div_evidencias'></div>
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
		loadEvidences();
	});

	function loadEvidences() {
		var parametros = {
			"id_initiative" : '<?php echo$datasEncode;?>'

    };
		var url = "./ajax_view_initiatives_evidences.php";
		$.ajax({
			type: "POST",
      url: url,
      data:  parametros,
      beforeSend: function () {
        $("#div_evidencias").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#div_evidencias").html(response);
      },
			error: function() {
				$("#div_evidencias").html(response);
			}
    });
	}

	$("#add_evidence").submit(function( event ) {
		$('#add_evidence').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_evidence.php",
			data: new FormData(this),
			processData: false,
			contentType: false,
			beforeSend: function(objeto) {
				$("#resultados_modal_agregar_evidencia").html("Cargando...");
			},
			success: function(datos) {
				$('#add_evidence').attr("disabled", false);
				$("#resultados_modal_agregar_evidencia").html(datos);
				loadEvidences();
			},
			error: function() {
				$("#resultados_modal_agregar_evidencia").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#addEvidence').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var modal = $(this);
		modal.find('.modal-body #vg_nombre').val("");
		modal.find('.modal-body #vg_descripcion').val("");
		modal.find('.modal-body #vg_archivo').val("");
		$("#resultados_modal_agregar").html("");
	})

	$("#delete_evidence").submit(function( event ) {
		$('#delete_evidence').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_evidence.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$('#delete_evidence').attr("disabled", false);
				$('#deleteEvidence').modal('hide');
				$("#loader").html(datos);
				loadEvidences();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteEvidence').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id_evidencia = button.data('id_evidencia');
		var id_iniciativa = button.data('id_iniciativa');
		var nombre = button.data('nombre');
		var usuario = button.data('usuario');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id_evidencia);
		modal.find('.modal-body #vg_initiative').val(id_iniciativa);
		modal.find('.modal-body #vg_nombre').html(nombre);
		modal.find('.modal-body #vg_usuario').val(usuario);

		$("#resultados_modal_eliminar").html("");
	})


</script>

</body>
</html>
