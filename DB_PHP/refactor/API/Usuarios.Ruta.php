<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once("Servicios/Usuarios/Autenticar.Servicio.php");
include_once("../Clases/Query.Class.php");

$jsonUsuario = file_get_contents('php://input');
$datosCuentaUsuario = (array) json_decode($jsonUsuario);

$autenticacion = new Autenticar(new Query());
$autenticacion->AutenticarCuenta($datosCuentaUsuario);