<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'Utileria.php';

class CorreoManejador
{
    private $mail;
    private $isArchivo;

    public function __construct() {
        $this->isArchivo = false;
        $this->mail = new PHPMailer(true);

        try {
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $this->mail->Username = $_ENV['EMAILACCOUNT'];                     //SMTP username
            $this->mail->Password = $_ENV['EMAILACCOUNTPASSWORD'];                             //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port = $_ENV['EMAILPORT'];                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        } catch (Exception $e) {
            echo "Error al configurar el EMAIl" . $e->getMessage();
        }
    }

    public function EnviarCorreo($destinatario, String $asunto,String $mensaje, $archvio = NULL){
        try {
            $this->mail->setFrom($_ENV['EMAILACCOUNT'], 'SICAS');
            $this->mail->addAddress('eduardzenet@outlook.com');     //Add a recipient
            
            if($this->isArchivo){
                $this->mail->addAttachment($archvio);
            }
            
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $asunto;
            $this->mail->Body = $mensaje;
            //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Algun error a ocurrido al enviar el mensaje";
        }
    }

    public function setArchivo(bool $booleano){
        $this->isArchivo = $booleano;
    }
}

?>