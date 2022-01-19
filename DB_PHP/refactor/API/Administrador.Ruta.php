<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
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
include_once("Servicios/Administrador/Respaldar/SICEIControl.Servicio.php");
include_once("Servicios/Administrador/Restaurar/RestaurarBD.Servicio.php");
include_once("Servicios/Administrador/Alertar.Servicio.php");
include_once("Servicios/Administrador/Estadisticas.Servicio.php");
include_once("Servicios/Administrador/Edificio.Servicio.php");
include_once("Servicios/Administrador/Oficina.Servicio.php");
include_once("Servicios/Administrador/Pregunta.Servicio.php");
include_once("../Clases/Conexion.Class.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Fechas.Class.php");
include_once("../Clases/Email.Class.php");
include_once("../Clases/ArchivosControl.Class.php");

$json = file_get_contents('php://input');
$datos = json_decode($json);

$Conexion = Conexion::ConexionInstacia();
$Fechas = Fechas::ObtenerInstancia();
$QueryObj = new Query();
$PlanesControl = new PlanesControl($QueryObj);
$RolesControl = new Roles($QueryObj);
$PorcentajeControl = new Porcentaje($QueryObj);
$SalonesControl = new Salones($QueryObj);
$BDControl = new ControlBD($QueryObj);
$EstadisticaControl = new EstadisticaControl($QueryObj);
$NUsuarios = new InsertarUsuario($QueryObj);
$EdificioControl = new Edificio($QueryObj);
$OficinaControl = new Oficina($QueryObj);
$PreguntaControl = new Pregunta($QueryObj);
$AlertaControl = new Alertar($QueryObj, new CorreoManejador(), $Fechas);
$SICEIControl = new SICEIControl($Conexion->getConexion(), new ArchivoControl($Fechas, "docs"));

switch ($datos->accion) {
    case "agregarUsuario":
        $NUsuarios->InsertarNuevoTrabajador((array)$datos->contenido);
        break;
    case "recuperarPorcentaje":
        $PorcentajeControl->RecuperarPorcentaje();
        break;
    case "actualizarPorcentaje":
        $PorcentajeControl->ActualizarPorcentaje((array) $datos->contenido);
        break;
    case "recuperarSalones":
        $SalonesControl->ObtenerSalones();
        break;
    case "actualizarSalon":
        $SalonesControl->ActualizarSalon((array)$datos->contenido);
        break;
    case "respaldarSICAS":
        break;
    case "eliminarSICAS":
        break;
    case "restaurarSICAS":
        break;
    case "restaurarSICEI":
        $SICEIControl->RestaurarSICEI();
        break;
    case "recuperarEstadisticaAlumno":
        $EstadisticaControl->EstadisticasAlumno((array) $datos->contenido);
        break;
    case "recuperarEstadisticaPersonal":
        break;
    case "alertaCOVID":
        $AlertaControl->Alertar((array) $datos->contenido);
        break;
    case "recuperarPreguntas":
        $PreguntaControl->recuperarPreguntas();
        break;
    case "agregarPregunta":
        $PreguntaControl->insertarPregunta((array)$datos->contenido);
        break;
    case "eliminarPregunta":
        $PreguntaControl->eliminarPregunta((array)$datos->contenido);
        break;
    case "recuperarEdificios":
        $EdificioControl->recuperarEdificios();
        break;
    case "recuperarOficinas":
        $OficinaControl->recuperarOficinas();
        break;
    case "recuperarRoles":
        $RolesControl->RecuperarRoles();
        break;
    case "eliminarOficina":
        $OficinaControl->eliminarOficina((string)$datos->contenido);
        break;
    case "agregarOficina":
        $OficinaControl->insertarOficina((array)$datos->contenido);
        break;
    case "recuperarPlanes":
        $PlanesControl->RecuperarPlanesEstudio();
        break;
    case "obtenerAfectados":
        $AlertaControl->obtenerAfectados((array) $datos->contenido);
        break;
}
