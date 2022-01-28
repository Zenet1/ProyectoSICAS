<?php
class CuestionarioControl
{
    private CorreoManejador $correo;

    public function __construct(CorreoManejador $correo)
    {
        $this->correo = $correo;
    }

    public function EnviarRechazo()
    {
        $asunto = "Rechazo de la solicitud de asistencia";
        $mensaje = "Debido a las respuestas introducidas en el cuestionario, y bajo las metricas medicas ";
        $mensaje .= "que se usan en la facultad, se te a rechazado la solicitud de asistencia ya que ";
        $mensaje .= "cuentas con un alto grado de probabilidad de ser portador asintomatico";
        $destinatario = array($_SESSION["Correo"] => $_SESSION["Nombre"]);

        $this->correo->EnviarCorreo($destinatario, $asunto, $mensaje);
    }
}
