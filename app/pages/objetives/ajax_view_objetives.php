<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}
	include("../../utils/user_utils.php");

	include("../../controller/medoo_objetives.php");
	$datas = getVisibleObjetives();
?>
	<div class="box-body">
		<img id="viga_logo" class="img-responsive center-block" src="../../img/ods-titulo.png" alt="User profile picture" width="60%">
	</div>
	<div class="box-body">

			<?php
				for($i=0 ; $i<6 ; $i++) {
					$imagen = "../../img/ods-" . $datas[$i]["id"] . ".png";
					$url = "view_objetive.php?data=" . $data = noeliaEncode("data" . $datas[$i]["id"]);
					?>
					<div class="col-md-2">
						<a href="<?php echo$url?>">
							<img id="viga_logo" class="img-responsive" src="<?php echo$imagen?>" alt="User profile picture" width="100%">
						</a>
					</div>
			<?php
				} ?>
	</div>

	<div class="box-body">
			<?php
				for($i=6 ; $i<12 ; $i++) {
					$imagen = "../../img/ods-" . $datas[$i]["id"] . ".png";
					$url = "view_objetive.php?data=" . $data = base64_encode("data" . $datas[$i]["id"]);
					?>
					<div class="col-md-2">
						<a href="<?php echo$url?>">
							<img id="viga_logo" class="img-responsive" src="<?php echo$imagen?>" alt="User profile picture" width="100%">
						</a>
					</div>
			<?php
				} ?>
	</div>

	<div class="box-body">
			<?php
				for($i=12 ; $i<17 ; $i++) {
					$imagen = "../../img/ods-" . $datas[$i]["id"] . ".png";
					$url = "view_objetive.php?data=" . $data = base64_encode("data" . $datas[$i]["id"]);
					?>
					<div class="col-md-2">
						<a href="<?php echo$url?>">
							<img id="viga_logo" class="img-responsive" src="<?php echo$imagen?>" alt="User profile picture" width="100%">
						</a>
					</div>
			<?php
				} ?>

			<div class="col-md-2">
				<img id="viga_logo" class="img-responsive" src="../../img/ods-0.jpg" alt="User profile picture" width="100%">
			</div>
	</div>


    <!--div class="box-body table-responsive">
    	<table id="table" class="table table-bordered table-hover">
        	<thead>
                <tr>
                  <th width="15%">Número de Objetivo</th>
                  <th width="35%">Nombre</th>
                  <th width="50%">Descripción</th>
                </tr>
            </thead>
       		<tbody>
       			<?php
       				for($i=0 ; $i<sizeof($datas) ; $i++) { ?>
       					<tr>
            			<td><?php echo $datas[$i]['id'];?></td>
            			<td>
            				<a href="#" title='Ver Objetivo'
											data-id='<?php echo $datas[$i]['id']?>'
											data-nombre='<?php echo $datas[$i]['nombre']?>'
											data-descripcion='<?php echo $datas[$i]['descripcion']?>'
											data-toggle="modal" data-target="#viewObjetive">
											<?php echo $datas[$i]['nombre'];?>
										</a>
									</td>
            			<td><?php echo $datas[$i]['descripcion'];?></td>
                </tr>
       			<?php
       				} ?>

            </tbody>
        </table>
    </div-->
