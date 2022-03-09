<!-- Modal -->
<div class="modal fade" id="editStatusExecution" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Editar Estado de Ejecución
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_estado_ejecucion"></div>
				<form class="form-horizontal" method="post" id="edit_execution_status" name="edit_execution_status">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_initiative' name='vg_initiative' />"; ?>
					<div class="form-group">
						<label for="vg_tipo_respuesta" class="col-sm-4 control-label">Estado de Ejecución</label>
						<div class="col-sm-7">
							<select class="selectpicker form-control" id="vg_estado_ejecucion" name="vg_estado_ejecucion"
								title="Estado de Ejecución" required data-live-search="true">
								<?php
									foreach($executionStatus as $executionState) {
										echo "<option value='" . $executionState['nombre'] . "'>" . $executionState['nombre']. "</option>";
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
