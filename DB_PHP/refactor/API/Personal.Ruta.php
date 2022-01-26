<?php
session_start();

include_once("Servicios/Personal/ReservaPersonal.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/Email.Class.php");
include_once("../Clases/Qr.Class.php");
include_once("../Clases/Conexion.Class.php");

Conexion::ReconfigurarConexion($_SESSION["Conexion"]);
$QueryObj = new Query();
$Correo = new CorreoManejador();

$PersonalControl = new ReservaPersonal($QueryObj, Fechas::ObtenerInstancia(), $Correo, new GeneradorQr());

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "insertarReservaPersonal":
        $PersonalControl->InsertarReserva((array) $datos->contenido);
        break;
    case "validacionReservaPersonal":
        $PersonalControl->validarReservaNoExistente((array) $datos->contenido);
        break;
}
