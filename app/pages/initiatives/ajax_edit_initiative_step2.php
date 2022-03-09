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

	if( isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_entorno']) && isset($_REQUEST['vg_objetivo'])
		&& isset($_REQUEST['vg_descripcion']) && isset($_REQUEST['vg_usuario'])) {

		include_once("../../controller/medoo_initiatives.php");
		$result = editInitiativeStep2(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_entorno_detalle'],
			$_REQUEST['vg_descripcion'], $_REQUEST['vg_objetivo'], $_REQUEST['vg_impacto_esperado'],
			$_REQUEST['vg_resultado_esperado'], noeliaDecode($_REQUEST['vg_usuario']));

		editInitiativeAchievedImpacts(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_impacto_interno'],
			$_REQUEST['vg_impacto_externo'], noeliaDecode($_REQUEST['vg_usuario']));

		include_once("../../controller/medoo_environment.php");
		updateEnvironmentsByInitiative(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_entorno'], noeliaDecode($_REQUEST['vg_usuario']));

		include_once("../../controller/medoo_environment_sub.php");
		updateEnvironmentsSubsByInitiative(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_entorno_sub'], noeliaDecode($_REQUEST['vg_usuario']));

		include_once("../../controller/medoo_impact_internal.php");
		updateInternalImpactByInitiative(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_tipo_impacto_interno'], noeliaDecode($_REQUEST['vg_usuario']));

		include_once("../../controller/medoo_impact_external.php");
		updateExternalImpactByInitiative(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_tipo_impacto_externo'], noeliaDecode($_REQUEST['vg_usuario']));


		include_once("../../controller/medoo_measures.php");
		$misMetas = getVisibleMeasuresByInitiative(noeliaDecode($_REQUEST['vg_id']));
		include_once("../../controller/medoo_initiatives_ods.php");
		updateODSByInitiative(noeliaDecode($_REQUEST['vg_id']), $misMetas, noeliaDecode($_REQUEST['vg_usuario']));

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Iniciativa guardada correctamente.
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
