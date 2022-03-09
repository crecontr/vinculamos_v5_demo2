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
	$program = $_POST["id_programa"];

	//include_once("../../controller/medoo_programs_action_types.php");
	//$datas = getVisibleActionTypesByProgram($program);

	include_once("../../controller/medoo_invi_attributes.php");
	$datas = getVisibleMechanismByProgram($program);
?>

<div class="box-body table-responsive">
	<table id="tableAction" class="table table-bordered table-hover">
  	<thead>
      <tr>
        <th>Tipo de Acción</th>
        <th style="width:65px">Acciones</th>
      </tr>
    </thead>
		<tbody>
			<?php
				for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
					<tr>
	  			<td><?php echo $datas[$i]['nombre'];?></td>
					<td>
	  				<?php
	  					if(canDeleteParameters()) { ?>
								<a href="#" class='btn btn-default' title='Eliminar'
									data-id='<?php echo noeliaEncode($datas[$i]['id']);?>'
									data-id_mecanismo='<?php echo noeliaEncode($datas[$i]['id']);?>'
									data-id_programa='<?php echo noeliaEncode($program);?>'
									data-nombre='<?php echo $datas[$i]['nombre'];?>'
									data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
									data-toggle="modal" data-target="#deleteProgramActionType">
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
