<!-- Modal -->
<div class="modal fade" id="addCarrer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Nueva Carrera
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_agregar"></div>
				<form class="form-horizontal" method="post" id="add_carrer" name="add_carrer">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<div class="form-group">
						<label for="ht_nombre" class="col-sm-3 control-label">Nombre</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
								placeholder="Nombre" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="ht_apellido" class="col-sm-3 control-label">Descripción</label>
						<div class="col-sm-8">
							<textarea class="form-control textarea" placeholder="Descripción" id="vg_descripcion" name="vg_descripcion"
									style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="ht_nombre" class="col-sm-3 control-label">Director</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_director" name="vg_director"
								placeholder="Director" maxlength="100">
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
