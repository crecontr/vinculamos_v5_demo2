<?php
	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 1) {
		//header('Location: index.php');
		//return;
	}
?>

<?php
  include_once("../../utils/user_utils.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vinculamos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../../template/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../../template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../template/dist/css/AdminLTE.min.css">


  <link rel="stylesheet" href="../../../template/dist/css/skins/_all-skins.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../template/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="background-color: #fff">
<div class="login-box">
  <div class="login-logo">
    <a href="./">
    	<p>
    		<img src='../../img/logo_texto.png' class="center-block" alt='User Image' width="100%">
    	</p>
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingresa tus credenciales para entrar</p>

		<form method="post" id="login" name="login">
			<div id="mensaje_resultados"></div><!-- Carga los datos ajax -->

			<?php echo "<input type='hidden' value='".noeliaEncode("noelia")."' id='vg_token' name='vg_token' />"; ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="vg_alias" id="vg_alias" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="vg_password" id="vg_password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-orange btn-block btn-flat">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../../../template/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../../template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
  $("#login").submit(function( event ) {
    $('#login').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "./ajax_validate_user.php",
      data: parametros,
      beforeSend: function(objeto) {
        $("#mensaje_resultados").html("Cargando...");
      },
      success: function(datos) {
				//$("#mensaje_resultados").html(datos);

				var myJSON = JSON.parse(datos);
      	if(myJSON.viga_result == "1") {
      		window.location.href = "../home/index.php";
      	} else {
      		$("#mensaje_resultados").html("<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Datos inválidos.</div>");
      	}
      },
      error: function() {
        $('#login').attr("disabled", false);
        $("#mensaje_resultados").html("Error en el registro");
      }
    });

    event.preventDefault();
  })
</script>

</body>
</html>
