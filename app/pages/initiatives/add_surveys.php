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

		include_once("modal_add_survey.php");
		include_once("modal_edit_survey.php");

		include_once("modal_add_question.php");
		include_once("modal_edit_question.php");
		include_once("modal_delete_question.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
	  		<h1>
	    		Iniciativas
	    		<small>encuestas de evaluación</small>
	  		</h1>
	  		<ol class="breadcrumb">
					<li><a href="../home/index.php"><i class="fa fa-home"></i> Inicio</a></li>
					<li><a href="../initiatives/view_initiatives.php">Iniciativas</a></li>
	    		<li class="active">Encuestas de Evaluación</li>
	  		</ol>
    	</section>

    	<!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
	    						<h3 class="box-title"><?php echo ($datas[0]["nombre"] == "" ? "Editar iniciativa" : $datas[0]["nombre"]);?> - Encuestas de Evaluación</h3>
							</div>
							<!-- /.box-header -->

							<div class="box-body">
								<?php
								 	if(sizeof($tipos_participantes) == 0) { ?>
										<p><strong>Para agregar una encuesta, primero debe ingresar el paso 3: Participantes de la iniciativa.</strong></p>
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
											<div class="col-md-12">
												<div id="mensaje_resultados"></div>
											</div>

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

												<br><div id="resultados_encuesta"></div>

												<div class="modal-footer">
													<a href="view_initiatives.php" class="btn btn-default" data-dismiss="modal">Ir al listado</a>
													<?php
														$data = noeliaEncode("data" . $id);
													?>
													<a href="add_attendance_list.php?data=<?php echo$data;?>" class="btn btn-orange" data-dismiss="modal"> <i class="fa fa-users"></i> Ver lista de asistencia</a>
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
		loadSurvey($("#vg_tipo_participante").val())
		//$("#loader").html("");
		//$("#resultados_esperados").html("");
	}

	function loadSurvey(tipo) {
		var parametros = {
			"id_initiative" : btoa(<?php echo$id;?>),
			"tipo" : btoa(tipo)
    };
		$.ajax({
			type: "POST",
      url: "./ajax_view_survey.php",
      data:  parametros,
      beforeSend: function () {
        $("#resultados_encuesta").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $("#resultados_encuesta").html(response);

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
				$("#resultados_encuesta").html(response);
			}
    });
	}

	$('#addSurvey').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var tipo = button.data('tipo');
		//var tipoUtf8 = utf8_encode(tipo);

		var modal = $(this);
		modal.find('.modal-body #vg_tipo').val(tipo);
		$("#mensaje_resultados").html("");
	})

	$("#add_survey").submit(function( event ) {
		$('#add_survey').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_survey.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$("#mensaje_resultados").html(datos);
				$('#addSurvey').modal('hide');
				load();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editSurvey').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var encuesta = button.data('encuesta');
		var titulo = button.data('titulo');
		var descripcion = button.data('descripcion');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(encuesta);
		modal.find('.modal-body #vg_titulo').val(titulo);
		modal.find('.modal-body #vg_descripcion').val(descripcion);
		$("#resultados_modal_editar_encuesta").html("");
	})

	$("#edit_survey").submit(function( event ) {
		var parametros = $(this).serialize();

		$.ajax({
			type: "POST",
			url: "./ajax_edit_survey.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_editar_encuesta").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_editar_encuesta").html(datos);
				load();
			},
			error: function() {
				$("#resultados_modal_editar_encuesta").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#addQuestion').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var encuesta = button.data('encuesta');

		var modal = $(this);
		modal.find('.modal-body #vg_encuesta').val(encuesta);
		modal.find('.modal-body #vg_titulo').val("");
		modal.find('.modal-body #vg_tipo_respuesta').selectpicker('val', "");
		$("#resultados_modal_agregar_pregunta").html("");
	})

	$("#add_question").submit(function( event ) {
		$('#add_question').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_survey_question.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$("#mensaje_resultados").html(datos);
				$('#addQuestion').modal('hide');
				load();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#editQuestion').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var encuesta = button.data('encuesta');
		var id = button.data('id');
		var titulo = button.data('titulo');
		var tipo_respuesta = button.data('tipo_respuesta');

		var modal = $(this);
		modal.find('.modal-body #vg_encuesta').val(encuesta);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_titulo').val(titulo);
		modal.find('.modal-body #vg_tipo_respuesta').selectpicker('val', tipo_respuesta);
		$("#resultados_modal_editar_pregunta").html("");
	})

	$("#edit_question").submit(function( event ) {
		$('#edit_question').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_edit_survey_question.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_modal_editar_pregunta").html("Cargando...");
			},
			success: function(datos) {
				$("#resultados_modal_editar_pregunta").html(datos);
				load();
			},
			error: function() {
				$("#resultados_modal_editar_pregunta").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteQuestion').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var encuesta = button.data('encuesta');
		var id = button.data('id');
		var titulo = button.data('titulo');

		var modal = $(this);
		modal.find('.modal-body #vg_encuesta').val(encuesta);
		modal.find('.modal-body #vg_id').val(id);
		$("#mensaje_resultados").html("");
	})

	$("#delete_question").submit(function( event ) {
		$('#delete_question').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_survey_question.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#mensaje_resultados").html("Cargando...");
			},
			success: function(datos) {
				$("#mensaje_resultados").html(datos);
				$('#deleteQuestion').modal('hide');
				load();
			},
			error: function() {
				$("#mensaje_resultados").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$("#delete_attendance").submit(function( event ) {
		$('#delete_attendance').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "../ajax/delete_attendance.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html(datos);

				if(datos.includes("correctamente")) {
					$('#deleteAttendance').modal('hide');

					loadAttendanceList();
				}
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteAttendance').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var id_iniciativa = button.data('id_iniciativa');
		var usuario = button.data('usuario');

		var modal = $(this);
		modal.find('.modal-body #vg_id').val(id);
		modal.find('.modal-body #vg_initiative').val(id_iniciativa);
		modal.find('.modal-body #vg_usuario').val(usuario);
		$("#resultados_modal_eliminar").html("");
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
