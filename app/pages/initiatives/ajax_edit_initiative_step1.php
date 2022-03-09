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
		echo "<br>vg_nombre: " . $_REQUEST['vg_nombre'];
		echo "<br>vg_fecha_inicio: " . $_REQUEST['vg_fecha_inicio'];
		echo "<br>vg_fecha_finalizacion: " . $_REQUEST['vg_fecha_finalizacion'];
		echo "<br>vg_autor: " . noeliaDecode($_REQUEST['vg_autor']);

		echo "<br>vg_escuela: " . $_REQUEST['vg_escuela'];
		for ($i=0; $i < sizeof($_REQUEST['vg_escuela']); $i++) {
			echo "<br>->vg_escuela [$i]: " . $_REQUEST['vg_escuela'][$i];
		}

		echo "<br>vg_sede: " . $_REQUEST['vg_sede'];
		for ($i=0; $i < sizeof($_REQUEST['vg_sede']); $i++) {
			echo "<br>->vg_sede [$i]: " . $_REQUEST['vg_sede'][$i];
		}

		echo "<br>vg_carrera: " . $_REQUEST['vg_carrera'];
		for ($i=0; $i < sizeof($_REQUEST['vg_carrera']); $i++) {
			echo "<br>->vg_carrera [$i]: " . $_REQUEST['vg_carrera'][$i];
		}

		echo "<br>vg_programa: " . $_REQUEST['vg_programa'];

		echo "<br>vg_programa_estrategia: " . $_REQUEST['vg_programa_estrategia'];
		for ($i=0; $i < sizeof($_REQUEST['vg_programa_estrategia']); $i++) {
			echo "<br>->vg_programa_estrategia [$i]: " . $_REQUEST['vg_programa_estrategia'][$i];
		}

		echo "<br>vg_programa_secundario: " . $_REQUEST['vg_programa_secundario'];
		for ($i=0; $i < sizeof($_REQUEST['vg_programa_secundario']); $i++) {
			echo "<br>->vg_programa_secundario [$i]: " . $_REQUEST['vg_programa_secundario'][$i];
		}

		echo "<br>vg_mecanismo: " . $_REQUEST['vg_mecanismo'];

		echo "<br>vg_gestor_vinculo: " . $_REQUEST['vg_gestor_vinculo'];
		echo "<br>vg_encargado: " . $_REQUEST['vg_encargado'];
		echo "<br>vg_encargado_cargo: " . $_REQUEST['vg_encargado_cargo'];

		echo "<br>vg_formato_implementacion: " . $_REQUEST['vg_formato_implementacion'];
		echo "<br>vg_frecuencia: " . $_REQUEST['vg_frecuencia'];
		echo "<br>vg_convenios: " . $_REQUEST['vg_convenios'];
		for ($i=0; $i < sizeof($_REQUEST['vg_convenios']); $i++) {
			echo "<br>->vg_convenios [$i]: " . $_REQUEST['vg_convenios'][$i];
		}

		echo "<br>vg_pais: " . $_REQUEST['vg_pais'];
		for ($i=0; $i < sizeof($_REQUEST['vg_pais']); $i++) {
			echo "<br>->vg_pais [$i]: " . $_REQUEST['vg_pais'][$i];
		}

		echo "<br>vg_region: " . $_REQUEST['vg_region'];
		for ($i=0; $i < sizeof($_REQUEST['vg_region']); $i++) {
			echo "<br>->vg_region [$i]: " . $_REQUEST['vg_region'][$i];
		}

		echo "<br>vg_comuna: " . $_REQUEST['vg_comuna'];
		for ($i=0; $i < sizeof($_REQUEST['vg_comuna']); $i++) {
			echo "<br>->vg_comuna [$i]: " . $_REQUEST['vg_comuna'][$i];
		}
		return;
	}

	if( isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_nombre']) && isset($_REQUEST['vg_fecha_inicio']) &&
		isset($_REQUEST['vg_fecha_finalizacion']) && isset($_REQUEST['vg_autor']) ) {

		include_once("../../controller/medoo_initiatives.php");

		$result = editInitiativeStep1(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_nombre'],
			$_REQUEST['vg_fecha_inicio'], $_REQUEST['vg_fecha_finalizacion'], noeliaDecode($_REQUEST['vg_autor']));

		editInitiativeProgramMechanismFrecuency($result[0]["id"], $_REQUEST['vg_programa'],
		$_REQUEST['vg_mecanismo'], $_REQUEST['vg_frecuencia'], noeliaDecode($_REQUEST['vg_autor']));

		editInitiativeAttributesStep1($result[0]["id"], $_REQUEST['vg_gestor_vinculo'], $_REQUEST['vg_encargado'],
	    $_REQUEST['vg_encargado_cargo'], $_REQUEST['vg_formato_implementacion'], noeliaDecode($_REQUEST['vg_autor']));

		editInitiativePerformingPublic($result[0]["id"], $_REQUEST['vg_ejecutante_estudiantes'], $_REQUEST['vg_ejecutante_docentes'],
			$_REQUEST['vg_ejecutante_colaboradores'], $_REQUEST['vg_ejecutante_otros'], noeliaDecode($_REQUEST['vg_autor']));

		editInitiativeASfields($result[0]["id"], $_REQUEST['vg_as_carrera'], $_REQUEST['vg_as_seccion'],
	    $_REQUEST['vg_as_codigo_modulo'], $_REQUEST['vg_as_docente'], noeliaDecode($_REQUEST['vg_autor']));

		include_once("../../controller/medoo_colleges.php");
		updateCollegesByInitiative($result[0]["id"], $_REQUEST['vg_escuela'], noeliaDecode($_REQUEST['vg_autor']));

		include_once("../../controller/medoo_campus.php");
		updateCampusByInitiative($result[0]["id"], $_REQUEST['vg_sede'], noeliaDecode($_REQUEST['vg_autor']));

		include_once("../../controller/medoo_carrers.php");
		updateCarrersByInitiative($result[0]["id"], $_REQUEST['vg_carrera'], noeliaDecode($_REQUEST['vg_autor']));

		include_once("../../controller/medoo_programs_strategies.php");
		updateProgramStrategiesByInitiative($result[0]["id"], $_REQUEST['vg_programa'], $_REQUEST['vg_programa_estrategia'], noeliaDecode($_REQUEST['vg_autor']));

		include_once("../../controller/medoo_programs.php");
		updateProgramsByInitiative($result[0]["id"], $_REQUEST['vg_programa_secundario'], noeliaDecode($_REQUEST['vg_autor']));

		include_once("../../controller/medoo_covenants.php");
		updateCovenantsByInitiative($result[0]["id"], $_REQUEST['vg_convenios'], noeliaDecode($_REQUEST['vg_autor'])) ;

		include_once("../../controller/medoo_geographic.php");
		updateCountriesByInitiative($result[0]["id"], $_REQUEST['vg_pais'], noeliaDecode($_REQUEST['vg_autor']));
		updateRegionsByInitiative($result[0]["id"], $_REQUEST['vg_region'], noeliaDecode($_REQUEST['vg_autor']));
		updateCommunesByInitiative($result[0]["id"], $_REQUEST['vg_comuna'], noeliaDecode($_REQUEST['vg_autor']));

		if($result != null) {
			echo noeliaEncode("data" . $result[0]["id"]);
		} else {
			echo "-1";
		}
	} else {
		echo "Falta info!";
	}
?>
