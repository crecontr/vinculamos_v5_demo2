<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<i class='glyphicon glyphicon-edit'></i> Nuevo Usuario
				</h4>
			</div>
			<div class="modal-body">
				<div id="resultados_modal_agregar"></div>
				<form class="form-horizontal" method="post" id="add_user" name="add_user">
					<?php echo "<input type='hidden' value='".$_SESSION['nombre_usuario']."' id='vg_usuario' name='vg_usuario' />"; ?>
					<div class="form-group">
						<label for="vg_nombre" class="col-sm-4 control-label">Nombre <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_nombre" name="vg_nombre"
								placeholder="Nombre" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_apellido" class="col-sm-4 control-label">Apellido <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_apellido" name="vg_apellido"
								placeholder="Apellido" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_telefono" class="col-sm-4 control-label">Teléfono</label>
						<div class="col-sm-8">
							<input type="tel" class="form-control" id="vg_telefono" name="vg_telefono"
								placeholder="Teléfono" maxlength="100">
						</div>
					</div>
					<div class="form-group">
						<label for="vg_correo_electronico" class="col-sm-4 control-label">Correo Electrónico</label>
						<div class="col-sm-8">
							<input type="email" class="form-control" id="vg_correo_electronico" name="vg_correo_electronico"
							placeholder="Correo Electrónico" maxlength="100">
						</div>
					</div>
					<div class="form-group">
						<label for="vg_perfil" class="col-sm-4 control-label">Perfil Usuario <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<select class="selectpicker form-control" id="vg_perfil" name="vg_perfil" required title="Perfil Usuario">
								<?php
									foreach($profiles as $profile) {
										echo "<option value=" . noeliaEncode($profile['id_perfil']) .">" . $profile['nombre']. "</option>";
									}
								?>
                  			</select>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_nombre" class="col-sm-4 control-label">Nombre de Usuario <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="vg_nombre_usuario" name="vg_nombre_usuario"
								placeholder="Nombre de Usuario" maxlength="50" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_contrasenia_1" class="col-sm-4 control-label">Contraseña <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="vg_contrasenia_1" name="vg_contrasenia_1"
								placeholder="Contraseña" minlength="4" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_contrasenia_2" class="col-sm-4 control-label">Repetir Contraseña <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="vg_contrasenia_2" name="vg_contrasenia_2"
								placeholder="Reperir Contraseña" minlength="4" maxlength="100" required>
						</div>
					</div>
					<div class="form-group">
						<label for="vg_perfil" class="col-sm-4 control-label">Estado <span class="text-red">*</span></label>
						<div class="col-sm-8">
							<select class="selectpicker form-control" id="vg_estado" name="vg_estado" required title="Estado">
								<option value="1">Activo</option>";
								<option value="0">Inactivo</option>";
              </select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
