<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

function enviarCorreoSMTP($destinatario, $asunto, $mensaje) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'proyectoclinicads7';
        $mail->Password = 'txqc arwr ocqx nuiq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('proyectoclinicads7@gmail.com', 'Clinica Pacoren');
        $mail->addAddress($destinatario);
        $mail->Subject = $asunto;
        $mail->isHTML(true);
        $mail->Body = $mensaje;

        // Enviar
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
