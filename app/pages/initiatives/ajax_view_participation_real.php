<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	$nombre_usuario = $_SESSION["nombre_usuario"];
	include_once("../../utils/user_utils.php");
	if(!canReadInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$id_initiative = base64_decode($_POST['id_initiative']);

	include("../../controller/medoo_participation_type.php");
	$participationTypes = getVisibleParticipationTypes("Tipo 1");

	include_once("../../controller/medoo_participation_real.php");
	$datas = getVisibleRealParticipationByInitiative($id_initiative);
?>

<form class="form-horizontal" method="post" id="add_persons_type_1" name="add_persons_type_1">
	<?php echo "<input type='hidden' value='".$nombre_usuario."' id='vg_autor' name='vg_autor' />"; ?>
	<?php echo "<input type='hidden' value='".noeliaEncode($id_initiative)."' id='vg_id' name='vg_id' />"; ?>

	<div class="col-md-12">
		<div class="row">
			<div class="col-xs-6 col-md-2">
				<label for="vg_programa">Público real</label>
				<select class="form-control" id="vg_tipo_asistente" name="vg_tipo_asistente" required
					title="Asistente esperado" >
					<option></option>
				<?php
					foreach($participationTypes as $participationType) {
						echo "<option value='" . $participationType['nombre'] ."'>" . $participationType['nombre']. "</option>";
					}
				?>
				</select>
			</div>
			<div class="col-xs-6 col-md-2">
				<label for="fa_nombre">Número de personas</label>
				<input type="number" class="form-control" id="vg_publico_general" name="vg_publico_general"
					placeholder="Número de personas" maxlength="100" required>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-md-2">
				<input type="checkbox" id="checkbox_sexo" name="checkbox_sexo"><label for="vg_programa">&nbsp;¿Género?</label>
				<input type="number" class="form-control" id="vg_sexo_masculino" name="vg_sexo_masculino"
					placeholder="Hombre" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_sexo_femenino" name="vg_sexo_femenino"
					placeholder="Mujer" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_sexo_otro" name="vg_sexo_otro"
					placeholder="Otro" maxlength="100" readonly>
			</div>
			<div class="col-xs-6 col-md-2">
				<input type="checkbox" id="checkbox_edad" name="checkbox_edad"><label for="vg_programa">&nbsp;¿Segmento etario?</label>
				<input type="number" class="form-control" id="vg_edad_ninos" name="vg_edad_ninos"
					placeholder="Niños" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_edad_jovenes" name="vg_edad_jovenes"
					placeholder="Jóvenes" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_edad_adultos" name="vg_edad_adultos"
					placeholder="Adultos" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_edad_adultos_mayores" name="vg_edad_adultos_mayores"
					placeholder="Adultos Mayores" maxlength="100" readonly>
			</div>
			<div class="col-xs-6 col-md-2">
				<input type="checkbox" id="checkbox_procedencia" name="checkbox_procedencia"><label for="vg_programa">&nbsp;¿Procedencia?</label>
				<input type="number" class="form-control" id="vg_procedencia_rural" name="vg_procedencia_rural"
					placeholder="Rural" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_procedencia_urbano" name="vg_procedencia_urbano"
					placeholder="Urbano" maxlength="100" readonly>
			</div>
			<div class="col-xs-6 col-md-2">
				<input type="checkbox" id="checkbox_vulnerabilidad" name="checkbox_vulnerabilidad"><label for="vg_programa">&nbsp;¿Vulnerabilidad?</label>
				<input type="number" class="form-control" id="vg_vulnerabilidad_pueblo" name="vg_vulnerabilidad_pueblo"
					placeholder="Pueblo originario" maxlength="100" readonly readonly style="display: none">
				<input type="number" class="form-control" id="vg_vulnerabilidad_discapacidad" name="vg_vulnerabilidad_discapacidad"
					placeholder="Discapacidad" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_vulnerabilidad_pobreza" name="vg_vulnerabilidad_pobreza"
				placeholder="Pobreza" maxlength="100" readonly>
			</div>
			<div class="col-xs-6 col-md-2">
				<input type="checkbox" id="checkbox_nacionalidad" name="checkbox_nacionalidad"><label for="vg_programa">&nbsp;¿Nacionalidad?</label>
				<input type="number" class="form-control" id="vg_nacionalidad_chileno" name="vg_nacionalidad_chileno"
					placeholder="Chileno" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_nacionalidad_migrante" name="vg_nacionalidad_migrante"
					placeholder="Migrante" maxlength="100" readonly>
				<input type="number" class="form-control" id="vg_nacionalidad_pueblo" name="vg_nacionalidad_pueblo"
				placeholder="Pueblo originario" maxlength="100" readonly>
			</div>
		</div>
		<div class="row">
			<div class="ol-md-12 pull-right">
				<button type="submit" class="btn btn-orange"><span class="fa fa-plus"></span> Agregar</button>
			</div>
		</div>
	</div>
</form>

  <div class="box-body table-responsive">
		<div id="result_human_resources_detail"></div>
		<table id="tableType_1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2">Público participante real</th>
					<th rowspan="2">Número de personas</th>
					<th colspan="3">Género</th>
					<th colspan="4">Segmento Etario</th>
					<th colspan="2">Procedencia</th>
					<th colspan="2">Vulnerabilidad</th>
					<th colspan="3">Nacionalidad</th>
					<th rowspan="2">Acciones</th>
				</tr>
				<tr>
					<th>Hombre</th>
					<th>Mujer</th>
					<th>Otro</th>
					<th>Niños</th>
					<th>Jóvenes</th>
					<th>Adultos</th>
					<th>Adultos Mayores</th>
					<th>Rural</th>
					<th>Urbano</th>
					<th>Discapacidad</th>
					<th>Situación de Pobreza</th>

					<th>Chileno</th>
					<th>Migrante</th>
					<th>Pueblo originario</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
						<tr>
							<td><?php echo $datas[$i]['tipo'];?></td>
							<td><?php echo number_format($datas[$i]['publico_general'], '0', ',','.');?></td>
							<td><?php echo ($datas[$i]['aplica_sexo'] == "on" ? number_format($datas[$i]['sexo_masculino'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_sexo'] == "on" ? number_format($datas[$i]['sexo_femenino'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_sexo'] == "on" ? number_format($datas[$i]['sexo_otro'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_edad'] == "on" ? number_format($datas[$i]['edad_ninos'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_edad'] == "on" ? number_format($datas[$i]['edad_jovenes'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_edad'] == "on" ? number_format($datas[$i]['edad_adultos'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_edad'] == "on" ? number_format($datas[$i]['edad_adultos_mayores'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_procedencia'] == "on" ? number_format($datas[$i]['procedencia_rural'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_procedencia'] == "on" ? number_format($datas[$i]['procedencia_urbano'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_vulnerabilidad'] == "on" ? number_format($datas[$i]['vulnerabilidad_discapacidad'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_vulnerabilidad'] == "on" ? number_format($datas[$i]['vulnerabilidad_pobreza'], '0', ',','.'):"-");?></td>

							<td><?php echo ($datas[$i]['aplica_nacionalidad'] == "on" ? number_format($datas[$i]['nacionalidad_chileno'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_nacionalidad'] == "on" ? number_format($datas[$i]['nacionalidad_migrante'], '0', ',','.'):"-");?></td>
							<td><?php echo ($datas[$i]['aplica_nacionalidad'] == "on" ? number_format($datas[$i]['nacionalidad_pueblo'], '0', ',','.'):"-");?></td>
							<td>
								<?php
									if(canUpdateInitiatives()) {
										$data = base64_encode("data" . $datas[$i]['id']); ?>
										<!--a href="edit_initiative.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar'>
											<i class="glyphicon glyphicon-edit"></i></a-->

										<a href="#" class='btn btn-orange' title='Eliminar'
											data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'
											data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id_iniciativa']);?>'
											data-usuario='<?php echo noeliaEncode($_SESSION["nombre_usuario"]);?>'
											data-toggle="modal" data-target="#deleteParticipationReal">
											<i class="glyphicon glyphicon-trash"></i></a>
								<?php
									} ?>
							</td>
						</tr>
				<?php
					} ?>

			</tbody>
		</table>

  </div>
  <!-- /.box-body -->

	<script>

	$("#add_persons_type_1").submit(function( event ) {
		$('#add_persons_type_1').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_add_participation_real.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html("");


				if(datos.includes("Iniciativa guardada correctamente")) {
					$("#vg_tipo_asistente").selectpicker('val', '');
					$("#vg_publico_general").val("");

					$("#checkbox_sexo").prop('checked', false);
					$("#vg_sexo_masculino").val("");
					$("#vg_sexo_femenino").val("");
					$("#vg_sexo_otro").val("");
					$("#checkbox_edad").prop('checked', false);
					$("#vg_edad_ninos").val("");
					$("#vg_edad_jovenes").val("");
					$("#vg_edad_adultos").val("");
					$("#vg_edad_adultos_mayores").val("");
					$("#checkbox_procedencia").prop('checked', false);
					$("#vg_procedencia_rural").val("");
					$("#vg_procedencia_urbano").val("");
					$("#checkbox_vulnerabilidad").prop('checked', false);
					$("#vg_vulnerabilidad_pueblo").val("");
					$("#vg_vulnerabilidad_discapacidad").val("");
					$("#vg_vulnerabilidad_pobreza").val("");
					$("#checkbox_nacionalidad").prop('checked', false);
					$("#vg_nacionalidad_chileno").val("");
					$("#vg_nacionalidad_migrante").val("");
					$("#vg_nacionalidad_pueblo").val("");

					loadRealParticipation();
				}

			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$("#delete_participation_real").submit(function( event ) {
		$('#delete_participation_real').attr("disabled", true);
		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "./ajax_delete_participation_real.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#loader").html("Cargando...");
			},
			success: function(datos) {
				$("#loader").html("");

				if(datos.includes("correctamente")) {
					$('#deleteParticipationReal').modal('hide');

					var tipo = '<?php echo$tipo;?>';
					loadRealParticipation();
				}
			},
			error: function() {
				$("#loader").html("Error en el registro");
			}
		});

		event.preventDefault();
	})

	$('#deleteParticipationReal').on('show.bs.modal', function (event) {
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

		$('#checkbox_sexo').on('change', function() {
			$("#vg_sexo_masculino").prop('readonly', !this.checked);
			$("#vg_sexo_femenino").prop('readonly', !this.checked);
			$("#vg_sexo_otro").prop('readonly', !this.checked);
		});

		$('#checkbox_edad').on('change', function() {
			$("#vg_edad_ninos").prop('readonly', !this.checked);
			$("#vg_edad_jovenes").prop('readonly', !this.checked);
			$("#vg_edad_adultos").prop('readonly', !this.checked);
			$("#vg_edad_adultos_mayores").prop('readonly', !this.checked);
		});

		$('#checkbox_procedencia').on('change', function() {
			$("#vg_procedencia_rural").prop('readonly', !this.checked);
			$("#vg_procedencia_urbano").prop('readonly', !this.checked);
		});

		$('#checkbox_vulnerabilidad').on('change', function() {
			$("#vg_vulnerabilidad_pueblo").prop('readonly', !this.checked);
			$("#vg_vulnerabilidad_discapacidad").prop('readonly', !this.checked);
			$("#vg_vulnerabilidad_pobreza").prop('readonly', !this.checked);
		});

		$('#checkbox_nacionalidad').on('change', function() {
			$("#vg_nacionalidad_chileno").prop('readonly', !this.checked);
			$("#vg_nacionalidad_migrante").prop('readonly', !this.checked);
			$("#vg_nacionalidad_pueblo").prop('readonly', !this.checked);
		});
	</script>
