<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once('Servicios/Escaneador/RegistrarAsistencia.Servicio.php');
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$Fechas = Fechas::ObtenerInstancia();
$AsistenciaControl = new RegistrarAsistencia(new Query(), $Fechas);

switch ($datos->accion) {
    case "registrarAsistencia":
        $AsistenciaControl->Asistencias((string)$datos->contenido);
        break;
}
