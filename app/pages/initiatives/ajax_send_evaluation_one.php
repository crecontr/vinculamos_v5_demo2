<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../../template/plugins/PHPMailer/src/Exception.php';
require '../../../template/plugins/PHPMailer/src/PHPMailer.php';
require '../../../template/plugins/PHPMailer/src/SMTP.php';

	if(!isset($_SESSION)){
		@session_start();
	}

	if($_SESSION["activo"] == 0) {
		header('Location: ../../index.php');
		return;
	}

	include_once("../../utils/user_utils.php");
	$institucion = getInstitution();

	include_once("../../controller/medoo_initiatives.php");
	$initiativa = getInitiative(noeliaDecode($_REQUEST['vg_id_initiative']));

	include_once("../../controller/medoo_evaluation.php");
	$evaluation = getEvaluationByInitiativeIdEvaluation($initiativa[0]["id"], noeliaDecode($_REQUEST['id_evaluation']));

	include_once("../../controller/medoo_evaluation_evaluators.php");
	$evaluador = getEvaluator(noeliaDecode($_REQUEST['vg_id_evaluador']));

	if(false) {
		echo "<br> id_initiative: " . noeliaDecode($_REQUEST['vg_id_initiative']);
		echo "<br> id_evaluation: " . noeliaDecode($_REQUEST['id_evaluation']);
		echo "<br> type: " . $evaluation[0]["tipo_evaluacion"];
		echo "<br> vg_id_evaluador: " . noeliaDecode($_REQUEST['vg_id_evaluador']);
		echo "<br> evaluador: " . $evaluador[0]["nombre"];
		return;
	}

	if( isset($_REQUEST['vg_id_initiative']) && isset($_REQUEST['vg_asunto']) && isset($_REQUEST['vg_mensaje']) && isset($_REQUEST['vg_usuario']) ) {

		/* ENVIAR CORREO DE CONFIRMACIÓN AL USUARIO y PRESTADOR */
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: Vinculamos <noreply@vinculamosvm01.cl>' . "\r\n";

			$destinatario = ($evaluador[0]["correo_electronico"]);
			if(false) {
				echo "<br> destinatario: " . $destinatario;
				echo "<br> asunto: " . $_REQUEST['vg_asunto'];
				echo "<br> mensaje: " . $_REQUEST['vg_mensaje'];
				echo "<br> headers: " . $headers;
			}
			//mail($destinatario, $_REQUEST['vg_asunto'], $_REQUEST['vg_mensaje'], $headers);
		/* FIN ENVIAR CORREO DE CONFIRMACIÓN AL USUARIO */

		/* INICIO PHP Mailer */
		$mail = new PHPMailer(true);
		try {
			//Create a new PHPMailer instance
			$mail->IsSMTP();

			//Configuracion servidor mail
			$mail->From = "appvinculamos@gmail.com"; //remitente
			$mail->FromName = 'Vinculamos';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls'; //seguridad
			$mail->Host = "smtp.gmail.com"; // servidor smtp
			$mail->Port = 587; //puerto
			$mail->Username ='appvinculamos@gmail.com'; //nombre usuario
			$mail->Password = 'eduardolp13'; //contraseña

			// Configguración de correo
			$mail->IsHTML(true);
			$mail->CharSet = 'UTF-8';

			//Agregar destinatario
			$mail->AddAddress($destinatario);
			$mail->addBCC('crecontr@gmail.com');
			$mail->Subject = $_REQUEST['vg_asunto'];
			$mail->Body = $_REQUEST['vg_mensaje'];

			//Avisar si fue enviado o no y dirigir al index
			$mail->Send();

			//echo 'El mensaje ha sido enviado';
		} catch (Exception $e) {
			//echo 'El mensaje no se ha podido enviar, error: ', $mail->ErrorInfo;
		}
		/* FIN PHP Mailer */

		if($evaluation != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Evaluación enviada correctamente a <?php echo $evaluador[0]["nombre"]?>.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimos enviar la evaluación.
			</div>
		<?php
		}

	} else {
		echo "<br> Falta info";
	}
?>
