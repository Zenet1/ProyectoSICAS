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
        $mensaje = "Debido a las respuestas introducidas en el cuestionario, y bajo las métricas médicas ";
        $mensaje .= "que se usan en la facultad, se te ha rechazado la solicitud de asistencia, ya que ";
        $mensaje .= "cuentas con un alto grado de probabilidad de ser portador asintomático";

        $datosCorreo = array("asunto" => $asunto, "mensaje" => $mensaje, "nombre" => $_SESSION["Nombre"], "correo" => $_SESSION["Correo"]);
        array_push($_SESSION["CorreosRA"], $datosCorreo);
    }
}
