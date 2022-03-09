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

	// vg_autor, vg_id
	// vg_tipo_asistente, vg_publico_general,
	// checkbox_sexo, vg_sexo_masculino, vg_sexo_femenino, vg_sexo_otro
	// checkbox_edad, vg_edad_ninos, vg_edad_jovenes, vg_edad_adultos, vg_edad_adultos_mayores
	// checkbox_procedencia, vg_procedencia_rural, vg_procedencia_urbano
	// checkbox_vulnerabilidad, vg_vulnerabilidad_pueblo, vg_vulnerabilidad_discapacidad, vg_vulnerabilidad_pobreza
	if(false) {
		echo "<br> vg_autor: " . $_REQUEST['vg_autor'];
		echo "<br> vg_id: " . $_REQUEST['vg_id'];
		echo "<br> vg_tipo_asistente: " . $_REQUEST['vg_tipo_asistente'];
		echo "<br> vg_publico_general: " . $_REQUEST['vg_publico_general'];
		echo "<br> checkbox_sexo: " . $_REQUEST['checkbox_sexo'];
		echo "<br> vg_sexo_masculino: " . $_REQUEST['vg_sexo_masculino'];
		echo "<br> vg_sexo_femenino: " . $_REQUEST['vg_sexo_femenino'];
		echo "<br> vg_sexo_otro: " . $_REQUEST['vg_sexo_otro'];
		echo "<br> checkbox_edad: " . $_REQUEST['checkbox_edad'];
		echo "<br> vg_edad_ninos: " . $_REQUEST['vg_edad_ninos'];
		echo "<br> vg_edad_jovenes: " . $_REQUEST['vg_edad_jovenes'];
		echo "<br> vg_edad_adultos: " . $_REQUEST['vg_edad_adultos'];
		echo "<br> vg_edad_adultos_mayores: " . $_REQUEST['vg_edad_adultos_mayores'];
		echo "<br> checkbox_procedencia: " . $_REQUEST['checkbox_procedencia'];
		echo "<br> vg_procedencia_rural: " . $_REQUEST['vg_procedencia_rural'];
		echo "<br> vg_procedencia_urbano: " . $_REQUEST['vg_procedencia_urbano'];
		echo "<br> checkbox_vulnerabilidad: " . $_REQUEST['checkbox_vulnerabilidad'];
		echo "<br> vg_vulnerabilidad_pueblo: " . $_REQUEST['vg_vulnerabilidad_pueblo'];
		echo "<br> vg_vulnerabilidad_discapacidad: " . $_REQUEST['vg_vulnerabilidad_discapacidad'];
		echo "<br> vg_vulnerabilidad_pobreza: " . $_REQUEST['vg_vulnerabilidad_pobreza'];
	}

	if( isset($_REQUEST['vg_id']) && isset($_REQUEST['vg_tipo_asistente']) && isset($_REQUEST['vg_publico_general'])
		//isset($_REQUEST['vg_sexo_masculino']) && isset($_REQUEST['vg_sexo_femenino']) && isset($_REQUEST['vg_sexo_otro']) &&
	  //isset($_REQUEST['vg_edad_ninos']) && isset($_REQUEST['vg_edad_jovenes']) && isset($_REQUEST['vg_edad_adultos']) && isset($_REQUEST['vg_edad_adultos_mayores']) &&
	 	//isset($_REQUEST['vg_procedencia_rural']) && isset($_REQUEST['vg_procedencia_urbano']) &&
		//isset($_REQUEST['vg_vulnerabilidad_pueblo']) && isset($_REQUEST['vg_vulnerabilidad_discapacidad']) && isset($_REQUEST['vg_vulnerabilidad_pobreza']) && isset($_REQUEST['vg_autor'])
	) {

		$publico_general = intval($_REQUEST['vg_publico_general']);
		if($_REQUEST['checkbox_sexo'] == "on") {
			$total_sexo = intval($_REQUEST['vg_sexo_masculino']) + intval($_REQUEST['vg_sexo_femenino']) + intval($_REQUEST['vg_sexo_otro']);
			if($publico_general != $total_sexo) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					El detalle ingresado en sexo no coincide con cantidad total de participantes. Por favor revisar.
				</div>
			<?php
				return;
			}
		}

		if($_REQUEST['checkbox_edad'] == "on") {
			$total_edad = intval($_REQUEST['vg_edad_ninos']) + intval($_REQUEST['vg_edad_jovenes']) + intval($_REQUEST['vg_edad_adultos']) + intval($_REQUEST['vg_edad_adultos_mayores']);
			if($publico_general != $total_edad) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					El detalle ingresado en grupo etario no coincide con cantidad total de participantes. Por favor revisar.
				</div>
			<?php
				return;
			}
		}

		if($_REQUEST['checkbox_procedencia'] == "on") {
			$total_procedencia = intval($_REQUEST['vg_procedencia_rural']) + intval($_REQUEST['vg_procedencia_urbano']);
			if($publico_general != $total_procedencia) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					El detalle ingresado en procedencia no coincide con cantidad total de participantes. Por favor revisar.
				</div>
			<?php
				return;
			}
		}

		if($_REQUEST['checkbox_vulnerabilidad'] == "on") {
			$validador = true;
			if(intval($_REQUEST['vg_vulnerabilidad_pueblo']) > $publico_general) {
				$validador = false;
			}
			if(intval($_REQUEST['vg_vulnerabilidad_discapacidad']) > $publico_general) {
				$validador = false;
			}
			if(intval($_REQUEST['vg_vulnerabilidad_pobreza']) > $publico_general) {
				$validador = false;
			}

			if($validador == false) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Cada detalle ingresado en factor de vulnerabilidad no puede superar la cantidad total de participantes. Por favor revisar.
				</div>
			<?php
				return;
			}
		}

		if($_REQUEST['checkbox_nacionalidad'] == "on") {
			$validador = true;
			if(intval($_REQUEST['vg_nacionalidad_chileno']) > $publico_general) {
				$validador = false;
			}
			if(intval($_REQUEST['vg_nacionalidad_migrante']) > $publico_general) {
				$validador = false;
			}
			if(intval($_REQUEST['vg_nacionalidad_pueblo']) > $publico_general) {
				$validador = false;
			}

			if($validador == false) { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Cada detalle ingresado en factor de nacionalidad no puede superar la cantidad total de participantes. Por favor revisar.
				</div>
			<?php
				return;
			}
		}

		include_once("../../controller/medoo_participation_real.php");
		$result = addRealParticipation(noeliaDecode($_REQUEST['vg_id']), $_REQUEST['vg_tipo_asistente'],
			($_REQUEST['vg_publico_general']=="" ? "0":$_REQUEST['vg_publico_general']),
			$_REQUEST['checkbox_sexo'],
			($_REQUEST['vg_sexo_masculino']=="" ? "0":$_REQUEST['vg_sexo_masculino']),
			($_REQUEST['vg_sexo_femenino']=="" ? "0":$_REQUEST['vg_sexo_femenino']),
			($_REQUEST['vg_sexo_otro']=="" ? "0":$_REQUEST['vg_sexo_otro']),
			$_REQUEST['checkbox_edad'],
			($_REQUEST['vg_edad_ninos']=="" ? "0":$_REQUEST['vg_edad_ninos']),
			($_REQUEST['vg_edad_jovenes']=="" ? "0":$_REQUEST['vg_edad_jovenes']),
			($_REQUEST['vg_edad_adultos']=="" ? "0":$_REQUEST['vg_edad_adultos']),
			($_REQUEST['vg_edad_adultos_mayores']=="" ? "0":$_REQUEST['vg_edad_adultos_mayores']),
			$_REQUEST['checkbox_procedencia'],
			($_REQUEST['vg_procedencia_rural']=="" ? "0":$_REQUEST['vg_procedencia_rural']),
			($_REQUEST['vg_procedencia_urbano']=="" ? "0":$_REQUEST['vg_procedencia_urbano']),
			$_REQUEST['checkbox_vulnerabilidad'],
			($_REQUEST['vg_vulnerabilidad_pueblo']=="" ? "0":$_REQUEST['vg_vulnerabilidad_pueblo']),
			($_REQUEST['vg_vulnerabilidad_discapacidad']=="" ? "0":$_REQUEST['vg_vulnerabilidad_discapacidad']),
			($_REQUEST['vg_vulnerabilidad_pobreza']=="" ? "0":$_REQUEST['vg_vulnerabilidad_pobreza']),
			$_REQUEST['checkbox_nacionalidad'],
			($_REQUEST['vg_nacionalidad_chileno']=="" ? "0":$_REQUEST['vg_nacionalidad_chileno']),
			($_REQUEST['vg_nacionalidad_migrante']=="" ? "0":$_REQUEST['vg_nacionalidad_migrante']),
			($_REQUEST['vg_nacionalidad_pueblo']=="" ? "0":$_REQUEST['vg_nacionalidad_pueblo']),
			noeliaDecode($_REQUEST['vg_autor']));

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
