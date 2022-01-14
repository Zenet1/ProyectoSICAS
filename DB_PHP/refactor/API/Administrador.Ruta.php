<?php
include_once("Servicios/Administrador/Actualizar/ActualizarPorcentaje.Servicio.php");
include_once("Servicios/Administrador/Actualizar/ActualizarSalones.Servicio.php");
include_once("Servicios/Administrador/Insertar/InsertarOficina.Servicio.php");
include_once("Servicios/Administrador/Insertar/InsertarIncidente.Servicio.php");
include_once("Servicios/Administrador/Eliminar/EliminarBD.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarOficinas.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarPlanes.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarPorcentaje.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarSalones.Servicio.php");
include_once("Servicios/Administrador/Respaldar/RespaldarBD.Servicio.php");
include_once("Servicios/Administrador/Restaurar/RestaurarBD.Servicio.php");
include_once("Servicios/Administrador/Alertar.Servicio.php");
include_once("Servicios/Administrador/Estadisticas.Servicio.php");
include_once("Servicios/Administrador/Edificio.Servicio.php");
include_once("Servicios/Administrador/Oficina.Servicio.php");
include_once("Servicios/Administrador/Pregunta.Servicio.php");
include_once("../Clases/Query.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$PorcentajeControl = new Porcentaje(new Query());
$SalonesControl = new Salones(new Query());
$BDControl = new ControlBD(new Query());
$AlertasControl = new Alertar(new Query());
$EdificioControl = new Edificio();
$OficinaControl = new Oficina();
$PreguntaControl =new Pregunta();

$AlertasControl->Alertar((array)$datos);

/*
switch ($datos->accion) {
    case "recuperarPorcentaje":
        $PorcentajeCapacidad->RecuperarPorcentaje();
        break;
    case "actualizarPorcentaje":
        $PorcentajeCapacidad->ActualizarPorcentaje(array($datos["porcentaje"], 1));
        break;
    case "recuperarSalones":
        $SalonesControl->ObtenerSalones();
        break;
    case "actualizarSalon":
        $SalonesControl->ActualizarSalon(array($datos->salon->capacidad, $datos->salon->aula));
        break;
    case "respaldarSICAS":
        break;
    case "eliminarSICAS":
        break;
    case "restaurarSICAS":
        break;
    case "restaurarSICEI":
        break;
    case "recuperarEstadisticaAlumno":
        break;
    case "recuperarEstadistica":
        break;
    case "alertaCOVID":
        break;
    case "recuperarPreguntas":
        break;
    case "agregarPregunta":
        break;
    case "eliminarPregunta":
        break;
    case "":
        break;
}
*/