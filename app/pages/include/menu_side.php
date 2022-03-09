<?php
	include_once("../include/menu_top.php");
	include_once("../../utils/user_utils.php");

	if(!isset($_SESSION)){
		@session_start();
	}

	$nombre = noeliaDecode($_SESSION["nombre"]) . " " . noeliaDecode($_SESSION["apellido"]);
	$perfil = noeliaDecode($_SESSION["perfil"]);
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class='main-sidebar'>
	<!-- sidebar: style can be found in sidebar.less -->
    <section class='sidebar'>
    	<!-- Sidebar user panel -->
      	<div class='user-panel' style="background-color: #474747;">
        	<div class='pull-left image'>
          		<img src='../../img/sanagustin_logo.png' alt='User Image'>
							<!--img src='../../img/logo_solo.png' alt='User Image'-->
        	</div>
        	<div class='pull-left info' >
          		<p><?php echo $nombre; ?></p>
          		<i class='fa fa-circle text-success'></i> <?php echo $perfil; ?>
        	</div>
      	</div>

      	<!-- sidebar menu: : style can be found in sidebar.less -->
      	<ul class='sidebar-menu' data-widget='tree'>
        	<li class='header'>MENÚ PRINCIPAL</li>

					<li class='<?php if($activeMenu == "home") echo "active" ?>'>
						<a href="../home/index.php">
							<i class="fa fa-home"></i> <span>Inicio</span>
						</a>
					</li>

        	<?php
        		if(canReadInitiatives()) { ?>
        			<li class='treeview <?php if($activeMenu == "initiatives") echo "active" ?>'>
          				<a href='#'>
            				<i class='fa fa-suitcase'></i> <span>Iniciativas</span>
            				<span class='pull-right-container'>
                  				<i class='fa fa-angle-left pull-right'></i>
                			</span>
          				</a>
          				<ul class='treeview-menu'>
            				<li><a href='../initiatives/view_initiatives.php'><i class='fa fa-circle-o'></i> Iniciativas Creadas</a></li>
            				<?php
        						if(canCreateInitiatives()) { ?>
        							<li><a href='../initiatives/add_initiative.php'><i class='fa fa-plus'></i> Crear Iniciativa</a></li>
        					<?php
        						} ?>
          				</ul>
          			</li>
        	<?php
        		} ?>

        	<?php
        		if(canReadChallenges() && false) { ?>
        			<li class='treeview <?php if($activeMenu == "challenges") echo "active" ?>'>
          				<a href='#'>
            				<i class='fa fa-rocket'></i> <span>Desafíos</span>
            				<span class='pull-right-container'>
                  				<i class='fa fa-angle-left pull-right'></i>
                			</span>
          				</a>
          				<ul class='treeview-menu'>
            				<li><a href='../challenges/view_challenges.php'><i class='fa fa-circle-o'></i> Ver Desafíos</a></li>
            				<?php
        						if(canCreateChallenges()) { ?>
        							<li><a href='../challenges/add_challenge.php'><i class='fa fa-plus'></i> Agregar Desafío</a></li>
        					<?php
        						} ?>
          				</ul>
          			</li>
        	<?php
        		} ?>

        	<?php
        		if(canReadUsers()) { ?>
        			<li class='treeview <?php if($activeMenu == "users") echo "active" ?>'>
          				<a href='#'>
            				<i class='fa fa-user'></i> <span>Usuarios</span>
            				<span class='pull-right-container'>
                  				<i class='fa fa-angle-left pull-right'></i>
                			</span>
          				</a>
          				<ul class='treeview-menu'>
            				<li><a href='../users/view_users.php'><i class='fa fa-circle-o'></i> Ver Usuarios</a></li>
          				</ul>
        			</li>
        	<?php
        		} ?>

        	<?php
        		if(canReadParameters()) { ?>
        			<li class='treeview <?php if($activeMenu == "parameters") echo "active" ?>'>
          				<a href='#'>
            				<i class='fa fa-gear'></i> <span>Parámetros</span>
            				<span class='pull-right-container'>
                  				<i class='fa fa-angle-left pull-right'></i>
                			</span>
          				</a>
          				<ul class='treeview-menu'>
            				<li><a href='../parameters/view_colleges.php'><i class='fa fa-circle-o'></i> Unidades institucionales</a></li>
            				<li><a href='../parameters/view_campus.php'><i class='fa fa-circle-o'></i> Sedes</a></li>
										<li><a href='../parameters/view_carrers.php'><i class='fa fa-circle-o'></i> Carreras</a></li>
										<li><a href='../parameters/view_programs.php'><i class='fa fa-circle-o'></i> Lineas de acción</a></li>
										<li><a href='../parameters/view_covenants.php'><i class='fa fa-circle-o'></i> Convenios</a></li>
										<!--li><a href='../parameters/view_responsibles.php'><i class='fa fa-circle-o'></i> Responsables</a></li-->
          				</ul>
        			</li>
			<?php
        		} ?>

      	<?php
      		if(canReadObjetives()) { ?>
      			<li class='treeview <?php if($activeMenu == "objetives") echo "active" ?>'>
        				<a href='#'>
          				<i class='fa fa-bookmark-o'></i> <span>Objetivos</span>
          				<span class='pull-right-container'>
                				<i class='fa fa-angle-left pull-right'></i>
              			</span>
        				</a>
        				<ul class='treeview-menu'>
          				<li><a href='../objetives/view_objetives.php'><i class='fa fa-circle-o'></i> Objs. de Desarrollo Sostenible</a></li>
        				</ul>
      			</li>
      	<?php
      		} ?>

					<?php
	      		if(canReadStats()) { ?>
	      			<li class='treeview <?php if($activeMenu == "stats") echo "active" ?>'>
	        				<a href='#'>
	          				<i class='fa fa-area-chart'></i></i> <span>Análisis de datos</span>
	          				<span class='pull-right-container'>
	                				<i class='fa fa-angle-left pull-right'></i>
	              			</span>
	        				</a>
	        				<ul class='treeview-menu'>
	          				<li><a href='../stats/view_stats.php'><i class='fa fa-circle-o'></i> Análisis según Iniciativas</a></li>
										<!--li><a href='../stats/view_stats_choose_variable.php'><i class='fa fa-circle-o'></i> Análisis según campos</a></li-->
	        				</ul>
	      			</li>
	      	<?php
	      		} ?>

					<?php
	      		if(canSuperviseStats()) { ?>
	      			<li class='treeview <?php if($activeMenu == "datas") echo "active" ?>'>
	        				<a href='#'>
	          				<i class='fa fa-database'></i></i> <span>Extracción de datos</span>
	          				<span class='pull-right-container'>
	                				<i class='fa fa-angle-left pull-right'></i>
	              			</span>
	        				</a>
	        				<ul class='treeview-menu'>
	          				<li><a href='../stats/view_apis.php'><i class='fa fa-circle-o'></i> APIs disponibles</a></li>
										<li><a href='../stats/view_export.php'><i class='fa fa-circle-o'></i> Exportar iniciativas</a></li>
									</ul>
	      			</li>
	      	<?php
	      		} ?>
    	</ul>
	</section>
	<!-- /.sidebar -->
</aside>
