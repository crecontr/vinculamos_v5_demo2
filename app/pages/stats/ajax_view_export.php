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

	include_once("../../controller/medoo_initiatives.php");
	$datas = getVisibleInitiativesByInstitutionFullFilters($institucion, null, $executionStatus, $fillmentStatus);

	include_once("../../controller/medoo_invi.php");
	include_once("../../controller/medoo_initiatives_ods.php");
?>

<div class="box-body table-responsive">
	<table id="table" class="table table-bordered table-hover">
		<thead>
    	<tr>
      	<th>ID</th>
				<th>Nombre</th>
				<th>Fecha inicio</th>
				<th>Fecha finalización</th>
				<th>Responsable</th>
				<th>Responsable cargo</th>
				<th>Formato implementación</th>
				<th>Entorno detalle</th>
				<th>Objetivo</th>
				<th>Descripcion</th>
				<th>Impacto esperado</th>
				<th>Impacto logrado interno</th>
				<th>Impacto logrado externo</th>
				<th>Estado</th>
				<th>Linea de acción</th>
				<th>Tipo de acción</th>
				<th>Frecuencia</th>
				<th>Linea de acción secundaria</th>
				<th>Unidad institucional</th>
				<th>Sede</th>
				<th>Paises</th>
				<th>Regiones</th>
				<th>Comunas</th>
				<th>INVI Total</th>
				<th>Mecanismo etiqueta</th>
				<th>Mecanismo valor</th>
				<th>Cobertura Territorialidad etiqueta</th>
				<th>Cobertura Territorialidad valor</th>
				<th>Cobertura Pertinencia etiqueta</th>
				<th>Cobertura Pertinencia valor</th>
				<th>Cobertura Cantidad etiqueta</th>
				<th>Cobertura Cantidad valor</th>
				<th>Frecuencia etiqueta</th>
				<th>Frecuencia valor</th>
				<th>Evaluación interna etiqueta</th>
				<th>Evaluación interna valor</th>
				<th>Evaluación externa etiqueta</th>
				<th>Evaluación externa valor</th>
				<th>Evaluación valor</th>
				<th>ODS</th>
			</tr>
		</thead>
   	<tbody>
 			<?php
 				for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
 					<tr>
      			<td><?php echo $datas[$i]['id'];?></td>
						<td><?php echo $datas[$i]['nombre'];?></td>
						<td><?php echo $datas[$i]['fecha_inicio'];?></td>
						<td><?php echo $datas[$i]['fecha_finalizacion'];?></td>
						<td><?php echo $datas[$i]['responsable'];?></td>
						<td><?php echo $datas[$i]['responsable_cargo'];?></td>
						<td><?php echo $datas[$i]['formato_implementacion'];?></td>
						<td><?php echo $datas[$i]['entorno_detalle'];?></td>
						<td><?php echo $datas[$i]['objetivo'];?></td>
						<td><?php echo $datas[$i]['descripcion'];?></td>
						<td><?php echo $datas[$i]['impacto_esperado'];?></td>
						<td><?php echo $datas[$i]['impacto_logrado_interno'];?></td>
						<td><?php echo $datas[$i]['impacto_logrado_externo'];?></td>
						<td><?php echo $datas[$i]['estado'];?></td>
						<td><?php echo $datas[$i]['programa_nombre'];?></td>
						<td><?php echo $datas[$i]['mecanismo_nombre'];?></td>
						<td><?php echo $datas[$i]['frecuencia_nombre'];?></td>
						<td>
							<?php
							 	$datas_programs = $datas[$i]["programa_secundarios"];
								$programSecondaryText = "";
								for($j=0 ; $j<sizeof($datas_programs) ; $j++) {
									$programSecondaryText .= $datas_programs[$j]["nombre"];
									if($j<(sizeof($datas_programs)-1))
										$programSecondaryText .= ", ";
								}
								echo $programSecondaryText == "" ? "No":$programSecondaryText;
							?>
						</td>

						<td>
							<?php
							 	$datas_collegues = $datas[$i]["escuelas"];
								$colleguesText = "";
								for($j=0 ; $j<sizeof($datas_collegues) ; $j++) {
									$colleguesText .= $datas_collegues[$j]["nombre"];
									if($j<(sizeof($datas_collegues)-1))
										$colleguesText .= ", ";
								}
								echo $colleguesText == "" ? "No aplica para esta actividad":$colleguesText;
							?>
						</td>

						<td>
							<?php
							 	$datas_campus = $datas[$i]["sedes"];
								$campusText = "";
								for($j=0 ; $j<sizeof($datas_campus) ; $j++) {
									$campusText .= $datas_campus[$j]["nombre"];
									if($j<(sizeof($datas_campus)-1))
										$campusText .= ", ";
								}
								echo $campusText == "" ? "Nivel Central":$campusText;
							?>
						</td>

						<td>
							<?php
							 	$datas_countries = $datas[$i]["paises"];
								$countriesText = "";
								for($j=0 ; $j<sizeof($datas_countries) ; $j++) {
									$countriesText .= $datas_countries[$j]["nombre"];
									if($j<(sizeof($datas_countries)-1))
										$countriesText .= ", ";
								}
								echo $countriesText == "" ? "No Aplica":$countriesText;
							?>
						</td>
						<td>
							<?php
							 	$datas_regions = $datas[$i]["regiones"];
								$regionsText = "";
								for($j=0 ; $j<sizeof($datas_regions) ; $j++) {
									$regionsText .= $datas_regions[$j]["nombre"];
									if($j<(sizeof($datas_regions)-1))
										$regionsText .= ", ";
								}
								echo $regionsText == "" ? "":$regionsText;
							?>
						</td>
						<td>
							<?php
							 	$datas_communes = $datas[$i]["comunas"];
								$communesText = "";
								for($j=0 ; $j<sizeof($datas_communes) ; $j++) {
									$communesText .= $datas_communes[$j]["nombre"];
									if($j<(sizeof($datas_communes)-1))
										$communesText .= ", ";
								}
								echo $communesText == "" ? "":$communesText;
							?>
						</td>

						<?php
							$inviResult = calculateInviByInitiative($datas[$i]['id']);
						?>
						<td><?php echo $inviResult["invi"]["total"];?></td>
						<td><?php echo $inviResult["mecanismo"]["etiqueta"];?></td>
						<td><?php echo $inviResult["mecanismo"]["valor"];?></td>
						<td><?php echo $inviResult["cobertura_territorialidad"]["etiqueta"];?></td>
						<td><?php echo $inviResult["cobertura_territorialidad"]["valor"];?></td>
						<td><?php echo $inviResult["cobertura_pertinencia"]["etiqueta"];?></td>
						<td><?php echo $inviResult["cobertura_pertinencia"]["valor"];?></td>
						<td><?php echo $inviResult["cobertura_cantidad"]["etiqueta"];?></td>
						<td><?php echo $inviResult["cobertura_cantidad"]["valor"];?></td>
						<td><?php echo $inviResult["frecuencia"]["etiqueta"];?></td>
						<td><?php echo $inviResult["frecuencia"]["valor"];?></td>
						<td><?php echo $inviResult["evaluacionInterna"]["etiqueta"];?></td>
						<td><?php echo $inviResult["evaluacionInterna"]["valor"];?></td>
						<td><?php echo $inviResult["evaluacionExterna"]["etiqueta"];?></td>
						<td><?php echo $inviResult["evaluacionExterna"]["valor"];?></td>
						<td><?php echo $inviResult["evaluacion"]["valor"];?></td>


						<?php
						 	$myObjetives = getODSByInitiative($datas[$i]['id']);
						?>
						<td>
							<?php
							 	$objetivesText = "";
								for($j=0 ; $j<sizeof($myObjetives) ; $j++) {
									$objetivesText .= $myObjetives[$j]["nombre"];
									if($j<(sizeof($myObjetives)-1))
										$objetivesText .= ", ";
								}
								echo $objetivesText == "" ? "":$objetivesText;
							?>
						</td>
          </tr>
 			<?php
 				} ?>

  	</tbody>
	</table>
</div>
<!-- /.box-body -->
