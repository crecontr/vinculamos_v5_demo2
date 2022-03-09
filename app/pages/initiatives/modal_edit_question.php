<!-- Modal -->
<div class="modal fade" id="editQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Editar Pregunta
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_editar_pregunta"></div>
				<form class="form-horizontal" method="post" id="edit_question" name="edit_question">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='". noeliaEncode($datas[0]["id"]). "' id='vg_initiative' name='vg_initiative' />"; ?>
					<?php echo "<input type='hidden' value='". ($survey[0]["id"]). "' id='vg_encuesta' name='vg_encuesta' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_id' name='vg_id' />"; ?>
					<div class="form-group">
						<label for="vg_titulo" class="col-sm-3 control-label">Titulo</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_titulo" name="vg_titulo"
								placeholder="Titulo" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_tipo_respuesta" class="col-sm-3 control-label">Tipo de respuesta</label>
						<div class="col-sm-8">
							<select class="selectpicker form-control" id="vg_tipo_respuesta" name="vg_tipo_respuesta"
								title="Tipo de respuesta" required data-live-search="true">
								<option value='Si o No'>Si o No</option>
								<option value='Escala 1 a 7'>Escala 1 a 7</option>
								<option value='Caritas 1 a 5'>Caritas 1 a 5</option>
								<option value='Area de Texto'>Area de Texto</option>
							</select>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-orange">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
