<?php
include_once("Servicios/Administrador/Actualizar/ActualizarPorcentaje.Servicio.php");
include_once("Servicios/Administrador/Actualizar/ActualizarSalones.Servicio.php");
include_once("Servicios/Administrador/Insertar/IncentarOficina.Servicio.php");
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

$json = file_get_contents('php://input');
$datos = json_decode($json);
$PorcentajeCapacidad = new Porcentaje(new Query());

switch ($datos->accion) {
    case "recuperar":
        $PorcentajeCapacidad->RecuperarPorcentaje();
        break;
    case "actualizar":
        $PorcentajeCapacidad->ActualizarPorcentaje(array($datos->porcentaje));
        break;
}
