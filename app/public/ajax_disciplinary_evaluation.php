<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	include_once("../utils/user_utils.php");
	$institucion = getInstitution();

	// vg_usuario, vg_id_initiative
	// vg_rut, vg_nombre, vg_correo, vg_telefono

	if( isset($_REQUEST['vg_id_initiative']) && isset($_REQUEST['vg_correo']) && isset($_REQUEST['vg_pregunta_1']) && isset($_REQUEST['vg_pregunta_2']) &&
		isset($_REQUEST['vg_pregunta_3']) && isset($_REQUEST['vg_pregunta_4']) ) {


		include_once("../controller/attendance_list.php");
		$datas = getVisibleAttendanceByInitiativeAttendance(noeliaDecode($_REQUEST['vg_id_initiative']), $_REQUEST['vg_correo']);

		if(sizeof($datas) == 0) {?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No se pudo recuperar su información.
			</div>
		<?php
			return;
		} else {
			$result = answerSurvey(noeliaDecode($_REQUEST['vg_id_initiative']), $_REQUEST['vg_correo'], $_REQUEST['vg_pregunta_1'],
				$_REQUEST['vg_pregunta_2'], $_REQUEST['vg_pregunta_3'], $_REQUEST['vg_pregunta_4'], noeliaDecode($_REQUEST['vg_usuario']));

			if($result != null) { ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					Respuesta enviada correctamente.
				</div>
			<?php
			} else { ?>
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					No pudimos enviar su respuesta.
				</div>
			<?php
			}


		}
	} else {
		echo "<br> Falta info";
	}
?>
