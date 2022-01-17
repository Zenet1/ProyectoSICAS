<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Alumno/Alumno.Servicio.php");
include_once("../Clases/Query.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

//$AlumnoControl = new Alumno(new Query());

print_r($datos);
switch ($datos->accion) {
    case "validacionReservasAlumno":
        $AlumnoControl->validarReservaNoExistente($datos);
        break;
    case "obtenerClases":
        //print_r($contenido);
        $AlumnoControl->obtenerMateriasDisponibles();
        break;
    case "insertarReservaAlumno":
        $AlumnoControl->insertarReservasAlumno($datos);
        break;
}
