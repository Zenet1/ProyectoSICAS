<?php
session_start();
include_once("../Clases/Email.Class.php");

$CorreoControl = new CorreoManejador();

$limCorreos = 15;
$contElimanos = 0;
$cantCorreos = sizeof($_SESSION["CorreosRA"]);
$cantCorreosSobrantes = $cantCorreos - $limCorreos;
$limActualizado = ($cantCorreosSobrantes  >= $limCorreos ? $limCorreos : $cantCorreos);

if ($cantCorreos <= 0) {
    exit();
}

foreach ($_SESSION["CorreosRA"] as $datos) {
    $destinatario = array($datos["correo"] => $datos["nombre"]);
    $mensaje  = $datos["mensaje"];
    $asunto = $datos["asunto"];

    $CorreoControl->EnviarCorreo($destinatario, $asunto, $mensaje);

    array_shift($_SESSION["CorreosRA"]);

    if (++$contElimanos > $limActualizado) {
        break;
    }
}