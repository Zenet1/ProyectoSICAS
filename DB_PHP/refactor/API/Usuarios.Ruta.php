<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("../Clases/Query.Class.php");
include_once("Servicios/Usuarios/AutenticarAlumno.Servicio.php");
include_once("Servicios/Usuarios/AutenticarTrabajador.Servicio.php");

$jsonUsuario = file_get_contents('php://input');
$datosCuentaUsuario = (array) json_decode($jsonUsuario);

