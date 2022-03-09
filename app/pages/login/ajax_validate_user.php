<?php
	include_once("../../utils/user_utils.php");

	$debug = false;
	if($debug) {
		echo "<br>Validar usuario";
		echo "<br>vg_alias: " . $_REQUEST['vg_alias'];
		echo "<br>vg_password: " . $_REQUEST['vg_password'];
		echo "<br>vg_token: " . noeliaDecode($_REQUEST['vg_token']);
		return;
	}

	if( isset($_REQUEST['vg_alias']) && isset($_REQUEST['vg_password']) && isset($_REQUEST['vg_token']) ) {

		include_once("../../controller/medoo_users.php");

		$datas = null;
		if(noeliaDecode($_REQUEST['vg_token']) == "noelia") {
			$datas = validateUser($_REQUEST['vg_alias'], $_REQUEST['vg_password']);
		}

		if($datas != null) {

			if(!isset($_SESSION)){
				@session_start();
			}

			if($datas[0]["permisos_nombre"] == "Concesionario") {
				$response = array(
    			'viga_result' => "0",
    			'viga_message' => "No",
    			'viga_id' => $_REQUEST['vg_email']
    		);
    		echo json_encode($response);
				return;
			}

			$_SESSION["activo"] = 1;
			$_SESSION["nombre_usuario"] = noeliaEncode($datas[0]["nombre_usuario"]);
			$_SESSION["nombre"] = noeliaEncode($datas[0]["nombre"]);
			$_SESSION["apellido"] = noeliaEncode($datas[0]["apellido"]);
			$_SESSION["perfil"] = noeliaEncode($datas[0]["perfil"]);

			$_SESSION["permiso_usuarios"] = $datas[0]["permiso_usuarios"];
			$_SESSION["permiso_objetivos"] = $datas[0]["permiso_objetivos"];
			$_SESSION["permiso_iniciativas"] = $datas[0]["permiso_iniciativas"];
			$_SESSION["permiso_desafios"] = $datas[0]["permiso_desafios"];
			$_SESSION["permiso_estadisticas"] = $datas[0]["permiso_estadisticas"];
			$_SESSION["permiso_parametros"] = $datas[0]["permiso_parametros"];

			$_SESSION["permiso_institucion"] = $datas[0]["permiso_institucion"];

			$response = array(
    			'viga_result' => "1",
    			'viga_message' => "Ok",
    			'viga_id' => $_REQUEST['vg_email']
    		);
    		echo json_encode($response);

		} else {
			$response = array(
    			'viga_result' => "0",
    			'viga_message' => "No",
    			'viga_id' => $_REQUEST['vg_email']
    		);
    		echo json_encode($response);
		}

	} else {
		echo "Falta info";
	}

?>
