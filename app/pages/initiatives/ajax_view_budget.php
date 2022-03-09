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

	$id_initiative = base64_decode($_POST['id_initiative']);

	include_once("../../controller/medoo_initiatives_resources_financial.php");
	include_once("../../controller/medoo_initiatives_resources_building.php");
	include_once("../../controller/medoo_initiatives_resources_human.php");
?>

  <div class="box-body table-responsive">
		<div id="result_human_resources_detail"></div>

		<table class="table table-bordered table-hover">
			<thead>
				<th style="width:20%"></th>
				<th style="width:23%">Dinero</th>
				<th style="width:23%">Infraestructura</th>
				<th style="width:23%">Recursos Humanos</th>
				<th style="width:10%">TOTAL</th>
			</thead>
			<tbody>
				<tr>
					<th>Monto Aprobado por VcM</th>
					<td>
						<?php
							$resourcesCash = getVisibleCashResourcesByInitiativeSource($id_initiative, "vcm");
							$subtotalCash = 0;
							foreach($resourcesCash as $resource) {
								$subtotalCash += $resource["valorizacion"];
							}
							echo "$" .  number_format($subtotalCash, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("vcm");?>'
									data-toggle="modal" data-target="#addCash">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesCash as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("vcm") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteCash'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesBulding = getVisibleBuildingResourcesByInitiativeSource($id_initiative, "vcm");
							$subtotalBuilding = 0;
							foreach($resourcesBulding as $resource) {
								$subtotalBuilding += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalBuilding, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("vcm");?>'
									data-toggle="modal" data-target="#addBuilding">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesBulding as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("vcm") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteBuilding'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesHuman = getVisibleHumanResourcesByInitiativeSource($id_initiative, "vcm");
							$subtotalHuman = 0;
							foreach($resourcesHuman as $resource) {
								$subtotalHuman += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalHuman, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("vcm");?>'
									data-toggle="modal" data-target="#addHuman">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesHuman as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("vcm") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteHuman'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php echo "$" . number_format(($subtotalCash + $subtotalBuilding + $subtotalHuman), '0', ',','.'); ?>
					</td>
				</tr>
				<tr>
					<th>Monto aportado por unidad institucional</th>
					<td>
						<?php
							$resourcesCash = getVisibleCashResourcesByInitiativeSource($id_initiative, "escuela");
							$subtotalCash = 0;
							foreach($resourcesCash as $resource) {
								$subtotalCash += $resource["valorizacion"];
							}
							echo "$" .  number_format($subtotalCash, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("escuela");?>'
									data-toggle="modal" data-target="#addCash">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesCash as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("escuela") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteCash'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesBulding = getVisibleBuildingResourcesByInitiativeSource($id_initiative, "escuela");
							$subtotalBuilding = 0;
							foreach($resourcesBulding as $resource) {
								$subtotalBuilding += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalBuilding, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("escuela");?>'
									data-toggle="modal" data-target="#addBuilding">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesBulding as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("escuela") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteBuilding'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesHuman = getVisibleHumanResourcesByInitiativeSource($id_initiative, "escuela");
							$subtotalHuman = 0;
							foreach($resourcesHuman as $resource) {
								$subtotalHuman += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalHuman, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("escuela");?>'
									data-toggle="modal" data-target="#addHuman">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesHuman as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("escuela") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteHuman'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php echo "$" . number_format(($subtotalCash + $subtotalBuilding + $subtotalHuman), '0', ',','.'); ?>
					</td>
				</tr>
				<tr>
					<th>Monto aportado por sede</th>
					<td>
						<?php
							$resourcesCash = getVisibleCashResourcesByInitiativeSource($id_initiative, "sede");
							$subtotalCash = 0;
							foreach($resourcesCash as $resource) {
								$subtotalCash += $resource["valorizacion"];
							}
							echo "$" .  number_format($subtotalCash, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("sede");?>'
									data-toggle="modal" data-target="#addCash">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesCash as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("sede") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteCash'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesBulding = getVisibleBuildingResourcesByInitiativeSource($id_initiative, "sede");
							$subtotalBuilding = 0;
							foreach($resourcesBulding as $resource) {
								$subtotalBuilding += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalBuilding, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("sede");?>'
									data-toggle="modal" data-target="#addBuilding">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesBulding as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("sede") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteBuilding'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesHuman = getVisibleHumanResourcesByInitiativeSource($id_initiative, "sede");
							$subtotalHuman = 0;
							foreach($resourcesHuman as $resource) {
								$subtotalHuman += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalHuman, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("sede");?>'
									data-toggle="modal" data-target="#addHuman">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesHuman as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("sede") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteHuman'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php echo "$" . number_format(($subtotalCash + $subtotalBuilding + $subtotalHuman), '0', ',','.'); ?>
					</td>
				</tr>
				<tr>
					<th>Monto aportados por externos</th>
					<td>
						<?php
							$resourcesCash = getVisibleCashResourcesByInitiativeSource($id_initiative, "externos");
							$subtotalCash = 0;
							foreach($resourcesCash as $resource) {
								$subtotalCash += $resource["valorizacion"];
							}
							echo "$" .  number_format($subtotalCash, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("externos");?>'
									data-toggle="modal" data-target="#addCash">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesCash as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("externos") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteCash'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesBulding = getVisibleBuildingResourcesByInitiativeSource($id_initiative, "externos");
							$subtotalBuilding = 0;
							foreach($resourcesBulding as $resource) {
								$subtotalBuilding += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalBuilding, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("externos");?>'
									data-toggle="modal" data-target="#addBuilding">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesBulding as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("externos") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteBuilding'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php
							$resourcesHuman = getVisibleHumanResourcesByInitiativeSource($id_initiative, "externos");
							$subtotalHuman = 0;
							foreach($resourcesHuman as $resource) {
								$subtotalHuman += $resource["valorizacion"];
							}
							echo "$" . number_format($subtotalHuman, '0', ',','.');

							if(canUpdateInitiatives()) {
								$data = base64_encode("data" . $datas[$i]['id']); ?>
								<a href="#" class='btn btn-orange pull-right' title='Agregar monto'
									data-source='<?php echo noeliaEncode("externos");?>'
									data-toggle="modal" data-target="#addHuman">
									<i class="glyphicon glyphicon-plus"></i></a>
						<?php
							} ?>

							<table class="table small">
								<thead>
									<th>Recurso</th>
									<th>Horas</th>
									<th>Valorización</th>
									<th></th>
								</thead>
								<?php
									foreach($resourcesHuman as $resource) {
										echo "<tr>";
										echo "	<td>" . $resource["tipo"] . "</td>";
										echo "	<td>" . number_format($resource["horas"], '0', ',','.') . "</td>";
										echo "	<td>$" . number_format($resource["valorizacion"], '0', ',','.') . "</td>";
										echo "	<td class='small'>";
										echo " 		<a class='btn btn-orange pull-right small' title='Eliminar recurso'
																data-source='" . noeliaEncode("externos") . "'
																data-id='" . noeliaEncode($resource["id"]) . "'
																data-toggle='modal' data-target='#deleteHuman'>
																<i class='glyphicon glyphicon-trash small'></i>
															</a>";
										echo "	</td>";
										echo "</tr>";
									}
								?>
							</table>
					</td>
					<td>
						<?php echo "$" . number_format(($subtotalCash + $subtotalBuilding + $subtotalHuman), '0', ',','.'); ?>
					</td>
				</tr>
			</tbody>
		</table>

  </div>
  <!-- /.box-body -->
