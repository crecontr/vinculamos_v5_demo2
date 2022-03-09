<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];

	include_once("../../utils/user_utils.php");

	$id = str_replace("data", "", noeliaDecode($_GET["data"]));

	include_once("../../controller/medoo_objetives.php");
	$datas = getObjetive($id);

	include_once("../../controller/medoo_measures.php");
	$measures = getMeasuresByObjetive($datas[0]["id"]);
?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "objetives";
		include_once("../include/menu_side.php");

		include_once("modal_view_objetive.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Objetivos de Desarrollo Sostenible
        		<small>todas los objetivos</small>
      		</h1>
      		<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Objetivos</li>
        		<li class="active">Objs de Desarrollo Sostenible</li>
      		</ol>
    	</section>

    	<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-body">
							<div class="col-md-8 col-xs-8">
								<img id="viga_logo" class="img-responsive" src="../../img/ods-titulo.png" alt="User profile picture" width="100%">
							</div>
							<div class="col-md-4 col-xs-4">
								<?php
									$imagen = "../../img/ods-" . $datas[0]["id"] . ".png";
								?>
								<img id="viga_logo" class="img-responsive" src="<?php echo$imagen;?>" alt="User profile picture" width="100px">
							</div>
						</div>

						<div class="box-body">
							<div class="col-md-6 col-xs-12">
								<div class="box-header">
		    					<h3 class="box-title">Objetivo #<?php echo $datas[0]["id"] . " " . $datas[0]["nombre_largo"];?></h3>
								</div>
								<?php echo $datas[0]["descripcion_larga"];?>
							</div>
							<div class="col-md-6 col-xs-12">
								<table id="table" class="table table-hover">
					        	<tbody>
					       			<?php
					       				for($i=0 ; $i<sizeof($measures) ; $i++) { ?>
					       					<tr>
					                  <td><?php echo $measures[$i]['id'] . ". - " . $measures[$i]['nombre'];?></td>
													</tr>
											<?php } ?>
										</tbody>
									</table>
							</div>
						</div>

						<!-- /.box-header -->
						<div id="mensaje_resultados"></div><!-- Carga los datos ajax -->

						<span id="loader"></span>
						<div id="resultados"></div><!-- Carga los datos ajax -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</section>
    	<!-- /.content -->
	</div>
  	<!-- /.content-wrapper -->

  	<?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->

<script>
	$(document).ready(function(){
	});

</script>
</body>
</html>
