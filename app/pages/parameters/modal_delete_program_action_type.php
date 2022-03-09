<!-- Modal -->
<div class="modal fade" id="deleteProgramActionType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Eliminar Estrategia
				</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="delete_program_action_type" name="delete_program_action_type">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='".noeliaEncode($id_program)."' id='vg_id_program' name='vg_id_program' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_id_mecanismo' name='vg_id_mecanismo' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_id' name='vg_id' />"; ?>

					<div class="form-group">
						<label id="mensaje" class="col-sm-12 text-center"><h1><span class="glyphicon glyphicon-exclamation-sign"></span></h1> Se eliminará el siguiente tipo de acción de esta linea de acción</label>
					</div>
					<div class="form-group">
						<label id="vg_nombre" class="col-sm-12 text-center">Nombre de Tipo de Acción</label>
						<label id="mensaje" class="col-sm-12 text-center">¿Continuar?</label>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-orange" id="delete_user">Aceptar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
