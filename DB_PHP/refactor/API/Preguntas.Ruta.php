<?php
include_once("Servicios/Administrador/Pregunta.Servicio.php");
include_once("../Clases/Query.Class.php");

$QueryObj = new Query();
$PreguntaControl = new Pregunta($QueryObj);

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "recuperarPreguntas":
        $PreguntaControl->FiltrarPreguntas();
        break;
    case "enviarCorreo":
        break;
}
