<!-- Modal -->
<div class="modal fade" id="addProgramActionType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Nuevo Tipo de Acción
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_agregar_tipo"></div>
				<form class="form-horizontal" method="post" id="add_program_action_type" name="add_program_action_type">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='".noeliaEncode($id_program)."' id='vg_id_program' name='vg_id_program' />"; ?>
					<div class="form-group">
						<label for="vg_tipo_accion" class="col-sm-3 control-label">Tipo de Acción</label>
						<div class="col-sm-8">
							<select class="selectpicker form-control" id="vg_mecanismo" name="vg_mecanismo"
								title="Tipo de Acción" data-live-search="true">
								<?php
									foreach($mechanisms as $mechanism) {
										echo "<option value=" . $mechanism['id'] ." data-subtext='".$mechanism['descripcion']."'>" . $mechanism['nombre']. "</option>";
									}
								?>
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
