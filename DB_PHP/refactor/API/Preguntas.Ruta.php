<?php
session_start();

include_once("Servicios/Administrador/Pregunta.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Email.Class.php");
include_once("../Clases/Conexion.Class.php");

Conexion::ReconfigurarConexcion($_SESSION["Conexion"]);
$QueryObj = new Query();
$PreguntaControl = new Pregunta($QueryObj);
$Correo = new CorreoManejador();

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "recuperarPreguntas":
        $PreguntaControl->FiltrarPreguntas();
        break;
    case "enviarCorreo":
        
        break;
}

function Rechazo(CorreoManejador $correo)
{

    $asunto = "Rechazo de la solicitud de asistencia";
    $mensaje = "Debido a las respuestas introducidas en el cuestionario, y bajo las metricas medicas ";
    $mensaje .= "que se usan en la facultad, se te a rechazado la solicitud de asistencia ya que ";
    $mensaje .= "cuentas con un alto grado de probabilidad de ser portador asintomatico";
    //$correo->EnviarCorreo();
}
