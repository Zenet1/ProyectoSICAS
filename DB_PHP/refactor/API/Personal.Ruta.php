<?php
session_start();

include_once("Servicios/Administrador/Pregunta.Servicio.php");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Email.Class.php");
include_once("../Clases/Conexion.Class.php");

Conexion::ReconfigurarConexion($_SESSION["Conexion"]);
$QueryObj = new Query();
$Correo = new CorreoManejador();

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "insertarReservaPersonal":
        break;
    case "validacionReservaPersonal":
        break;
}
