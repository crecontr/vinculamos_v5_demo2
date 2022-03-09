<!-- Modal -->
<div class="modal fade" id="editSurvey" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Editar Encuesta
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_editar_encuesta"></div>
				<form class="form-horizontal" method="post" id="edit_survey" name="edit_survey">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='". noeliaEncode($datas[0]["id"]). "' id='vg_initiative' name='vg_initiative' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_id' name='vg_id' />"; ?>
					<div class="form-group">
						<label for="vg_titulo" class="col-sm-3 control-label">Titulo</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_titulo" name="vg_titulo"
								placeholder="Titulo" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_descripcion" class="col-sm-3 control-label">Descripción</label>
						<div class="col-sm-8">
							<textarea class="form-control textarea" placeholder="Descripción" id="vg_descripcion" name="vg_descripcion"
									style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;"></textarea>
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
