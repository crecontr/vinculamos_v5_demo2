<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	if(!canCreateParameters()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$institucion = getInstitution();

	if( isset($_REQUEST['vg_nombre']) && isset($_REQUEST['vg_descripcion']) && isset($_REQUEST['vg_id_convenio']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_covenants_docs.php");
		$result = addCovenantDoc($_REQUEST['vg_nombre'], $_REQUEST['vg_descripcion'],
			noeliaDecode($_REQUEST['vg_id_convenio']), noeliaDecode($_REQUEST['vg_usuario']), $institucion);

		if(true) {
			include("../../config/settings.php");
			$target_dir = $folder_covenant_docs;
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			$fileType = $_FILES["vg_archivo"]["type"];
			if($fileType != "") {
				$fileType = str_replace("image/", "", $fileType);
				$fileType = str_replace("application/", "", $fileType);


				$filename = md5(noeliaDecode($_REQUEST['vg_id_convenio']) . "_" . $result[0]["id"]);
				$target_file = $target_dir . "doc_" . $filename . "." . $fileType;

				if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif" && $fileType != "pdf" ) {
					$errors[]= "Tu evidencia no fue cargada.<br>Los formatos soportados son: JPG, JPEG, PNG, GIF o PDF.";
					$uploadOk = 0;
				}

				if (move_uploaded_file($_FILES["vg_archivo"]["tmp_name"], $target_file)) {
					editCovenantDocFile($result[0]["id"], noeliaDecode($_REQUEST['vg_id_convenio']), $target_file, noeliaDecode($_REQUEST['vg_usuario']));
				} else {
					//$errors[]= "Lo sentimos, hubo un error subiendo el archivo.";
				}
			} else {
				echo "<br> Archivo no recibido";
			}
		}

		if($result != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Documento cargado correctamente.
				<?php echo "<br>$target_file";?>
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				El documento que intenta agregar ya existe.
			</div>
		<?php
		}


	} else {
		echo "<br>Falta info!";
	}
?>
