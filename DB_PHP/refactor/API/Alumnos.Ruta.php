<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once("Servicios/Alumno/ReservacionesControl.Servicio.php");
include_once("Servicios/Alumno/AlumnoControl.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Conexion.Class.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/Qr.Class.php");
include_once("../Clases/Email.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

Conexion::ReconfigurarConexcion($_SESSION["Conexion"]);
$Fechas = Fechas::ObtenerInstancia();
$Query = new Query();

$ReservacionesControl = new ReservaControl($Query, $Fechas);
$AlumnosControl = new AlumnoControl($Query, $Fechas);

switch ($datos->accion) {
    case "validacionReservas":
        $ReservacionesControl->validarReservaNoExistente();
        break;
    case "obtenerClases":
        $ReservacionesControl->obtenerMateriasDisponibles();
        break;
    case "insertarReservas":
        $ReservacionesControl->insertarReservasAlumno((array)$datos->contenido);
        break;
    case "enviarQRAlumno":
        $AlumnosControl->EnviarQRCorreo(new CorreoManejador(), new GeneradorQr());
        break;
}
