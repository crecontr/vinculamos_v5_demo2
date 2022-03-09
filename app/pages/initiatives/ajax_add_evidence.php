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
		echo "<br>vg_nombre: " . $_REQUEST['vg_nombre'];
		echo "<br>vg_descripcion: " . $_REQUEST['vg_descripcion'];
		echo "<br>vg_usuario: " . noeliaDecode($_REQUEST['vg_usuario']);
		return;
	}

	if( isset($_REQUEST['vg_initiative']) && isset($_REQUEST['vg_nombre']) &&
		isset($_REQUEST['vg_descripcion']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_initiatives_evidences.php");

		if(true) {
			include("../../config/settings.php");
			$target_dir = $folder_initiatives_docs;
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
				echo "<br>carpeta creada";
			}

			if($_FILES['vg_archivo']['size'] > 10485760) { // check file size is above limit 10 Mb
				$errors[]= "El tamaño del archivo supera los 10 Mb.";
			} else {

				$fileType = $_FILES["vg_archivo"]["type"];
				if($fileType != "") {
					$fileType = str_replace("image/", "", $fileType);
					$fileType = str_replace("application/", "", $fileType);

					if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "pdf" ) {
						$errors[]= "Los formatos soportados son: JPG, JPEG, PNG, GIF o PDF.";
					} else {
						$result = addEvidence($_REQUEST['vg_nombre'], $_REQUEST['vg_descripcion'],
							noeliaDecode($_REQUEST['vg_initiative']), noeliaDecode($_REQUEST['vg_usuario']), $institucion);

						$filename = md5(noeliaDecode($_REQUEST['vg_initiative']) . "_" . $result[0]["id"]);
						$target_file = $target_dir . "evi_" . $filename . "." . $fileType;
						//echo "<br> targetfile: " . $_REQUEST['vg_initiative'] . "_" . $result[0]["id"] . "." . $fileType;

						if (move_uploaded_file($_FILES["vg_archivo"]["tmp_name"], $target_file)) {
							editEvidenceFile($result[0]["id"], noeliaDecode($_REQUEST['vg_initiative']), $target_file, noeliaDecode($_REQUEST['vg_usuario']));
						} else {
							$errors[]= "Hubo un error subiendo el archivo.";
						}
					}
				} else {
					$errors[]= "Archivo no recibido.";
				}
			}

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
				No pudimmos agregar la evidencia. <br>
				<?php
					echo $errors[0];
				?>
			</div>
		<?php
		}
	} else {
		echo "Falta info!";
	}
?>
