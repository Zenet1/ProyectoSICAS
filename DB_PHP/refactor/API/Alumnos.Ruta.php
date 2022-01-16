<?php
include_once("Servicios/Alumno/Alumno.Servicio.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/ArchivosControl.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$AlumnoControl = new Alumno();

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