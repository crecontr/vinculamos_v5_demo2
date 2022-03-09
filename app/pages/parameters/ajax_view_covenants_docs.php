<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");
	if(!canReadParameters()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}
	
	$institucion = getInstitution();
	$covenant = $_POST["id_covenant"];

	include_once("../../controller/medoo_covenants_docs.php");
	$datas = getVisibleCovenantDocsByCovenant($covenant);
?>

<div class="box-body table-responsive">
	<table id="table" class="table table-bordered table-hover">
  	<thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
				<th style="width:65px">Acciones</th>
      </tr>
    </thead>
		<tbody>
			<?php
				for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
					<tr>
	  			<td><?php echo $datas[$i]['nombre'];?></td>
	  			<td><?php echo $datas[$i]['descripcion'];?></td>
					<td width="130">
	  				<?php
	  					if(canReadParameters()) { ?>
								<a href="<?php echo $datas[$i]['archivo'];?>" class='btn btn-orange' title='Eliminar'
									target="_blank" data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'>
									<i class="glyphicon glyphicon-eye-open"></i>
								</a>
						<?php
							} ?>

						<?php
	  					if(canUpdateParameters()) { ?>
								<a href="#" class='btn btn-orange' title='Eliminar'
									data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'
									data-nombre='<?php echo $datas[$i]['nombre'];?>'
									data-descripcion='<?php echo $datas[$i]['descripcion'];?>'
									data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
									data-toggle="modal" data-target="#editCovenantDoc">
									<i class="glyphicon glyphicon-edit"></i></a>
						<?php
							} ?>

						<?php
	  					if(canDeleteParameters()) { ?>
								<a href="#" class='btn btn-default' title='Eliminar'
									data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'
									data-nombre='<?php echo $datas[$i]['nombre'];?>'
									data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
									data-toggle="modal" data-target="#deleteCovenantDoc">
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
