
<header class="main-header">
    <!-- Logo -->
    <a href="../" class="logo" style="background-color: #fff7ed;">
    	<!-- mini logo for sidebar mini 50x50 pixels -->
      	<span class="logo-mini"><b><img src='../../img/logo_solo_sin_fondo.png' alt='User Image' width="50"></b></span>
      	<!-- logo for regular state and mobile devices -->
      	<span class="logo-lg"><b><img src='../../img/logo_texto_sin_bajada.png' alt='User Image' width="200"></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
    	<!-- Sidebar toggle button-->
      	<a href="#" class="sidebar-toggle fa-lg" data-toggle="push-menu" role="button">
        	<span class="sr-only">Toggle navigation</span>
      	</a>

      	<div class="navbar-custom-menu">
        	<ul class="nav navbar-nav">
        		<!--li class="messages-menu">
            		<a href="../reports/view_reports1.php">
              			<i class="ion ion-android-map"></i>
              			<span id="notificationTerreno" class="label label-success"></span>
            		</a>
            	</li>
            	<li class="messages-menu">
            		<a href="../reports/view_reports2.php">
              			<i class="ion ion-settings"></i>
              			<span id="notificationMantencion" class="label label-warning"></span>
            		</a>
            	</li>
            	<li class="messages-menu">
            		<a href="../reports/view_reports3.php">
              			<i class="ion ion-ios-list"></i>
              			<span id="notificationMateriales" class="label label-danger"></span>
            		</a>
            	</li-->

        		<li>
        			<a href="../../handler/logout.php"> <i class="fa fa-sign-out fa-lg"></i> Cerrar sesión</a>
        		</li>
        	</ul>
    	</div>
    </nav>
</header>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!--script type="text/javascript">
		$(document).ready(function() {

			function getRandValue(){

        		$.ajax({
            		type: "GET",
            		url: "../../api/notifications/getLasts.php",
            		//data: dataString,
            		dataType: "text",
            		success: function(data) {
            			var response = JSON.parse(data);

            			if(response.ht_terreno > 0) {
            				$('#notificationTerreno').html(response.ht_terreno);
            			}
            			if(response.ht_mantencion > 0) {
            				$('#notificationMantencion').html(response.ht_mantencion);
            			}
            			if(response.ht_materiales > 0) {
            				$('#notificationMateriales').html(response.ht_materiales);
            			}
            		},
            		error: function(data) {
                		$('#prueba').html("Error");
            		}
        		});
    		}

    		setInterval(getRandValue, 3000);
		});
</script-->
