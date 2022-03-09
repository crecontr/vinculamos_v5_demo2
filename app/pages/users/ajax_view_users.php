<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");
	if(!canReadUsers()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institution = getInstitution();

	include_once("../../controller/medoo_users.php");
	$datas = getVisibleUsersByInstitution($institution);
?>

<div class="box-body table-responsive">
	<table id="table" class="table table-bordered table-hover">
  	<thead>
      <tr>
        <th>Nombre Completo</th>
        <th>Alias</th>
        <th>Teléfono</th>
        <th>Correo Electrónico</th>
        <th>Perfil</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
 		<tbody>
 			<?php
 				for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
 					<tr>
      			<td><?php echo $datas[$i]['nombre'] . " " . $datas[$i]['apellido'];?></td>
      			<td><?php echo $datas[$i]['nombre_usuario'];?></td>
      			<td><?php echo $datas[$i]['telefono'];?></td>
      			<td><?php echo $datas[$i]['correo_electronico'];?></td>
      			<td><?php echo $datas[$i]['perfil'];?></td>
      			<td><?php echo ($datas[$i]['estado'] == 1) ? "Activo" : "Inactivo";?></td>
      			<td>
      				<?php
      					if(canUpdateUsers()) {
									$data = noeliaEncode("data" . $datas[$i]['nombre_usuario']); ?>
									<a href="edit_user.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar'>
										<i class="glyphicon glyphicon-cog"></i></a>
							<?php
								} ?>

							<?php
            		if(canDeleteUsers()) { ?>
									<a href="#" class='btn btn-default' title='Eliminar'
										data-id='<?php echo noeliaEncode($datas[$i]['nombre_usuario']);?>'
										data-alias='<?php echo $datas[$i]['nombre_usuario'];?>'
										data-nombre='<?php echo $datas[$i]['nombre'];?>'
										data-apellido='<?php echo $datas[$i]['apellido'];?>'
										data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
										data-toggle="modal" data-target="#deleteUser">
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
