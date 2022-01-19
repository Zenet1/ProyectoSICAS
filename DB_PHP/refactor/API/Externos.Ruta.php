<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Externo/ExternoControl.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/Qr.Class.php");
include_once("../Clases/Email.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$ExternoControl = new ExternoControl(new Query(), Fechas::ObtenerInstancia());

switch ($datos->accion) {
    case "registroExterno":
        $ExternoControl->registroExterno($datos->contenido);
        break;
    case "insertarReservaExterno":
        $ExternoControl->insertarReservaExterno($datos->oficinas, $datos->fecha);
        break;
    case "enviarQRExterno":
        $ExternoControl->EnviarQRCorreo(new CorreoManejador(), new GeneradorQr());
        break;
}
