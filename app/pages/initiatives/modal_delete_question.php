<!-- Modal -->
<div class="modal fade" id="deleteQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Eliminar Pregunta
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_eliminar"></div>
				<p class="text-center">
					<strong>Se eliminará la pregunta seleccionada.<br>¿Desea continuar?</strong>
				</p>
				<form class="form-horizontal" method="post" id="delete_question" name="delete_question">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<?php echo "<input type='hidden' value='". noeliaEncode($datas[0]["id"]). "' id='vg_initiative' name='vg_initiative' />"; ?>
					<?php echo "<input type='hidden' value='". ($survey[0]["id"]). "' id='vg_encuesta' name='vg_encuesta' />"; ?>
					<?php echo "<input type='hidden' value='' id='vg_id' name='vg_id' />"; ?>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-orange">Continuar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
