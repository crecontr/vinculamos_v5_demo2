<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");

	$id_initiative = noeliaDecode($_POST['id_initiative']);

	//include_once("../../controller/participation_expected.php");
	//$datas = getVisibleExpectedParticipationByInitiative($id_initiative);

	//include_once("../../controller/medoo_initiatives.php");
	//$initiative = getInitiative($id_initiative);

	include_once("../../controller/medoo_objetives.php");
	$objetives = getVisibleObjetives();

	include_once("../../controller/medoo_measures.php");

	include_once("../../controller/medoo_initiatives_ods.php");
?>
	<div class="box-body table-responsive">
		<div class="col-xs-12">
			<?php
				//$myObjetives = getVisibleObjetivesByInitiative($id_initiative);
				$myObjetives = getODSByInitiative($id_initiative);
				//$myMeasures = getVisibleMeasuresByInitiative($id_initiative);
				for($i=0 ; $i<sizeof($myObjetives) ; $i++) {
					$contadorMetas = 0;
					for($j=0 ; $j<sizeof($myMeasures) ; $j++) {
						if($myObjetives[$i]["id"] == $myMeasures[$j]["id_objetivo"]) {
							$contadorMetas++;
							//echo "<br>Meta -> " . $myMeasures[$j]["nombre"];
						}
					}
					$myObjetives[$i]["cantidad_metas"] = $contadorMetas;
					//echo "<br>IDS " . $myObjetives[$i]["id"] . " " . $myObjetives[$i]["nombre_largo"] . " -- " . $myObjetives[$i]["cantidad_metas"];
					//echo "<br>";
				}

				if(sizeof($myObjetives) > 0) {
					echo "<h4>Objetivos de Desarrollo Sostenible donde contribuye</h4>";
				}

				for($i=0 ; $i<sizeof($myObjetives) ; $i++) {
						$imagen = "../../img/ods-" . $myObjetives[$i]["id"] . ".png";
						$url = "../objetives/view_objetive.php?data=" . $data = noeliaEncode("data" . $myObjetives[$i]["id"]);
						?>
						<div class="col-md-2">
							<a href="<?php echo$url?>">
								<img id="viga_logo" class="img-responsive" src="<?php echo$imagen?>" alt="User profile picture" width="100%">
							</a>
						</div>
			<?php
				}
			?>
		</div>
	</div>
  <!-- /.box-body -->
