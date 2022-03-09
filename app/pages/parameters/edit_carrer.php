<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateParameters()) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];
	$institucion = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_carrers.php");
	$datas = getCarrer($id);
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
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
			<section class="content-header">
      		<h1>
        		Carrera
        		<small>editar carrera</small>
      		</h1>
      		<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Carreras</li>
        		<li class="active">Editar Carrera</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title"><?php echo $datas[0]["nombre"]; ?></h3>
						</div>
						<!-- /.box-header -->

						<div class="box-body">
							<div id="loader"></div><!-- Carga los datos ajax -->

    						<form class="form-horizontal" method="post" id="edit_carrer" name="edit_carrer">
								<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
								<?php echo "<input type='hidden' value='".noeliaEncode($id)."' id='vg_id' name='vg_id' />"; ?>

								<div class="row">

									<div class="col-md-8">
										<div class="form-group">
											<label for="vg_nombre" class="col-sm-3 control-label">Nombre</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
													placeholder="Nombre" maxlength="100" required value='<?php echo$datas[0]["nombre"];?>'>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_descripcion" class="col-sm-3 control-label">Descripción</label>
											<div class="col-sm-8">
												<textarea class="form-control textarea" placeholder="Descripción" id="vg_descripcion" name="vg_descripcion"
														style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"><?php echo$datas[0]["descripcion"];?></textarea>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_director" class="col-sm-3 control-label">Director</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="vg_director" name="vg_director"
													placeholder="Director" maxlength="100" value='<?php echo$datas[0]["director"];?>'>
											</div>
										</div>

										<div class="modal-footer">
											<a href="view_carrers.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
											<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Guardar</button>
										</div>

									</div>
									<div class="col-md-4">
									</div>
								</div>
							</form>

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

	});

	$("#edit_carrer").submit(function( event ) {
		$('#edit_carrer').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_carrer.php",
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
