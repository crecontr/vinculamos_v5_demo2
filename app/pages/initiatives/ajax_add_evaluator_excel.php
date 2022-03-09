<?php
	if(!isset($_SESSION)){
		@session_start();
	}

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

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationByInitiativeType(noeliaDecode($_REQUEST['vg_id_initiative']), $_REQUEST['vg_tipo2']);

	// vg_usuario, vg_id_initiative
	// vg_rut, vg_nombre, vg_correo, vg_telefono

	if( isset($_REQUEST['vg_usuario']) && isset($_REQUEST['vg_id_initiative']) ) {


		$fileType = $_FILES["vg_excel"]["type"];

		$target_dir = "../../../vinculamos_upload_evaluators/";
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		$uploadFilePath = $target_dir . noeliaDecode($_REQUEST['vg_id_initiative']) . "_" . basename($_FILES['vg_excel']['name']);
    move_uploaded_file($_FILES['vg_excel']['tmp_name'], $uploadFilePath);


		require('../../../template/libs/spreadsheet-reader/php-excel-reader/excel_reader2.php');
		require('../../../template/libs/spreadsheet-reader/SpreadsheetReader.php');


		require("../../controller/medoo_evaluation_evaluators.php");
		$Reader = new SpreadsheetReader($uploadFilePath);

    $arrayIncorrectos = array();
    $arrayAgregados = array();

		$Reader->ChangeSheet(0);
		$row = 0;

		foreach ($Reader as $Row) {
			if($row > 0) {
				$nombre = isset($Row[0]) ? $Row[0] : '';
				$correo = isset($Row[1]) ? $Row[1] : '';

				if($nombre == "" || $correo == "") {
					$arrayIncorrectos[] = $Row;
				} else {
					$result = addEvaluator(noeliaDecode($_REQUEST['vg_id_initiative']),
						$evaluation[0]["id"], $_REQUEST['vg_tipo2'], $nombre, $correo, noeliaDecode($_REQUEST['vg_usuario']));

					if($result == null) {
						$arrayIncorrectos[] = $Row;
					}  else {
						$arrayAgregados[] = $Row;
					}
				}
			}
			$row++;
		}


		if(sizeof($arrayIncorrectos) == 0 ) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Todos los evaluadores se cargaron correctamente.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Los siguientes evaluadores no se pudieron cargar ya que les faltan datos.

				<table id="table" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Correo electrónico</th>
						</tr>
					</thead>
					<tbody>
						<?php
							for($i=0 ; $i<sizeof($arrayIncorrectos) ; $i++) { ?>
								<tr>
									<td><?php echo $arrayIncorrectos[$i][0];?></td>
									<td><?php echo $arrayIncorrectos[$i][1];?></td>
								</tr>
						<?php
							} ?>
						</tbody>
					</table>
			</div>
		<?php
		}

	} else {
		echo "<br> Falta info";
	}
?>
