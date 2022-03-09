<!-- Modal -->
<div class="modal fade" id="finishInitiative" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Crear Iniciativa
				</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="edit_initiative_step3" name="edit_initiative_step3">
					<?php echo "<input type='hidden' value='".noeliaEncode($_SESSION['nombre_usuario'])."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='".noeliaEncode($datas[0]["id"])."' id='vg_id' name='vg_id' />"; ?>

					<div class="form-group">
						<label id="mensaje" class="col-sm-12 text-center"><h1><span class="glyphicon glyphicon-ok-sign text-orange"></span></h1> Su iniciativa de vinculación ha sido ingresada con éxito</label>
					</div>

					<div class="modal-footer">
						<a href="view_initiatives.php" class="btn btn-orange"><i class="fa fa-fw fa-chevron-right"></i> Cerrar</a>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
