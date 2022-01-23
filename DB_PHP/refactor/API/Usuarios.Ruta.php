<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("../Clases/Query.Class.php");
include_once("../Clases/Conexion.Class.php");
include_once("Servicios/Usuarios/Autenticar.Servicio.php");

$jsonUsuario = file_get_contents('php://input');
$datos = (array) json_decode($jsonUsuario);

Conexion::ReconfigurarConexcion($datos["facultad"]);
$QueryControl = new Query();
$UsuariosControl = new Autenticar($QueryControl);

$UsuariosControl->ValidarCuenta($datos);
