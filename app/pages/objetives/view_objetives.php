<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	$nombre_usuario = $_SESSION["nombre_usuario"];

	include_once("../../utils/user_utils.php");
?>

<!DOCTYPE html>
<html>
<?php include_once("../include/header.php")?>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<?php
		$activeMenu = "objetives";
		include_once("../include/menu_side.php");
		//include_once("modal_view_objetive.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		Objetivos de Desarrollo Sostenible
        		<small>todos los objetivos</small>
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
		load();
	});

	function load() {
		$.ajax({
			type: "POST",
      url:'./ajax_view_objetives.php',
      data:  '',
      beforeSend: function () {
          $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
          $("#resultados").html("Obteniendo información, espere por favor.");
      },
      success:  function (response) {
        $('#loader').html('');
        $("#resultados").html(response);

        $('#table').DataTable({
					'language': {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
  				'paging'      : false,
  				'lengthChange': true,
  				'searching'   : true,
  				'ordering'    : true,
  				'info'        : true,
  				'autoWidth'   : true
				})
      },
			error: function() {
				$('#loader').html('');
				$("#resultados").html(response);
			}
    });
	}

	$('#viewObjetive').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var id = button.data('id');
		var nombre = button.data('nombre');
		var descripcion = button.data('descripcion');

		var modal = $(this);
		modal.find('.modal-header #viga_titulo').html(id + " " + nombre);

		var d = new Date();
		modal.find('.modal-body #viga_logo').attr("src", "../../img/ods-" + id +".png" + "?" + d.getTime());

		modal.find('.modal-body #viga_nombre').html(nombre);
		modal.find('.modal-body #viga_descripcion').html(descripcion);

		var parametros = {
			"id_objetive" : id
        };

        modal.find('.modal-body #viga_metas').html("Obteniendo metas...");

		$.ajax({
			type: "GET",
			url:'../ajax/json_measures.php',
			data:  parametros,
			success:  function (response) {
				//$('#resultados_modal_agregar_objetivo').html("");

				var myJSON = JSON.parse(response);

				var table = '<table id="tableMeasures" class="table table-bordered table-hover">';
        		table += '		<thead>';
                table += '			<tr>';
                table += '				<th>Número de Meta</th>';
                table += '				<th>Nombre</th>';
                table += '			</tr>';
            	table += '		</thead>';
       			table += '		<tbody>';
            	for (var i = 0; i < myJSON.length; i++) {
					var measure = myJSON[i];
					table += '<tr>';
					table += ('	<td>' + measure.id + '</td>');
					table += ('	<td>' + measure.nombre + '</td>');
					table += '</tr>';
				}
				table += '		</tbody>';
				table += '</table>';

            	modal.find('.modal-body #viga_metas').html(table);
			},


			error: function() {
				modal.find('.modal-body #viga_metas').html("Error en registro");
			}
		})

	})

</script>
</body>
</html>
