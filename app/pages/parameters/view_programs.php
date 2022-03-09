<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canReadParameters()) {
		header('Location: ../../index.php');
	}

	$institucion = getInstitution();

	//include_once("../../controller/responsibles.php");
	//$responsibles = getVisibleResponsiblesByInstitution($institucion);

	//include_once("../../controller/institution_types.php");
	//$institution_types = getVisibleInstitutionTypeByInstitution($institucion);

	//include_once("../../controller/institution_campus.php");
	//$institution_campus = getVisibleCampusTypeByInstitution($institucion);
?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "parameters";
		include_once("../include/menu_side.php");
		include_once("modal_add_program.php");
		include_once("modal_delete_program.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Lineas de acción
        		<small>todas las lineas de acción</small>
      		</h1>
      		<ol class="breadcrumb">
        		<li><i class="fa fa-home"></i> Inicio</li>
        		<li>Lineas de acción</li>
        		<li class="active">Ver lineas de acción</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title">Listado de lineas de acción</h3>

    						<?php
    							if(canCreateParameters()) {?>
    								<div class="btn-group pull-right">
										<button id="exportButton" name="exportButton" class="btn btn-orange pull-right" data-toggle="modal" data-target="#addProgram">
											<span class="fa fa-plus"></span> Agregar Linea de acción
										</button>
									</div>
							<?php
								} ?>
						</div>
						<!-- /.box-header -->

						<div id="mensaje_resultados"></div><!-- Carga los datos ajax -->

						<span id="loader"></span>
						<div id="resultados"></div><!-- Carga los datos ajax -->
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
		load();
	});

	function load() {
		$.ajax({
			type: "POST",
      url:'./ajax_view_programs.php',
      data:  '',
      beforeSend: function () {
        $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
        $("#resultados").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
      	$('#loader').html('');
        $("#resultados").html(response);

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
				$('#loader').html('');
				$("#resultados").html(response);
			}
        });
	}

	$("#add_program").submit(function( event ) {
		$('#add_program').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_program.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_agregar").html("Cargando...");
			},
			success: function(datos) {
				$('#add_program').attr("disabled", false);
				$("#resultados_modal_agregar").html(datos);
				load();
			},
			error: function() {
				$("#resultados_modal_agregar").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#addProgram').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var modal = $(this);
		modal.find('.modal-body #vg_nombre').val("");
		modal.find('.modal-body #vg_descripcion').val("");
		$("#resultados_modal_agregar").html("");
	})

	$("#delete_program").submit(function( event ) {
		$('#delete_program').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_program.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$('#delete_program').attr("disabled", false);
				$('#deleteProgram').modal('hide');
				$("#mensaje_resultados").html(datos);
				load();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteProgram').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nombre = button.data('nombre');
		var usuario = button.data('usuario');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_nombre').html(nombre);
		modal.find('.modal-body #vg_usuario').val(usuario);

		$("#resultados_modal_eliminar").html("");
	})

</script>
</body>
</html>
