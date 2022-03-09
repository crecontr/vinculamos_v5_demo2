<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");
	if(!canReadInitiatives()) {
		echo "<p><strong> Acceso no permitido.</strong></p>";
		return;
	}

	$id_initiative = noeliaDecode($_POST['id_initiative']);

	include_once("../../controller/medoo_initiatives_evidences.php");
	$datas = getVisibleEvidencesByInitiative($id_initiative);

	if(sizeof($datas) == 0) {
		echo "<p>No se encontraron evidencias</p>";
		return;
	}
?>

<div class="row">
	<div class="col-md-12">
		<!-- The time line -->
		<ul class="timeline">
			<?php for($i = 0 ; $i<sizeof($datas); $i++) { ?>
			<li class="time-label">
				<span class="bg-yellow small">
					<?php echo date('d-m-Y', strtotime($datas[$i]["fecha_creacion"])); ?>
				</span>
			</li>
			<li>
				<?php
					if($datas[$i]["tiene_archivo"] == "1") { ?>
						<i class="fa fa-camera bg-purple"></i>
				<?php
					} else { ?>
						<i class="fa fa-comments bg-green"></i>
				<?php
					} ?>
				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> <?php echo date('H:i', strtotime($datas[$i]["fecha_creacion"])); ?>
					</span>
					<h3 class="timeline-header small"><a href="#">@<?php echo $datas[$i]["autor"]; ?></a> agregó esta evidencia: <?php echo $datas[$i]["nombre"]; ?></h3>
					<div class="timeline-body small">
							<?php echo $datas[$i]["descripcion"]; ?>
							<?php
								if($datas[$i]["archivo"] != "") {
									echo "<br>";
									$archivo = $datas[$i]["archivo"];
									if (strpos($archivo, ".pdf") !== false) {
										echo "<iframe src='$archivo' class='img-thumbnail' width='500'/>";
										echo "<a href='$archivo' target='_blank'> &nbsp; Ver archivo</a>";
									} else {
										echo "<a href='$archivo' target='_blank'>";
										echo "	<img src='$archivo' alt='...' class='img-thumbnail' width='500'>";
										echo "</a>";

									}
								}
							?>
							<?php
								$datetime1 = new DateTime($datas[$i]["fecha_creacion"]);
								$datetime2 = new DateTime();
								$difference = date_diff($datetime1, $datetime2);
								$minutes = $difference->days * 24 * 60;
								$minutes += $difference->h * 60;
								$minutes += $difference->i;
								//echo ("The difference in minutes is: " . $minutes);
								if(canUpdateInitiatives() && $minutes <= 20) { ?>
									<a data-toggle="modal" data-target="#deleteEvidence" class='btn btn-orange'
										data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id_iniciativa']);?>'
										data-id_evidencia='<?php echo noeliaEncode($datas[$i]['id']);?>'
										data-nombre='<?php echo $datas[$i]['nombre'];?>'
										data-usuario='<?php echo $_SESSION["nombre_usuario"];?>'
										title='Eliminar evidencia de iniciativa'>
										<i class="fa fa-trash"></i>
									</a>
							<?php
								}
							?>
					</div>
				</div>
			</li>
				<?php } ?>
			<li>
				<i class="fa fa-clock-o bg-gray"></i>
			</li>
		</ul>
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
