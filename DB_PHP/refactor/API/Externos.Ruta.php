<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Externo/Externo.Servicio.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/ArchivosControl.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$ExternoControl = new Externo();

switch ($datos->accion) {
    case "registroExterno":
        $ExternoControl->registroExterno($datos->datosExterno);
        break;
    case "insertarReservaExterno":
        $ExternoControl->insertarReservaExterno(json_decode($datos->datosReservaExterno));
        break;
}
