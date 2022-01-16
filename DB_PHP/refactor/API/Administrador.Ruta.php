<?php
include_once("Servicios/Administrador/Actualizar/ActualizarPorcentaje.Servicio.php");
include_once("Servicios/Administrador/Actualizar/ActualizarSalones.Servicio.php");
include_once("Servicios/Administrador/Insertar/InsertarOficina.Servicio.php");
include_once("Servicios/Administrador/Insertar/InsertarIncidente.Servicio.php");
include_once("Servicios/Administrador/Insertar/InsertarUsuario.Servicio.php");
include_once("Servicios/Administrador/Eliminar/EliminarBD.Servicio.php");
include_once("Servicios/Administrador/Recuperar/Roles.Servicio.php");
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
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/ArchivosControl.Class.php");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("../Clases/Query.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$RolesControl = new Roles(new Query());
$PorcentajeControl = new Porcentaje(new Query());
$SalonesControl = new Salones(new Query());
$BDControl = new ControlBD(new Query());
$AlertasControl = new Alertar(new Query());
$Fechas = Fechas::ObtenerInstancia();
$NUsuarios = new InsertarUsuario(new Query());
$EdificioControl = new Edificio(new Query());
$OficinaControl = new Oficina(new Query());
$PreguntaControl = new Pregunta(new Query());

switch ($datos->accion) {
    case "recuperarPorcentaje":
        $PorcentajeControl->RecuperarPorcentaje();
        break;
    case "actualizarPorcentaje":
        $PorcentajeControl->ActualizarPorcentaje($datos->contenido->porcentaje);
        break;
    case "recuperarSalones":
        $SalonesControl->ObtenerSalones();
        break;
    case "actualizarSalon":
        $SalonesControl->ActualizarSalon(array("cpd" => $datos->contenido->capacidad, "ids" => $datos->contenido->aula));
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
    case "recuperarEstadisticaPersonal":
        break;
    case "alertaCOVID":
        break;
    case "recuperarPreguntas":
        $PreguntaControl->recuperarPreguntas();
        break;
    case "agregarPregunta":
        $PreguntaControl->insertarPregunta((array) $datos->contenido);
        break;
    case "eliminarPregunta":
        $PreguntaControl->eliminarPregunta($datos->contenido);
        break;
    case "recuperarOficinas":
        $OficinaControl->recuperarOficinas();
        break;
    case "recuperarRoles":
        $RolesControl->RecuperarRoles();
        break;
    case "":
        break;
}
