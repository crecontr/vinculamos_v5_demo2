<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];

	include_once("../../utils/user_utils.php");
	if(!canUpdateUsers()) {
		header('Location: ../../index.php');
		return;
	}

	$institucion = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_users.php");
	$datas = getUser($id);

	include_once("../../controller/medoo_profiles.php");
	$profiles = getConsideratedProfilesByInstitution($institucion);
	for($i=0; $i<sizeof($profiles); $i++) {
		$found = false;
		//echo "<br>" . $datas[0]["id_perfil"] . "==" . $profiles[$i]["id_perfil"];
		if($datas[0]["id_perfil"] == $profiles[$i]["id_perfil"]) {
			$profiles[$i]["selected"] = "selected";
		} else {
			$profiles[$i]["selected"] = "";
		}
	}
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
        		Usuario
        		<small>editar usuario</small>
      		</h1>
      		<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Usuarios</li>
        		<li class="active">Editar Usuario</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
    						<h3 class="box-title"><?php echo $datas[0]["nombre"] . " " . $datas[0]["apellido"] . " (" . $datas[0]["nombre_usuario"] . ")"; ?></h3>
						</div>
						<!-- /.box-header -->

						<div class="box-body">
  						<div class="row">
								<div class="col-md-6">
									<div id="loader"></div><!-- Carga los datos ajax -->
									<form class="form-horizontal" method="post" id="edit_user" name="edit_user">
										<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
										<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["nombre_usuario"])."' id='vg_id' name='vg_id' />"; ?>
										<div class="form-group">
											<label for="vg_nombre" class="col-sm-4 control-label">Nombre <span class="text-red">*</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
													placeholder="Nombre" maxlength="100" required value='<?php echo$datas[0]["nombre"];?>'>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_apellido" class="col-sm-4 control-label">Apellido <span class="text-red">*</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="vg_apellido" name="vg_apellido"
													placeholder="Apellido" maxlength="100" required value='<?php echo$datas[0]["apellido"];?>'>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_telefono" class="col-sm-4 control-label">Teléfono</label>
											<div class="col-sm-8">
												<input type="tel" class="form-control" id="vg_telefono" name="vg_telefono"
													placeholder="Teléfono" maxlength="100" value='<?php echo$datas[0]["telefono"];?>'>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_correo_electronico" class="col-sm-4 control-label">Correo Electrónico</label>
											<div class="col-sm-8">
												<input type="email" class="form-control" id="vg_correo_electronico" name="vg_correo_electronico"
												placeholder="Correo Electrónico" maxlength="100" value='<?php echo$datas[0]["correo_electronico"];?>'>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_perfil" class="col-sm-4 control-label">Perfil Usuario <span class="text-red">*</span></label>
											<div class="col-sm-8">
												<select class="selectpicker form-control" id="vg_perfil" name="vg_perfil" required title="Perfil Usuario">
													<?php
														foreach($profiles as $profile) {
															echo "<option value='" . noeliaEncode($profile['id_perfil']) . "' ".$profile['selected'].">" . $profile['nombre']. "</option>";
														}
													?>
					            	</select>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_perfil" class="col-sm-4 control-label">Estado <span class="text-red">*</span></label>
											<div class="col-sm-8">
												<select class="selectpicker form-control" id="vg_estado" name="vg_estado" required title="Estado">
													<option value="1" <?php echo($datas[0]["estado"] == "1"? "selected":"") ?>>Activo</option>";
													<option value="0" <?php echo($datas[0]["estado"] == "0"? "selected":"") ?>>Inactivo</option>";
					              </select>
											</div>
										</div>

										<div class="modal-footer">
											<a href="view_users.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
											<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Guardar</button>
										</div>
									</form>
								</div>

								<div class="col-md-6">
									<div class="box-header">
											<h3 class="box-title">Cambiar contraseña</h3>
									</div>
									<!-- /.box-header -->

									<div id="resultados_modal_change"></div>

									<form class="form-horizontal" method="post" id="change_password" name="change_password">
										<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
										<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["nombre_usuario"])."' id='vg_id' name='vg_id' />"; ?>
										<div class="form-group">
											<label for="vg_contrasenia_1" class="col-sm-4 control-label">Nueva Contraseña</label>
											<div class="col-sm-8">
												<input type="password" class="form-control" id="vg_contrasenia_1" name="vg_contrasenia_1"
													placeholder="Nueva Contraseña" minlength="4" maxlength="100" required>
											</div>
										</div>
										<div class="form-group">
											<label for="vg_contrasenia_2" class="col-sm-4 control-label">Repetir Contraseña</label>
											<div class="col-sm-8">
												<input type="password" class="form-control" id="vg_contrasenia_2" name="vg_contrasenia_2"
													placeholder="Reperir Contraseña" minlength="4" maxlength="100" required>
											</div>
										</div>

										<div class="modal-footer">
											<button type="submit" class="btn btn-orange"><span class="fa fa-key"></span> Cambiar</button>
										</div>
									</form>
								</div>
							</div>
							<!-- /.row -->
						</div>
						<!-- /.box-body -->
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

	$("#edit_user").submit(function( event ) {
		$('#edit_user').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_user.php",
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

	$("#change_password").submit(function( event ) {
		$('#change_password').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_change_password.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_change").html("Cargando...");
			},
			success: function(datos) {
				$('#change_password').attr("disabled", false);
				$("#resultados_modal_change").html(datos);

				$("#vg_contrasenia_1").val("");
				$("#vg_contrasenia_2").val("");
			},
			error: function() {
				$("#resultados_modal_change").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

</script>

</body>
</html>
