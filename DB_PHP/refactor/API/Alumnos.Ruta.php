<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Alumno/Alumno.Servicio.php");
include_once("../Clases/Query.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$AlumnoControl = new Alumno(new Query());

switch ($datos->accion) {
    case "validacionReservasAlumno":
        $AlumnoControl->validarReservaNoExistente($datos);
        break;
    case "obtenerClasesAlumno":
        $AlumnoControl->obtenerMateriasDisponibles();
    case "insertarReservaAlumno":
        $AlumnoControl->insertarReservasAlumno($datos);
        break;
}
