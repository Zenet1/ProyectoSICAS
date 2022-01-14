<?php
include_once("Servicios/Administrador/Actualizar/ActualizarPorcentaje.Servicio.php");
include_once("Servicios/Administrador/Actualizar/ActualizarSalones.Servicio.php");
include_once("Servicios/Administrador/Insertar/InsertarUsuario.Servicio.php");
include_once("Servicios/Administrador/Insertar/IncertarIncidente.Servicio.php");
include_once("Servicios/Administrador/Eliminar/EliminarBD.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarOficionas.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarPlanes.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarPorcentaje.Servicio.php");
include_once("Servicios/Administrador/Recuperar/RecuperarSalones.Servicio.php");
include_once("Servicios/Administrador/Respaldar/RespaldarBD.Servicio.php");
include_once("Servicios/Administrador/Restaurar/RestaurarBD.Servicio.php");
include_once("Servicios/Administrador/Alertar.Servicio.php");
include_once("Servicios/Administrador/Estadisticas.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/ArchivosControl.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$PorcentajeControl = new Porcentaje(new Query());
$SalonesControl = new Salones(new Query());
$BDControl = new ControlBD(new Query());
$AlertasControl = new Alertar(new Query());
$Fechas = Fechas::ObtenerInstancia();
$NUsuarios = new InsertarUsuario(new Query());

$NUsuarios->InsertarNuevoTrabajador((array) $datos);
/*
switch ($datos->accion) {
    case "recuperarPorcentaje":
        $PorcentajeCapacidad->RecuperarPorcentaje();
        break;
    case "actualizarPorcentaje":
        $PorcentajeCapacidad->ActualizarPorcentaje(array("pct" => $datos["porcentaje"]));
        break;
    case "recuperarSalones":
        $SalonesControl->ObtenerSalones();
        break;
    case "actualizarSalon":
        $SalonesControl->ActualizarSalon(array("cpd" => $datos->salon->capacidad, "ids" => $datos->salon->aula));
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