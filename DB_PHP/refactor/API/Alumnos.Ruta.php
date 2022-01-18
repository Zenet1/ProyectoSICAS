<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Alumno/ReservacionesControl.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$ReservacionesControl = new ReservaControl(new Query(), Fechas::ObtenerInstancia());

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
}
