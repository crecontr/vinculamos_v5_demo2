<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");
	if(!canReadInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();
	$executionStatus = $_POST["executionStatus"];
	$fillmentStatus = $_POST["fillmentStatus"];

	$dateFrom = $_REQUEST['vg_fecha_inicio'];
	$dateTo = $_REQUEST['vg_fecha_finalizacion'];
	$college = $_REQUEST['vg_escuela'];
	$campus = $_REQUEST['vg_sede'];
	$carrer = $_REQUEST['vg_carrera'];
	$program = $_REQUEST['vg_programa'];

	include_once("../../controller/medoo_initiatives.php");
	$datasRaw = getVisibleInitiativesByInstitution($institucion, $executionStatus, $fillmentStatus,
		$dateFrom, $dateTo, $college, $campus, $program, $carrer);

	$datas = array();
	for ($i=0; $i < sizeof($datasRaw); $i++) {
		if(!in_array($datasRaw[$i], $datas)) {
			$datas[] = $datasRaw[$i];
		}
	}

	include_once("../../controller/medoo_programs.php");
	include_once("../../controller/medoo_invi_attributes.php");

	// ALGOTIRMO ODS
	include_once("../../controller/medoo_measures.php");
	include_once("../../controller/medoo_initiatives_ods.php");

	function eliminar_acentos($cadena){

		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);

		return $cadena;
	}
?>

<div class="box-body table-responsive">
	<table id="table" class="table table-bordered table-hover">
		<thead>
    	<tr>
      	<th>ID</th>
				<th>Nombre</th>
				<th>Linea de acción</th>
				<th>Mecanismo</th>
				<th style="width:210px">Acciones</th>
      </tr>
		</thead>
   	<tbody>
 			<?php
 				for($i=0 ; $i<sizeof($datas) ; $i++) {

					//$misMetas = getVisibleMeasuresByInitiative($datas[$i]['id']);
					//updateODSByInitiative($datas[$i]['id'], $misMetas, "superadmin");

					/*
					$salida = array();
			    $entrada = eliminar_acentos($datas[$i]["nombre"] . " " . $datas[$i]["objetivo"] . " " . $datas[$i]["descripcion"] . " " . $datas[$i]["impacto_logrado_interno"]);
			    //exec("python /Applications/MAMP/htdocs/vinculamos_v5_ucm/test/AlgoritmoODS.py '$entrada'", $salida);
					exec("python /home/vinculam/public_html/algoritmoODS/AlgoritmoODS.py '$entrada'", $salida);
					$arrayMetas = array();
			    $arrayObjetivos = array();
			    for($j = 0; $j < count($salida); $j++){
			      if(substr($salida[$j], 0, 5) === "Meta ") {
			        $arrayMetas[] = substr($salida[$j], 5);
			      }
			      if(substr($salida[$j], 0, 4) === "ODS ") {
			        $idODS = substr(strtok($salida[$j], ":"), 4);
			        $ods["nombre"] = $idODS;
			        for ($x=0; $x < sizeof($arrayMetas); $x++) {
			          $metaX = $arrayMetas[$x];
			          $metaX = str_replace($idODS.".", "", $metaX);
			          $idMeta = strtok($metaX, ":");
			          $arrayMetas[$x] = $idMeta;
			        }
			        $ods["metas"] = $arrayMetas;
			        $arrayObjetivos[] = $ods;
			        $arrayMetas = array();
			      }
			    }
					updateODSByInitiativeFromPython($datas[$i]['id'], $arrayObjetivos, "superadmin");
					*/

					?>
 					<tr>
      			<td><?php echo $datas[$i]['id'];?></td>
      			<td><?php echo $datas[$i]['nombre'];?></td>
						<td><?php echo $datas[$i]['programa_nombre'];?></td>
      			<td><?php echo $datas[$i]['mecanismo_nombre'];?></td>

      			<td width="230">
							<?php
								$data = noeliaEncode("data" . $datas[$i]['id']);
      					if(canUpdateInitiatives()) {
      						$data = noeliaEncode("data" . $datas[$i]['id']); ?>
									<div class="btn-group">
										<button type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown" title='Opciones'>
											<i class="glyphicon glyphicon-triangle-bottom"></i>
										</button>
										<ul class="dropdown-menu">
											<li>
												<a href="add_attendance_list.php?data=<?php echo$data;?>" title='Lista asistencia'>
													<i class="fa fa-user-plus"></i> Agregar lista asistencia
												</a>
											</li>
											<li>
												<a href="add_surveys.php?data=<?php echo$data;?>" title='Encuestas'>
													<i class="fa fa-file-text-o"></i> Encuestas
												</a>
											</li>

											<li>
												<a href="add_evaluation.php?data=<?php echo$data;?>" title='Evaluaciones'>
													<i class="fa fa-file-text-o"></i> Evaluación
												</a>
											</li>

											<?php
											 	if(canSuperviseInitiatives()) { ?>
													<li>
														<a data-toggle="modal" data-target="#editStatusExecution"
															data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
															data-estado_ejecucion ='<?php echo $datas[$i]['estado_ejecucion']?>'
															title='Estado Ejecución'>
															<i class="fa fa-flag"></i> Actualizar ejecución
														</a>
													</li>

													<!--li>
														<a data-toggle="modal" data-target="#editStatusFillment"
															data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
															data-estado_completitud ='<?php echo $datas[$i]['estado_completitud']?>'
															title='Estado Completitud'>
															<i class="fa fa-edit"></i> Actualizar completitud
														</a>
													</li-->
											<?php
												} ?>

											<?php
											 	if(canDeleteInitiatives()) { ?>
													<li>
														<a data-toggle="modal" data-target="#deleteInitiative"
															data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
															data-nombre='<?php echo $datas[$i]['nombre'];?>'
															data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
															title='Estado Ejecución'>
															<i class="fa fa-trash"></i>Eliminar iniciativa
														</a>
													</li>

											<?php
												} ?>
										</ul>
									</div>
							<?php
								} ?>

      				<?php
      					if(canReadInitiatives()) {
      						$data = noeliaEncode("data" . $datas[$i]['id']); ?>
									<a href="review_initiative.php?data=<?php echo$data;?>" class='btn btn-orange' title='Ver iniciativa'>
										<i class="glyphicon glyphicon-eye-open"></i>
									</a>

									<a class="btn btn-orange" valign="right" data-toggle="modal" title='Calcular INVI'
										data-iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
										data-usuario='<?php echo ($_SESSION["nombre_usuario"]);?>'
										data-target="#calculateScoreVCM">
											<i class="fa fa-tachometer"></i>
									</a>

									<a href="edit_initiative_evidences.php?data=<?php echo$data;?>" class='btn btn-orange' title='Ver evidencia'>
										<i class="glyphicon glyphicon-paperclip"></i>
									</a>
							<?php
								} ?>

							<?php
      					if(canUpdateInitiatives()) { ?>

									<a href="edit_initiative_step1.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar iniciativa'>
										<i class="glyphicon glyphicon-edit"></i>
									</a>
									<!--a href="add_attendance_list.php?data=<?php echo$data;?>" class='btn btn-orange' title='Lista asistencia'>
										<i class="glyphicon glyphicon-list"></i>
									</a>
									<a href="add_survey.php?data=<?php echo$data;?>" class='btn btn-orange' title='Agregar encuesta'>
										<i class="glyphicon glyphicon-list-alt"></i>
									</a-->
							<?php
								} ?>

							<?php
      					if(canDeleteInitiatives() && false) { ?>
									<a href="#" class='btn btn-blue' title='Eliminar'
										data-id='<?php echo base64_encode($datas[$i]['id']);?>'
										data-nombre='<?php echo $datas[$i]['nombre'];?>'
										data-nombre_usuario='<?php echo $_SESSION["nombre_usuario"];?>'
										data-toggle="modal" data-target="#deleteProcedure">
										<i class="glyphicon glyphicon-trash"></i></a>
							<?php
								} ?>

							<?php
      					switch ($datas[$i]['estado']) {
      						case 'Aprobado':
      							echo "<i class='text-green fa fa-check'></i>";
      							break;
									case 'Rechazado':
      							echo "<i class='text-red fa fa-close'></i>";
      							break;
								}
							?>

							<?php
								$idEjecucion = ("ejecucion" . $datas[$i]['id']);
								echo "<small class='label label-primary' id='$idEjecucion'>" . $datas[$i]['estado_ejecucion'] . "</small> &nbsp;";

								$idCompletitud = ("completitud" . $datas[$i]['id']);
								echo "<small class='label label-info' id='$idCompletitud'>" . $datas[$i]['estado_completitud'] . "</small> &nbsp;";

							?>
      			</td>
          </tr>
 			<?php
 				} ?>

  	</tbody>
	</table>
</div>
<!-- /.box-body -->
