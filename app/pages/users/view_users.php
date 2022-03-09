<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canReadUsers()) {
		header('Location: ../../index.php');
		return;
	}

	$institucion = getInstitution();

	include_once("../../controller/medoo_profiles.php");
	$profiles = getConsideratedProfilesByInstitution($institucion);

	//include_once("../../controller/institution_types.php");
	//$institution_types = getVisibleInstitutionTypeByInstitution($institution);

	//include_once("../../controller/institution_campus.php");
	//$institution_campus = getVisibleCampusTypeByInstitution($institution);

	//include_once("../../controller/units.php");
	//$organization_units = getVisibleUnitsByInstitution($institution);
?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "users";
		include_once("../include/menu_side.php");
		include_once("modal_add_user.php");
		include_once("modal_edit_user.php");
		include_once("modal_change_password.php");
		include_once("modal_delete_user.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Usuarios
        		<small>todos los usuarios</small>
      		</h1>
      		<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Usuarios</li>
        		<li class="active">Ver Usuarios</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title">Listado de usuarios</h3>

    						<?php
    							if(canCreateUsers()) {?>
    								<div class="btn-group pull-right">
										<button id="exportButton" name="exportButton" class="btn btn-orange pull-right" data-toggle="modal" data-target="#addUser">
											<span class="fa fa-user-plus"></span> Agregar Usuario
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
      url:'./ajax_view_users.php',
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

	$("#add_user").submit(function( event ) {
		$('#add_user').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_user.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_agregar").html("Cargando...");
			},
			success: function(datos) {
				$('#add_user').attr("disabled", false);
				$("#resultados_modal_agregar").html(datos);
				load();
			},
			error: function() {
				$("#resultados_modal_agregar").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#addUser').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var modal = $(this);
		modal.find('.modal-body #ht_nombre').val("");
		modal.find('.modal-body #ht_apellido').val("");
		modal.find('.modal-body #ht_telefono').val("");
		modal.find('.modal-body #ht_correo_electronico').val("");
		modal.find('.modal-body #ht_nombre_usuario').val("");
		modal.find('.modal-body #ht_contrasenia_1').val("");
		modal.find('.modal-body #ht_contrasenia_2').val("");
		modal.find('.modal-body #ht_perfil').selectpicker('val', '');
		modal.find('.modal-body #ht_estado').selectpicker('val', '');

		modal.find('.modal-body #vg_tipo_institucion').selectpicker('val', "");
		modal.find('.modal-body #vg_sede_institucion').selectpicker('val', "");
		modal.find('.modal-body #vg_unidad').selectpicker('val', "");
		$("#resultados_modal_agregar").html("");
	})

	$("#delete_user").submit(function( event ) {
		$('#delete_user').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_user.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$('#delete_user').attr("disabled", false);
				$('#deleteUser').modal('hide');
				$("#mensaje_resultados").html(datos);
				load();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteUser').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var alias = button.data('alias');
		var nombre = button.data('nombre');
		var apellido = button.data('apellido');
		var usuario = button.data('usuario');

		var modal = $(this);
		modal.find('.modal-body #vg_nombre').html(nombre + " " + apellido);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_usuario').val(usuario);

		$("#resultados_modal_eliminar").html("");
	})

</script>
</body>
</html>
