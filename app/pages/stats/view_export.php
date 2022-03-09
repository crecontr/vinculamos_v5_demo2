<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canReadStats()) {
		header('Location: ../../index.php');
	}

	$institucion = getInstitution();

	include_once("../../controller/medoo_attributes.php");
	$executionStatus = getVisibleExecutionStatus();
	$fillmentStatus = getVisibleFillmentStatus();

?>

<!DOCTYPE html>
<html>
<?php include_once("../../config/settings.php")?>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

	<?php
		$activeMenu = "datas";
		include_once("../include/menu_side.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
			<section class="content-header">
      		<h1>
        		 Exportar iniciativas
        		<small>todas las iniciativas</small>
      		</h1>
					<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Análisis de datos</li>
        		<li class="active">Exportar iniciativas</li>
      		</ol>
    	</section>

    	<!-- Main content -->
    	<section class="content">
      	<div class="row">
					<div class="col-lg-12 col-xs-6">
						<div class="box box-default">
							<div class="box-header with-border">
							  <h3 class="box-title">Descargar planilla Excel</h3>
							  <div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							  </div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 col-xs-6">
										<form id="filter_initiative" name="filter_initiative" method="post">
											<div class="col-xs-3">
												<label for="counit">Estado de Ejecución</label>
													<select class="selectpicker form-control" id="executionStatus[]" name="executionStatus[]"
														title="Estado de Ejecución" data-live-search="true" multiple>
														<?php
															foreach($executionStatus as $executionState) {
																echo "<option value='" . $executionState['nombre'] . "'>" . $executionState['nombre']. "</option>";
															}
														?>
													</select>
											</div>

											<div class="col-xs-3">
												<label for="counit">Estado de Completitud</label>
													<select class="selectpicker form-control" id="fillmentStatus[]" name="fillmentStatus[]"
														title="Estado de Completitud" data-live-search="true" multiple>
														<?php
															foreach($fillmentStatus as $fillmentState) {
																echo "<option value='" . $fillmentState['nombre'] . "'>" . $fillmentState['nombre']. "</option>";
															}
														?>
													</select>
											</div>

											<!--div class="col-xs-2">
												<label for="covenant">Convenio</label>
													<select class="selectpicker form-control" id="covenant[]" name="covenant[]"
														title="Convenio" data-live-search="true" multiple>
														<?php
															foreach($covenants as $covenant) {
																echo "<option value='" . $covenant['id'] . "'>" . $covenant['nombre']. "</option>";
															}
														?>
													</select>
											</div-->

											<div class="col-xs-2">
												<br>
												<a class="btn btn-orange" onclick="loadInitiatives();">Filtrar</a>
											</div>


										</form>
									</div>
								</div>

							  <div class="row">
									<div class="col-lg-12">
										<div id="mostrar_resultados"></div>
									</div>

								<!-- /.col -->
								</div>
							  <!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>

    	</section>
    	<!-- /.content -->
  	</div>
  	<!-- /.content-wrapper -->

  <?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>
	$(document).ready(function(){
		loadInitiatives();
	});

	function loadInitiatives() {
		var parametros = $("#filter_initiative").serialize();

		$.ajax({
			type: "POST",
				url:'./ajax_view_export.php',
				data:  parametros,
				beforeSend: function () {
						$('#mostrar_resultados').html('<img src="../../img/ajax-loader.gif"> Obteniendo información, espere por favor. Cargando...');
						//$("#resultado").html("");
				},
				success:  function (response) {
						$('#mostrar_resultados').html('');
						$("#mostrar_resultados").html(response);

						$('#table').DataTable({
							dom: 'Bfrtip',
							buttons: {
						    buttons: [
						      {
										extend: 'excel',
										text: '<i class="fa fa-fw fa-file-excel-o"></i> Exportar a Excel',
										title: 'Iniciativas',
										className: 'no-print'
						      }
						    ],
						    dom: {
						      button: {
						        tag: "button",
						        className: "btn btn-orange"
						      },
						      buttonLiner: {
						        tag: null
						      }
						    }
						  },
							'language': {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							'paging'      : true,
							'lengthChange': true,
							'searching'   : true,
							'ordering'    : false,
							'info'        : true,
							'autoWidth'   : true
						})

				},
				error: function() {
					$('#mostrar_resultados').html('');
					$("#mostrar_resultados").html(response);
				}
			});
	}

</script>
</body>
</html>
