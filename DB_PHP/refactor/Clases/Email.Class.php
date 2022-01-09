<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include_once("Env.Utileria.php");

class CorreoManejador
{
    private $mail;
    private $isArchivo;

    public function __construct()
    {
        $this->isArchivo = false;
        $this->mail = new PHPMailer(true);

        try {
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $this->mail->Username = $_ENV['EMAILACCOUNT'];                     //SMTP username
            $this->mail->Password = $_ENV['EMAILACCOUNTPASSWORD'];                             //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port = $_ENV['EMAILPORT'];                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        } catch (Exception $e) {
            error_log($e);
        }
    }

    public function EnviarCorreo(array $destinatarios, String $asunto, String $mensaje, $archivo = NULL)
    {
        try {
            $this->mail->setFrom($_ENV['EMAILACCOUNT'], 'SICAS');
            $this->mail->addAddress($_ENV['EMAILACCOUNT'], 'SICAS');

            foreach ($destinatarios as $correo => $nombre) {
                $this->mail->addCC($correo, $nombre);
            }

            if ($this->isArchivo) {
                $this->mail->addAttachment($archivo);
            }

            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $mensaje;

            $this->mail->send();
        } catch (Exception $e) {
        }
    }

    public function setArchivo(bool $booleano)
    {
        $this->isArchivo = $booleano;
    }
}
