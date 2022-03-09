<?php
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');

	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];

	include_once("../../utils/user_utils.php");
	$institution = getInstitution();

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_initiatives.php");
	$datas = getInitiative($id);

	include_once("../../controller/medoo_participation_real.php");
	$participacion_real = getVisibleRealParticipationByInitiative($datas[0]["id"]);

	$tipos_participantes = array();
	for ($i=0; $i < sizeof($participacion_real); $i++) {
		if(!in_array($participacion_real[$i]["tipo"], $tipos_participantes)) {
			$tipos_participantes[] = $participacion_real[$i]["tipo"];
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
		$activeMenu = "initiatives";
		include_once("../include/menu_side.php");

		include_once("modal_delete_participation.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
	  		<h1>
	    		Iniciativas
	    		<small>lista de asistencia</small>
	  		</h1>
	  		<ol class="breadcrumb">
					<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
					<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
	    		<li class="active">Lista de Asistencia</li>
	  		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Lista de Asistencia</h3>
							</div>
							<!-- /.box-header -->

							<div class="box-body">
								<?php
								 	if(sizeof($tipos_participantes) == 0) { ?>
										<p><strong>Para agregar lista de asistencia, primero debe ingresar el paso 3: Participantes de la iniciativa.</strong></p>
										<div class="modal-footer">
											<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
											<?php
												$data = noeliaEncode("data" . $id);
											?>

											<?php
				      					if(canUpdateInitiatives()) { ?>
													<a href="edit_initiative_step1.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-table"></i> Editar iniciativa</a>
											<?php
												} ?>
										</div>
								<?php
									} else { ?>

										<div class="row">
											<div class="col-md-4">
												<div>
													<label for="fa_tipo_ingreso">Tipo de público participante real:</label>
													<select class="selectpicker form-control" id="vg_tipo_participante" name="vg_tipo_participante"
														title="Tipo de público participante" onchange="load()">
														<?php
															for ($i=0; $i < sizeof($tipos_participantes); $i++) { ?>
																<option value='<?php echo$tipos_participantes[$i]?>' <?php echo($i==0 ? "selected":"");?>><?php echo$tipos_participantes[$i]?></option>
														<?php
															} ?>
													</select>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="box-body">
												<div id="loader"></div><!-- Carga los datos ajax -->
												<div class="col-md-8">
													<form class="form-horizontal" method="post" id="add_attendance" name="add_attendance">
														<?php echo "<input type='hidden' value='".($nombre_usuario)."' id='vg_usuario' name='vg_usuario' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>
														<?php echo "<input type='hidden' value='' id='vg_tipo' name='vg_tipo' />"; ?>
														<?php echo "<input type='hidden' value='' id='vg_telefono' name='vg_telefono' />"; ?>

														<div class="col-md-12">
															<div class="row">
																<h4>Cargar manualmente</h4>
																<div class="col-xs-6 col-md-3">
																	<label for="vg_rut">Rut</label>
																	<input type="text" class="form-control" id="vg_rut" name="vg_rut"
																		placeholder="Rut" maxlength="100" required oninput="checkRut(this)">
																</div>
																<div class="col-xs-6 col-md-4">
																	<label for="vg_nombre">Nombre completo</label>
																	<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
																		placeholder="Nombre completo" maxlength="100" required>
																</div>
																<div class="col-xs-6 col-md-5">
																	<label for="vg_correo">Correo electrónico</label>
																	<input type="email" class="form-control" id="vg_correo" name="vg_correo"
																		placeholder="Correo electrónico" maxlength="100" required>
																</div>
																<!--div class="col-xs-6 col-md-3">
																	<label for="vg_telefono">Teléfono</label>
																	<input type="text" class="form-control" id="vg_telefono" name="vg_telefono"
																		placeholder="Teléfono" maxlength="100">
																</div-->
															</div>
															<div class="row">
																<div class="ol-md-12 pull-right">
																	<br>
																	<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Guardar</button>
																</div>
															</div>
														</div>
													</form>
												</div>

												<div class="col-md-4">
													<form class="form-horizontal" method="post" id="add_evaluator_excel" name="add_evaluator_excel">
														<?php echo "<input type='hidden' value='".($nombre_usuario)."' id='vg_usuario' name='vg_usuario' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["id"])."' id='vg_id_initiative' name='vg_id_initiative' />"; ?>
														<?php echo "<input type='hidden' value='".noeliaEncode($id_evaluation)."' id='vg_id_evaluation' name='vg_id_evaluation' />"; ?>
														<?php echo "<input type='hidden' value='' id='vg_tipo2' name='vg_tipo2' />"; ?>

														<h4>Cargar desde archivo</h4>
														<div class="col-xs-12 col-md-12">
															<label for="vg_rut">Archivo (<a href="../../templates_upload/asistentes.xlsx">descargar plantilla</a>)</label>
															<input class="form-control" type="file" id="vg_excel" name="vg_excel" accept=".xls,.xlsx">
														</div>
														<div class="row">
															<div class="ol-md-12 pull-right">
																<br>
																<button type="submit" class="btn btn-orange"><span class="fa fa-save"></span> Guardar</button>
															</div>
														</div>
													</form>
												</div>

												<br><div id="resultados_lista"></div>

												<div class="modal-footer">
													<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
													<?php
														$data = noeliaEncode("data" . $id);
													?>
													<a href="add_surveys.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-paste"></i> Ver encuestas</a>
												</div>

												<hr style="height: 2px; border: 0;" class="btn-orange"/>
											</div>
										</div>

								<?php
									} ?>

							</div>

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
		load()
	});

	function load() {
		$("#vg_tipo").val($("#vg_tipo_participante").val());
		$("#vg_tipo2").val($("#vg_tipo_participante").val());
		loadAttendanceList($("#vg_tipo_participante").val())
		//$("#loader").html("");
		//$("#resultados_esperados").html("");
	}

	function loadAttendanceList(tipo) {
		var parametros = {
			"id_initiative" : btoa(<?php echo$id;?>),
			"tipo" : btoa(tipo)
    };
		$.ajax({
			type: "POST",
      url: "./ajax_view_attendance_list.php",
      data:  parametros,
      beforeSend: function () {
        $("#resultados_lista").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#resultados_lista").html(response);

				$("#tableAttendance").DataTable({
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
				$("#resultados_lista").html(response);
			}
    });
	}

	$("#add_attendance").submit(function( event ) {
		$('#add_attendance').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_attendance.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				if(datos.includes("correctamente")) {
					$("#vg_rut").val("");
					$("#vg_nombre").val("");
					$("#vg_correo").val("");
					$("#vg_telefono").val("");

					load();
				}
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$("#delete_participation").submit(function( event ) {
		$('#delete_attendance').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_attendance.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				if(datos.includes("correctamente")) {
					$('#deleteParticipation').modal('hide');
					load();
				}
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteParticipation').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		$("#loader").html("");
	})

	$("#add_evaluator_excel").submit(function( event ) {
		$('#add_evaluator_excel').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_attendance_excel.php",
			data: new FormData(this),
			processData: false,
			contentType: false,
			beforeSend: function(objeto) {
				$("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			},
			success: function(datos) {
				$('#add_evaluator_excel').attr("disabled", false);
				$("#loader").html(datos);

				load();
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	function checkRut(rut) {
  	// Despejar Puntos
  	var valor = rut.value.replace('.','');
  	// Despejar Guión
  	valor = valor.replace('-','');

  	// Aislar Cuerpo y Dígito Verificador
  	cuerpo = valor.slice(0,-1);
  	dv = valor.slice(-1).toUpperCase();

  	// Formatear RUN
  	rut.value = cuerpo + '-'+ dv

  	// Si no cumple con el mínimo ej. (n.nnn.nnn)
  	if(cuerpo.length < 7) { rut.setCustomValidity("Rut incompleto"); return false;}

  	// Calcular Dígito Verificador
  	suma = 0;
  	multiplo = 2;

  	// Para cada dígito del Cuerpo
  	for(i=1;i<=cuerpo.length;i++) {

      	// Obtener su Producto con el Múltiplo Correspondiente
      	index = multiplo * valor.charAt(cuerpo.length - i);

      	// Sumar al Contador General
      	suma = suma + index;

      	// Consolidar Múltiplo dentro del rango [2,7]
      	if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
		}

  	// Calcular Dígito Verificador en base al Módulo 11
  	dvEsperado = 11 - (suma % 11);

  	// Casos Especiales (0 y K)
  	dv = (dv == 'K')?10:dv;
  	dv = (dv == 0)?11:dv;

  	// Validar que el Cuerpo coincide con su Dígito Verificador
  	if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }

  	// Si todo sale bien, eliminar errores (decretar que es válido)
  	rut.setCustomValidity('');
	}
</script>

</body>
</html>
