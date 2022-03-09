<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
	}

	include_once("../../utils/user_utils.php");
	if(!canReadStats()) {
		header('Location: ../../index.php');
	}

	$institucion = getInstitution();
?>

<!DOCTYPE html>
<html>
<?php include_once("../../config/settings.php")?>
<?php include_once("../include/header.php")?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

	<?php
		$activeMenu = "datas";
		include_once("../include/menu_side.php");

		include_once("../initiatives/modal_calculate_invi.php");
	?>

  	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    	<!-- Content Header (Page header) -->
    	<section class="content-header">
      		<h1>
        		 Conexión mediante API
        		<small>todas las API</small>
      		</h1>
					<ol class="breadcrumb">
        		<li><i class="fa fa-dashboard"></i> Inicio</li>
        		<li>Análisis de datos</li>
        		<li class="active">Conexión mediante API</li>
      		</ol>
    	</section>

    	<!-- Main content -->
    	<section class="content">
      	<div class="row">
					<div class="col-lg-12 col-xs-6">
						<div class="box box-default">
							<div class="box-header with-border">
							  <h3 class="box-title">APIs disponibles</h3>
							  <div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							  </div>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
							  <div class="row">

									<div class="col-lg-12 col-xs-6">
										<p>El enlace de acceso: <a>https://demo2.vinculamosvm01.cl/vinculamos_v5_demo2/app/api/data.php</a>
											<br>Para acceder a los datos se debe realizar una consulta HTTPS mediante el método GET, enviando los datos de acceso del usuario mediante "Basic Auth".
										</p>

										<p>La respuesta a la consulta tiene la siguiente estructura:</p>
										<pre style="font-weight: 600;">
[
    {
        "id": "",
        "nombre": "",
        "fecha_inicio": "",
        "fecha_finalizacion": "",
        "gestor_vinculo": "",
        "responsable": "",
        "responsable_cargo": "",
        "formato_implementacion": "",
        "entorno_detalle": "",
        "objetivo": "",
        "descripcion": "",
        "impacto_esperado": "",
        "resultado_esperado": "",
        "impacto_logrado_interno": "",
        "impacto_logrado_externo": "",
        "id_mecanismo": "",
        "id_frecuencia": "",
        "estado": "",
        "institucion": "demo",
        "linea_accion_nombre": "",
        "mecanismo_nombre": "",
        "frecuencia_nombre": "",
        "linea_accion_secundarios": [
            {
                "id": "",
                "nombre": ""
            }
        ],
        "unidad_ejecutora": [
            {
                "id": "",
                "nombre": ""
            }
        ],
        "sedes": [
            {
                "id": "",
                "nombre": ""
            }
        ],
        "paises": [
            {
                "id": "",
                "nombre": ""
            }
        ],
        "regiones": [
            {
                "id": "",
                "nombre": ""
            }
        ],
        "comunas": [
            {
                "id": "",
                "id_region": "",
                "nombre": ""
            }
        ],
        "invi": {
            "mecanismo": {
                "etiqueta": "",
                "valor": ""
            },
            "cobertura_territorialidad": {
                "etiqueta": "",
                "valor": ""
            },
            "cobertura_pertinencia": {
                "etiqueta": "",
                "valor": ""
            },
            "cobertura_cantidad": {
                "etiqueta": "",
                "valor": ""
            },
            "frecuencia": {
                "etiqueta": "",
                "valor": ""
            },
            "evaluacionInterna": {
                "valor": "",
                "etiqueta": ""
            },
            "evaluacionExterna": {
                "valor": "",
                "etiqueta": ""
            },
            "evaluacion": {
                "valor": "",
                "etiqueta": ""
            },
            "invi": {
                "total": ""
            }
        },
        "ods": [
            {
                "id": "",
                "nombre": ""
            }
        ]
    }
]

										</pre>
									</div>



								<!-- /.col -->
								</div>
							  <!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
					</div>
				</div>

    	</section>
    	<!-- /.content -->
  	</div>
  	<!-- /.content-wrapper -->

  <?php include_once("../include/footer.php")?>
</div>
<!-- ./wrapper -->

<script src="../../../template/bower_components/chart.js/Chart.js"></script>
<script src="../../../template/bower_components/jquery-knob/js/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

<script>
	$(document).ready(function(){
		//loadInitiativesByFilters();
	});

	$('#calculateScoreVCM').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal
		var iniciativa = button.data('iniciativa');
		var usuario = button.data('usuario');

		var modal = $(this);
		//modal.find('.modal-body #vg_usuario').val(usuario);
		//modal.find('.modal-body #vg_initiative').val(iniciativa);
		modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html("Prueba");

		var parametros = {
				"id_initiative" : iniciativa
		};

		$.ajax({
			type: "POST",
			url: "../initiatives/ajax_view_calculate_invi.php",
			data: parametros,
			beforeSend: function(objeto) {
				modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html("Cargando...");
			},
			success: function(datos) {
				modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html(datos);
			},
			error: function() {
				modal.find('.modal-body #resultados_modal_calculo_puntaje_vcm').html("Error en el registro");
			}
		});

	})

	function loadInitiativesByFilters() {
		var parametros = $("#filter_initiative").serialize();

		$.ajax({
			type: "POST",
				url:'./ajax_view_stats_by_filters.php',
				data:  parametros,
				beforeSend: function () {
						$('#mostrar_resultados').html('<img src="../../img/ajax-loader.gif"> Obteniendo información, espere por favor. Cargando...');
						//$("#resultado").html("");
				},
				success:  function (response) {
						$('#mostrar_resultados').html('');
						$("#mostrar_resultados").html(response);

						$('#table').DataTable({
							'language': {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							'paging'      : true,
							'lengthChange': true,
							'searching'   : true,
							'ordering'    : false,
							'info'        : true,
							'autoWidth'   : true
						})

						/* GRAFICO BARRA UNIDADES */
						var barChartDataUnidades = {
							labels: etiquetasUnidades,
							datasets: [{
								label: 'Número de iniciativas',
								backgroundColor: '#F39200',
								data: cantidadesUnidades
							}]
						};

						var chartGraficoBarra1 = document.getElementById("graficoBarra1");
						var myChart1 = new Chart(chartGraficoBarra1, {
							type: 'bar',
							data: barChartDataUnidades,
							options: {
								title: {
									display: true,
									text: "Número de iniciativas"
								},
								tooltips: {
									mode: 'index',
									intersect: true,
									footerFontStyle: 'normal'
								},
								legend: {
									display: false
								},
								responsive: true,
								scales: {
									xAxes: [{
										stacked: false,
										ticks: {
											autoSkip: false
										},
										scaleLabel: {
											display: true,
											labelString: "Unidades institucionales",
											fontStyle: "bold"
											}
									}],
									yAxes: [{
										stacked: false,
										ticks: {
											min: 0,
											fixedStepSize: 1
										},
										position: 'top',
										scaleLabel: {
											display: false,
											labelString: "Nº de iniciativas",
											fontStyle: "bold"
											}
									}]
								},
								scaleShowGridlines: true
							}
						});

						/* GRAFICO BARRA ENTORNOS */
						var barChartDataEntornos = {
							labels: etiquetasEntornos,
							datasets: [{
								label: 'Número de iniciativas',
								backgroundColor: '#337ab7',
								data: cantidadesEntornos
							}]
						};

						var chartGraficoBarra2 = document.getElementById("graficoBarra2");
						var myChart1 = new Chart(chartGraficoBarra2, {
							type: 'bar',
							data: barChartDataEntornos,
							options: {
								title: {
									display: true,
									text: "Número de iniciativas"
								},
								tooltips: {
									mode: 'index',
									intersect: true,
									footerFontStyle: 'normal'
								},
								legend: {
									display: false
								},
								responsive: true,
								scales: {
									xAxes: [{
										stacked: false,
										ticks: {
											autoSkip: false
										},
										scaleLabel: {
											display: true,
											labelString: "Grupo de interés",
											fontStyle: "bold"
											}
									}],
									yAxes: [{
										stacked: false,
										ticks: {
											min: 0
										},
										position: 'top',
										scaleLabel: {
											display: false,
											labelString: "Nº de iniciativas",
											fontStyle: "bold"
											}
									}]
								},
								scaleShowGridlines: true
							}
						});

						$(".knob").knob();

				},
				error: function() {
					$('#mostrar_resultados').html('');
					$("#mostrar_resultados").html(response);
				}
			});
	}
</script>
</body>
</html>
