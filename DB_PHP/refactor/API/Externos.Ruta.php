<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Externo/ExternoControl.Servicio.php");
include_once("Servicios/Externo/ReservacionesExterno.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/Qr.Class.php");
include_once("../Clases/Email.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$ExternoControl = new ExternoControl(new Query(), Fechas::ObtenerInstancia());
$ReservacionExterno = new ReservacionExterno(new Query(), Fechas::ObtenerInstancia());

switch ($datos->accion) {
    case "registroExterno":
        $ReservacionExterno->registroExterno($datos->contenido);
        break;
    case "insertarReservaExterno":
        $ReservacionExterno->insertarReservaExterno($datos->oficinas, $datos->fecha);
        break;
    case "enviarQRExterno":
        $ExternoControl->enviarQRExterno($datos->oficinas, $datos->fecha);
        break;
}
