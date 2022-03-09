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
	
	/*
	echo "<br>vg_initiative: " . base64_decode($_REQUEST['vg_initiative']);
	echo "<br>vg_type: " . $_REQUEST['vg_type'];
	echo "<br>vg_amount: " . $_REQUEST['vg_amount'];
	echo "<br>vg_usuario: " . base64_decode($_REQUEST['vg_usuario']);
	return;
	*/

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_titulo']) && isset($_REQUEST['vg_descripcion'])
		&& isset($_REQUEST['vg_autor']) ) {

		include_once("../../controller/initiatives_evidences.php");
		$result = addEvidence(noeliaDecode($_REQUEST['vg_initiative']), $_REQUEST['vg_titulo'],
			$_REQUEST['vg_descripcion'], noeliaDecode($_REQUEST['vg_autor']));

		$target_dir = "../../../vinculamos_evidencias/";
		$carpeta=$target_dir;
		if (!file_exists($carpeta)) {
			mkdir($carpeta, 0777, true);
		}
		$imageFileType = $_FILES["vg_archivo"]["type"];
		if($imageFileType != "") {
			$imageFileType = str_replace("image/", "", $imageFileType);
			$imageFileType = str_replace("application/", "", $imageFileType);
			//$errors[] = "imageFileType: " . $imageFileType;

			//$target_file = $carpeta . basename($_FILES["evidencia"]["name"]);
			$target_file = $carpeta . "evidencia_" . $result[0]["id"] . "." . $imageFileType;
			//$errors[] = "target: " . $target_file;

			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" ) {
				$errors[]= "Tu evidencia no fue cargada.<br>Los formatos soportados son: JPG, JPEG, PNG, GIF o PDF.";
				$uploadOk = 0;
			}

			if (move_uploaded_file($_FILES["vg_archivo"]["tmp_name"], $target_file)) {
				//$messages[]= "El Archivo ha sido subido correctamente.";
				editEvidenceFile($result[0]["id"], $target_file, noeliaDecode($_REQUEST['vg_autor']));
			} else {
				//$errors[]= "Lo sentimos, hubo un error subiendo el archivo.";
			}
		} else {
			echo "<br> Archivo no recibido";
		}

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Evidencia guardada correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimmos agregar la evidencia.
			</div>
		<?php
		}
	} else {
		echo "Falta info!";
	}
?>
