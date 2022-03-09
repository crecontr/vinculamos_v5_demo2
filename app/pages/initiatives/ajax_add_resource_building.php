<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	session_start();
	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canUpdateInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}
	
	$institucion = getInstitution();

	if(false) {
		echo "<br>vg_initiative: " . noeliaDecode($_REQUEST['vg_initiative']);
		echo "<br>vg_source: " . noeliaDecode($_REQUEST['vg_source']);

		echo "<br>vg_type_building: " . $_REQUEST['vg_type_building'];
		echo "<br>vg_amount_building: " . $_REQUEST['vg_amount_building'];
		echo "<br>vg_usuario: " . noeliaDecode($_REQUEST['vg_usuario']);
	}

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_source']) && isset($_REQUEST['vg_type_building'])
 		&& isset($_REQUEST['vg_amount_building']) && isset($_REQUEST['vg_usuario'])) {
		$horas = intval($_REQUEST['vg_amount_building']);
		if($horas <= 0) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					La cantidad de horas no puede ser menor o igual a 0. Por favor revisar.
				</div>
		<?php
				return;
		}

		include("../../controller/medoo_resource_building.php");
		$building = getBuildingResourcesTypeByNombre($_REQUEST['vg_type_building']);

		if($building != null) {
			include_once("../../controller/medoo_initiatives_resources_building.php");
			$result = addBuildingResource(noeliaDecode($_REQUEST['vg_initiative']), noeliaDecode($_REQUEST['vg_source']),
				$_REQUEST['vg_type_building'], $_REQUEST['vg_amount_building'],
				intval($_REQUEST['vg_amount_building']) * $building[0]["puntaje"], noeliaDecode($_REQUEST['vg_usuario']));
		}

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Recurso guardado correctamente.
			</div>
	<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimos actualizar la información.
			</div>
	<?php
		}
	} else {
		echo "Falta info!";
	}
?>
