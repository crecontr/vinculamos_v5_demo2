<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include_once("../../utils/user_utils.php");
	$institution = getInstitution();

	$college = $_POST["college"];
	$campus = $_POST["campus"];
	$program = $_POST["program"];
	$mechanism = $_POST["mechanism"];
	$linkManagerType = $_POST["linkManagerType"];
	$frecuency = $_POST["frecuency"];
	$implementationFormat = $_POST["implementationFormat"];
	$environment = $_POST["environment"];
	$country = $_POST["country"];
	$region = $_POST["region"];
	$commune = $_POST["commune"];
	$objetivo = $_POST["objetivo"];
	$covenant = $_POST["covenant"];

	$executionStatus = $_POST["executionStatus"];
	$fillmentStatus = $_POST["fillmentStatus"];

	if(false) {
		echo "<br> college: " . $_POST["college"];
		echo "<br> campus: " . $_POST["campus"];
		echo "<br> program: " . $_POST["program"];
		echo "<br> mechanism: " . $_POST["mechanism"];
		echo "<br> linkManagerType: " . $_POST["linkManagerType"];
		echo "<br> frecuency: " . $_POST["frecuency"];
		echo "<br> implementationFormat: " . $_POST["implementationFormat"];
		echo "<br> environment: " . $_POST["environment"];
		echo "<br> country: " . $_POST["country"];
		echo "<br> region: " . $_POST["region"];
		echo "<br> commune: " . $_POST["commune"];
		echo "<br> objetivo: " . $_POST["objetivo"];
		echo "<br> covenant: " . $_POST["covenant"];
		//return;
	}


	include_once("../../controller/medoo_initiatives.php");
	$datasRaw = findInitiativesByFilters($institution, $college, $campus,
		$environment, $mechanism, $program, $covenant, $country, $region, $commune,
		$linkManagerType, $implementationFormat, $frecuency, $executionStatus, $fillmentStatus);

	include_once("../../controller/medoo_objetives.php");
	include_once("../../controller/medoo_initiatives_ods.php");
	$datas = array();
	for ($i=0; $i < sizeof($datasRaw); $i++) {
		//$myObjetives = getVisibleObjetivesByInitiative($datasRaw[$i]["id"]);
		$myObjetives = getODSByInitiative($datasRaw[$i]["id"]);
		$datasRaw[$i]["ods"] = $myObjetives;
		if(!in_array($datasRaw[$i], $datas)) {
			if($objetivo == "") {
				$datas[] = $datasRaw[$i];
			} else {
				/* Si hay filtro por ODS */
				$coincidencia = 0;
				for($j=0 ; $j<sizeof($myObjetives) ; $j++) {
					if(in_array($myObjetives[$j]["id"], $objetivo)) {
						$coincidencia++;
					}
				}
				if($coincidencia > 0) {
					$datas[] = $datasRaw[$i];
				}
			}
		}
	}

	include_once("../../controller/medoo_environment.php");
	include_once("../../controller/medoo_colleges.php");
	include_once("../../controller/medoo_programs.php");
	include_once("../../controller/medoo_invi_attributes.php");
	include_once("../../controller/medoo_invi.php");
	include_once("../../controller/medoo_participation_plan.php");
	include_once("../../controller/medoo_participation_real.php");
	include_once("../../controller/medoo_initiatives_resources_building.php");
	include_once("../../controller/medoo_initiatives_resources_financial.php");
	include_once("../../controller/medoo_initiatives_resources_human.php");

	$totalPlanParticipation = 0;
	$totalPlanParticipationMan = 0;
	$totalPlanParticipationWoman = 0;
	$totalPlanParticipationOther = 0;

	$totalRealParticipationGender = 0;
	$totalRealParticipationMan = 0;
	$totalRealParticipationWoman = 0;
	$totalRealParticipationOther = 0;

	$totalRealParticipationAge = 0;
	$totalRealParticipationBoys = 0;
	$totalRealParticipationYoung = 0;
	$totalRealParticipationAdult = 0;
	$totalRealParticipationMayor = 0;

	$totalRealParticipationOrigin = 0;
	$totalRealParticipationRural = 0;
	$totalRealParticipationUrban = 0;

	$totalResources = 0;
	$totalResourcesBuilding = 0;
	$totalResourcesFinancial = 0;
	$totalResourcesHuman = 0;

	$sumatoriaInvi = 0;
	$promedioInvi = 0;
	$globalODS = array();
	for ($i=0; $i < sizeof($datas); $i++) {
		$inviScore = calculateInviByInitiative($datas[$i]['id']);
		$datas[$i]['invi'] = $inviScore;
		$sumatoriaInvi += $inviScore["invi"]["total"];

		$myColleges = getCollegesByInitiative($datas[$i]['id']);
		$datas[$i]['colleges'] = $myColleges;

		//$myPrograms = getProgramsByInitiative($datas[$i]['id']);
		//$datas[$i]['programs'] = $myPrograms;

		$myEnvironments = getEnvironmentsByInitiative($datas[$i]["id"]);
		$datas[$i]['environments'] = $myEnvironments;

		/* LIMPIAR ODS DUPLICADOS */
		$myObjetives = $datas[$i]["ods"];
		for($j=0 ; $j<sizeof($myObjetives) ; $j++) {
			if(!in_array($myObjetives[$j], $globalODS)) {
				$globalODS[] = $myObjetives[$j];
			}
		}

		//$participationReal = sumGeneralRealParticipationByInitiative($datas[$i]['id']);
		//$totalRealParticipation += $participationReal;
		$participationRealMan = sumGeneralRealParticipationByInitiativeGender($datas[$i]['id'], "sexo_masculino");
		$totalRealParticipationMan += $participationRealMan;
		$participationRealWoman = sumGeneralRealParticipationByInitiativeGender($datas[$i]['id'], "sexo_femenino");
		$totalRealParticipationWoman += $participationRealWoman;
		$participationRealOther = sumGeneralRealParticipationByInitiativeGender($datas[$i]['id'], "sexo_otro");
		$totalRealParticipationOther += $participationRealOther;
		$totalRealParticipationGender += ($participationRealMan + $participationRealWoman + $participationRealOther);

		$resourcesBuilding = sumBuildingResourcesByInitiative($datas[$i]['id']);
		$totalResourcesBuilding += $resourcesBuilding;
		$resourcesFinancial = sumCashResourcesByInitiative($datas[$i]['id']);
		$totalResourcesFinancial += $resourcesFinancial;
		$resourcesHuman = sumHumanResourcesByInitiative($datas[$i]['id']);
		$totalResourcesHuman += $resourcesHuman;
		$totalResources += ($resourcesBuilding + $resourcesFinancial + $resourcesHuman);

		$participationRealBoys = sumGeneralRealParticipationByInitiativeAge($datas[$i]['id'], "edad_ninos");
		$totalRealParticipationBoys += $participationRealBoys;
		$participationRealYoung = sumGeneralRealParticipationByInitiativeAge($datas[$i]['id'], "edad_jovenes");
		$totalRealParticipationYoung += $participationRealYoung;
		$participationRealAdult = sumGeneralRealParticipationByInitiativeAge($datas[$i]['id'], "edad_adultos");
		$totalRealParticipationAdult += $participationRealAdult;
		$participationRealMayor = sumGeneralRealParticipationByInitiativeAge($datas[$i]['id'], "edad_adultos_mayores");
		$totalRealParticipationMayor += $participationRealMayor;
		$totalRealParticipationAge += ($participationRealBoys + $participationRealYoung
			+ $participationRealAdult + $participationRealMayor);

		$participationRealUrban = sumGeneralRealParticipationByInitiativeOrigin($datas[$i]['id'], "procedencia_urbano");
		$totalRealParticipationUrban += $participationRealUrban;
		$participationRealRural = sumGeneralRealParticipationByInitiativeOrigin($datas[$i]['id'], "procedencia_rural");
		$totalRealParticipationRural += $participationRealRural;
		$totalRealParticipationOrigin += ($participationRealUrban + $participationRealRural);
	}
	$promedioInvi = round($sumatoriaInvi / sizeof($datas));

	/* ORDERNAR ODS NO DUPLICADOS */
	function cmp($a, $b) {
		return $a["id"] > $b["id"];
	}
	usort($globalODS, "cmp");

	include_once("../../controller/medoo_report.php");
	/* GRAFICO ENTORNOS SIGNIFICATIVOS */
	$allEnvironments = getVisibleEnvironments();
	$allEnvironmentsCont = array();
	$scriptEtiquetasEnvironments = "";
	$scriptCantidadesEnvironments = "";
	$sumaTotalEnvironments = 0;
	for ($i=0; $i < sizeof($allEnvironments); $i++) {
		$allEnvironmentsCont[$i] = getFilterInitiativesByEnvironment($datas, $allEnvironments[$i]["id"]);
		$sumaTotalEnvironments += sizeof($allEnvironmentsCont[$i]);

		$scriptEtiquetasEnvironments .= ("'" . $allEnvironments[$i]["nombre"] . "'");
		$scriptCantidadesEnvironments .= ("'" . sizeof($allEnvironmentsCont[$i]) . "'");
		if($i < sizeof($allEnvironments)-1) {
			$scriptEtiquetasEnvironments .= ", ";
			$scriptCantidadesEnvironments .= ", ";
		}
	}
	echo "
		<script>
			var etiquetasEntornos = [" . $scriptEtiquetasEnvironments . "];
			var cantidadesEntornos = [" . $scriptCantidadesEnvironments . "];
		</script>
	";

	$allUnits = getVisibleCollegesByInstitution($institution);
	$allUnitsCont = array();
	$scriptEtiquetasUnits = "";
	$scriptCantidadesUnits = "";
	$sumaTotalUnits = 0;
	for ($i=0; $i < sizeof($allUnits); $i++) {
		$allUnitsCont[$i] = getFilterInitiativesByCollege($datas, $allUnits[$i]["id"]);
		$sumaTotalUnits += sizeof($allUnitsCont[$i]);

		$scriptEtiquetasUnits .= ("'" . $allUnits[$i]["nombre"] . "'");
		$scriptCantidadesUnits .= ("'" . sizeof($allUnitsCont[$i]) . "'");
		if($i < sizeof($allUnits)-1) {
			$scriptEtiquetasUnits .= ", ";
			$scriptCantidadesUnits .= ", ";
		}
	}

	echo "
		<script>
			var etiquetasUnidades = [" . $scriptEtiquetasUnits . "];
			var cantidadesUnidades = [" . $scriptCantidadesUnits . "];
		</script>
	";

?>

<div class="box-body" id="toExcel" name="toExcel">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#subtab_1Repor1" data-toggle="tab">Resumen</a></li>
					<li class="bg-warning"><a href="#subtab_2Repor1" data-toggle="tab">Ver detalle</a></li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="subtab_1Repor1">
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-4">
								<h4>Participantes reales: <?php echo $totalRealParticipationGender;?></h4>
								<div class="box-footer no-padding">
		              <ul class="nav nav-pills nav-stacked">
		                <li>
											<a href="#">Hombre
												<span class="pull-right text-blue">
													<?php echo $totalRealParticipationMan;?>
													<?php echo " (" . round($totalRealParticipationMan/$totalRealParticipationGender * 100, 0) . "%)";?>
												</span>
											</a>
		                </li>
		                <li>
											<a href="#">Mujer
		                  	<span class="pull-right text-blue">
													<?php echo $totalRealParticipationWoman;?>
													<?php echo " (" . round($totalRealParticipationWoman/$totalRealParticipationGender * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
										<li>
											<a href="#">Otro
			                	<span class="pull-right text-blue">
													<?php echo $totalRealParticipationOther;?>
													<?php echo " (" . round($totalRealParticipationOther/$totalRealParticipationGender * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
		              </ul>
		            </div>
							</div>

							<div class="col-md-4">
								<h4>Segmento etareo</h4>
								<div class="box-footer no-padding">
		              <ul class="nav nav-pills nav-stacked">
		                <li>
											<a href="#">Niños
												<span class="pull-right text-blue">
													<?php echo $totalRealParticipationBoys;?>
													<?php echo " (" . round($totalRealParticipationBoys/$totalRealParticipationAge * 100, 0) . "%)";?>
												</span>
											</a>
		                </li>
		                <li>
											<a href="#">Jóvenes
		                  	<span class="pull-right text-blue">
													<?php echo $totalRealParticipationYoung;?>
													<?php echo " (" . round($totalRealParticipationYoung/$totalRealParticipationAge * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
										<li>
											<a href="#">Adultos
			                	<span class="pull-right text-blue">
													<?php echo $totalRealParticipationAdult;?>
													<?php echo " (" . round($totalRealParticipationAdult/$totalRealParticipationAge * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
										<li>
											<a href="#">Adultos Mayores
			                	<span class="pull-right text-blue">
													<?php echo $totalRealParticipationMayor;?>
													<?php echo " (" . round($totalRealParticipationMayor/$totalRealParticipationGender * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
		              </ul>
		            </div>
							</div>

							<div class="col-md-4">
								<h4>Procedencia</h4>
								<div class="box-footer no-padding">
		              <ul class="nav nav-pills nav-stacked">
										<li>
											<a href="#">Rural
		                  	<span class="pull-right text-blue">
													<?php echo $totalRealParticipationRural;?>
													<?php echo " (" . round($totalRealParticipationRural/$totalRealParticipationOrigin * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
										<li>
											<a href="#">Urbana
												<span class="pull-right text-blue">
													<?php echo $totalRealParticipationUrban;?>
													<?php echo " (" . round($totalRealParticipationUrban/$totalRealParticipationOrigin * 100, 0) . "%)";?>
												</span>
											</a>
		                </li>
									</ul>
		            </div>
							</div>

						</div>
						<br>
						<div class="row">
							<div class="col-md-6">
								<h4>Recursos totales: <?php echo $totalResources;?></h4>
								<div class="box-footer no-padding">
		              <ul class="nav nav-pills nav-stacked">
		                <li>
											<a href="#">Dinero
		                  	<span class="pull-right text-blue">
													<?php echo $totalResourcesFinancial;?>
													<?php echo " (" . round($totalResourcesFinancial/$totalResources * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
		                <li>
											<a href="#">Infraestructura
												<span class="pull-right text-blue">
													<?php echo $totalResourcesBuilding;?>
													<?php echo " (" . round($totalResourcesBuilding/$totalResources * 100, 0) . "%)";?>
												</span>
											</a>
		                </li>
										<li>
											<a href="#">RR.HH.
			                	<span class="pull-right text-blue">
													<?php echo $totalResourcesHuman;?>
													<?php echo " (" . round($totalResourcesHuman/$totalResources * 100, 0) . "%)";?>
												</span>
											</a>
										</li>
		              </ul>
		            </div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-6">
								<h4>Unidades institucionales</h4>
								<div class="box-footer no-padding">
		              <ul class="nav nav-pills nav-stacked">
										<?php
										 	for ($i=0; $i < sizeof($allUnits); $i++) { ?>
												<li>
													<a href="#"> <?php echo $allUnits[$i]["nombre"];?>
				                  	<span class="pull-right text-blue">
															<?php echo sizeof($allUnitsCont[$i]);?>
															<?php echo " (" . round(sizeof($allUnitsCont[$i])/$sumaTotalUnits * 100, 0) . "%)";?>
														</span>
													</a>
												</li>
										<?php
											} ?>
		              </ul>
		            </div>
							</div>

							<div class="col-md-6">
								<h4>Entorno Relevante</h4>
								<div class="box-footer no-padding">
		              <ul class="nav nav-pills nav-stacked">
										<?php
										 	for ($i=0; $i < sizeof($allEnvironments); $i++) { ?>
												<li>
													<a href="#"> <?php echo $allEnvironments[$i]["nombre"];?>
				                  	<span class="pull-right text-blue">
															<?php echo sizeof($allEnvironmentsCont[$i]);?>
															<?php echo " (" . round(sizeof($allEnvironmentsCont[$i])/$sumaTotalEnvironments * 100, 0) . "%)";?>
														</span>
													</a>
												</li>
										<?php
											} ?>
		              </ul>
		            </div>
							</div>

						</div>
						<br>
						<div class="row">
							<div class="col-lg-6 col-xs-6">
		          	<!-- small box -->
		          	<div class="small-box bg-aqua">
		            	<div class="inner">
		              	<h3><?php echo sizeof($datas); ?></h3>
		              	<p>Iniciativas</p>
		            	</div>
		            	<div class="icon">
		              	<i class="fa fa-briefcase"></i>
		            	</div>
		            </div>
		        	</div>
		      		<!-- ./col -->

							<div class="col-lg-6 col-xs-6">
		          	<!-- small box -->
		          	<div class="small-box bg-purple">
		            	<div class="inner">
		              	<h3><?php echo sizeof($globalODS); ?></h3>
		              	<p>ODS relacionados</p>
		            	</div>
		            	<div class="icon">
		              	<i class="fa fa-briefcase"></i>
		            	</div>
		            </div>
		        	</div>
		      		<!-- ./col -->

							<div class="col-md-12">
								<canvas id="graficoBarra1" height="180"></canvas>
							</div>
							<br>
							<div class="col-md-12">
								<canvas id="graficoBarra2" height="150"></canvas>
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="row text-center">
							<h3>Índice de vinculación INVI</h3>
							<input type='text' class='knob' data-skin="tron" data-readonly='true' value='<?php echo$promedioInvi?>' data-fgColor='#F1943D' data-width='220' data-height='220'>
							<div class="knob-label">Puntaje promedio</div>
							<p>*INVI significa indice de vinculación y considera las variables mecanismo, cobertura, frecuencia y evaluación. </p>
						</div>

						<div class="row text-center">
							<h3>ODS Relacionados</h3>

							<?php
							for($i=0 ; $i<sizeof($globalODS) ; $i++) {
									$imagen = "../../img/ods-" . $globalODS[$i]["id"] . ".png";
									$url = "../objetives/view_objetive.php?data=" . $data = base64_encode("data" . $globalODS[$i]["id"]);
									?>
									<div class="col-md-3">
										<a href="<?php echo$url?>">
											<img id="viga_logo" class="img-responsive" src="<?php echo$imagen?>" alt="User profile picture" width="100%">
										</a>
									</div>
						<?php
							}
						?>
						</div>
					</div>
				</div>

				<div class="tab-pane" id="subtab_2Repor1">
					<div class="col-md-12">
						<div class="row">
							<div class="box-body table-responsive">
					    	<table id="table" class="table table-bordered table-hover">
					        	<thead>
					                <tr>
					                	<th>ID</th>
														<th>Nombre</th>
														<th>Linea de acción</th>
														<th>Mecanismo</th>
														<th>INVI</th>
														<th style="width:110px">Acciones</th>
													</tr>
					            </thead>
					       		<tbody>
					       			<?php
					       				for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
					       					<tr>
														<td><?php echo $datas[$i]['id'];?></td>
								      			<td><?php echo $datas[$i]['nombre'];?></td>
														<td>
															<?php
																$myProgram = getProgram($datas[$i]['id_programa']);
																echo $myProgram[0]["nombre"];
															?>
														</td>
														<td>
															<?php
																$myMechanism = getMechanism($datas[$i]['id_mecanismo']);
																echo $myMechanism[0]["nombre"];
															?>
														</td>
														<td>
															<?php
															 	$inviScore = $datas[$i]['invi'];
																echo $inviScore["invi"]["total"];
															?>
														</td>
														<td>
															<?php
																$data = noeliaEncode("data" . $datas[$i]['id']);
								      					if(canUpdateInitiatives()) {
								      						$data = noeliaEncode("data" . $datas[$i]['id']); ?>
																	<div class="btn-group">
																		<button type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown" title='Opciones'>
																			<i class="glyphicon glyphicon-triangle-bottom"></i>
																		</button>
																		<ul class="dropdown-menu">
																			<!--li>
																				<a href="../initiatives/add_attendance_list.php?data=<?php echo$data;?>" title='Lista asistencia'>
																					Agregar lista asistencia
																				</a>
																			</li>
																			<li>
																				<a href="../initiatives/add_surveys.php?data=<?php echo$data;?>" title='Encuestas'>
																					Encuestas
																				</a>
																			</li-->
																			<li>
																				<a href="../initiatives/add_evaluation.php?data=<?php echo$data;?>" title='Evaluaciones'>
																					<i class="fa fa-file-text-o"></i> Evaluación
																				</a>
																			</li>

																			<?php
																			 	if(canSuperviseInitiatives()) { ?>
																					<li>
																						<a data-toggle="modal" data-target="#editStatusExecution"
																							data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
																							data-estado_ejecucion ='<?php echo $datas[$i]['estado_ejecucion']?>'
																							title='Estado Ejecución'>
																							Actualizar ejecución
																						</a>
																					</li>

																					<li>
																						<a data-toggle="modal" data-target="#editStatusFillment"
																							data-id_iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
																							data-estado_completitud ='<?php echo $datas[$i]['estado_completitud']?>'
																							title='Estado Completitud'>
																							Actualizar completitud
																						</a>
																					</li>
																			<?php
																				} ?>
																		</ul>
																	</div>
															<?php
																} ?>

								      				<?php
								      					if(canReadInitiatives()) {
								      						$data = noeliaEncode("data" . $datas[$i]['id']); ?>
																	<a href="../initiatives/review_initiative.php?data=<?php echo$data;?>" class='btn btn-orange' title='Ver iniciativa'>
																		<i class="glyphicon glyphicon-eye-open"></i>
																	</a>

																	<a class="btn btn-orange" valign="right" data-toggle="modal" title='Calcular INVI'
																		data-iniciativa='<?php echo noeliaEncode($datas[$i]['id']);?>'
																		data-usuario='<?php echo ($_SESSION["nombre_usuario"]);?>'
																		data-target="#calculateScoreVCM">
																			<i class="fa fa-tachometer"></i>
																	</a>
															<?php
																} ?>

															<?php
								      					if(canUpdateInitiatives()) { ?>

																	<a href="../initiatives/edit_initiative_step1.php?data=<?php echo$data;?>" class='btn btn-orange' title='Editar iniciativa'>
																		<i class="glyphicon glyphicon-edit"></i>
																	</a>
																	<!--a href="add_attendance_list.php?data=<?php echo$data;?>" class='btn btn-orange' title='Lista asistencia'>
																		<i class="glyphicon glyphicon-list"></i>
																	</a>
																	<a href="add_survey.php?data=<?php echo$data;?>" class='btn btn-orange' title='Agregar encuesta'>
																		<i class="glyphicon glyphicon-list-alt"></i>
																	</a-->
																	<a href="../initiatives/edit_initiative_evidences.php?data=<?php echo$data;?>" class='btn btn-orange' title='Cargar evidencia'>
																		<i class="glyphicon glyphicon-paperclip"></i>
																	</a>
															<?php
																} ?>

															<?php
								      					switch ($datas[$i]['estado']) {
								      						case 'Aprobado':
								      							echo "<i class='text-green fa fa-check'></i>";
								      							break;
																	case 'Rechazado':
								      							echo "<i class='text-red fa fa-close'></i>";
								      							break;
																}
															?>

															<?php
																$idEjecucion = ("ejecucion" . $datas[$i]['id']);
																echo "<small class='label label-primary' id='$idEjecucion'>" . $datas[$i]['estado_ejecucion'] . "</small> &nbsp;";

																$idCompletitud = ("completitud" . $datas[$i]['id']);
																echo "<small class='label label-info' id='$idCompletitud'>" . $datas[$i]['estado_completitud'] . "</small> &nbsp;";

															?>
								      			</td>

					            		</tr>
					       			<?php
					       				} ?>

					            </tbody>
					        </table>
					    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
