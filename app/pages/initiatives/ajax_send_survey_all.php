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

	// vg_usuario, vg_id_initiative
	// vg_asunto, vg_mensaje, vg_id_encuesta

	if( isset($_REQUEST['vg_id_initiative']) && isset($_REQUEST['vg_asunto']) && isset($_REQUEST['vg_mensaje']) && isset($_REQUEST['vg_usuario']) ) {

		include_once("../../controller/medoo_survey.php");
		$encuesta = getSurvey(noeliaDecode($_REQUEST['vg_id_encuesta']));

		include_once("../../controller/medoo_attendance_list.php");
		$attendanceList = getVisibleAttendanceByInitiativeType(noeliaDecode($_REQUEST['vg_id_initiative']), $encuesta[0]["tipo"]);

			/* ENVIAR CORREO DE CONFIRMACIÓN AL USUARIO y PRESTADOR */
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: Vinculamos <noreply@vinculamos.cl>' . "\r\n";

				//$destinatario = $attendance[0]["nombre"] . "<" . $attendance[0]["correo_electronico"] . ">";
				$destinatario = ($attendance[0]["correo_electronico"]);
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
				for($j=0 ; $j<sizeof($attendanceList) ; $j++) {
					$mail->AddAddress($attendanceList[$j]["correo_electronico"]);
				}
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

		if($encuesta != null) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Encuesta enviada correctamente a <?php echo $attendance[0]["nombre"]?>.
			</div>
		<?php
		} else { ?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				No pudimos enviar la encuesta.
			</div>
		<?php
		}

	} else {
		echo "<br> Falta info";
	}
?>
