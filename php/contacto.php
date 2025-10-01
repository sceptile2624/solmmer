<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;

use League\OAuth2\Client\Provider\Google;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST['nombre'];
    $correo   = $_POST['correo'];
    $ciudad   = $_POST['ciudad'];
    $telefono = $_POST['telefono'];
    $mensaje  = $_POST['mensaje'];

    $mail = new PHPMailer(true);

    try {
        // Configuración OAuth2
        $clientId = '85552810135-5jjiooo902r0p3qc679fedgkjvsdo853.apps.googleusercontent.com';
        $clientSecret = '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';
        $refreshToken = 'AQUI_VA_TU_REFRESH_TOKEN';

        // Configurar Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth   = true;
        $mail->AuthType   = 'XOAUTH2';

        $provider = new Google([
            'clientId'     => $clientId,
            'clientSecret' => $clientSecret,
        ]);

        $mail->setOAuth(new OAuth([
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => 'solmmer4@gmail.com',
        ]));

        // Configuración del correo
        $mail->setFrom('solmmer4@gmail.com', 'Web Solmmer');
        $mail->addAddress('contacto@solmmer.com.mx');
        $mail->addReplyTo($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = "Mensaje enviado desde la Web";
        $mail->Body    = "
            <h3>Nuevo mensaje desde el formulario</h3>
            <p><b>Nombre:</b> $nombre</p>
            <p><b>Correo:</b> $correo</p>
            <p><b>Teléfono:</b> $telefono</p>
            <p><b>Ciudad:</b> $ciudad</p>
            <p><b>Mensaje:</b><br>$mensaje</p>
        ";

        $mail->send();
        header("Location: ../thank-you-page.html");
        exit;
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
