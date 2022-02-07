<?php
session_start();
$EmailPath = realpath(dirname(__FILE__,3)."/Clases/Email.Class.php");
include_once($EmailPath);

$CorreoControl = new CorreoManejador();

if (!isset($_SESSION["CorreosLista"])) {
    session_write_close();
    exit();
}

$limCorreos = 15;
$contElimanos = 0;
$cantCorreos = sizeof($_SESSION["CorreosLista"]);
$cantCorreosSobrantes = $cantCorreos - $limCorreos;
$limActualizado = ($cantCorreosSobrantes  >= $limCorreos ? $limCorreos : $cantCorreos);

foreach ($_SESSION["CorreosLista"] as $datos) {
    $destinatario = array($datos["correo"] => $datos["nombre"]);
    $mensaje  = $datos["mensaje"];
    $asunto = $datos["asunto"];

    //$CorreoControl->EnviarCorreo($destinatario, $asunto, $mensaje);

    array_shift($_SESSION["CorreosLista"]);

    if (++$contElimanos > $limActualizado) {
        break;
    }
}

if ($cantCorreosSobrantes <= 0) {
    unset($_SESSION["CorreosLista"]);
}
session_write_close();