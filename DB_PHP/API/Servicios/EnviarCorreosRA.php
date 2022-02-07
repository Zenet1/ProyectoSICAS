<?php
session_start();
$EmailPath = realpath(dirname(__FILE__, 3) . "/Clases/Email.Class.php");
include_once($EmailPath);
$CorreoControl = new CorreoManejador();

if (!isset($_SESSION["CorreosRA"])) {
    $_SESSION["CorreosRA"] = array();
}

$limCorreos = 15;
$contElimanos = 0;
$cantCorreos = sizeof($_SESSION["CorreosRA"]);
$cantCorreosSobrantes = $cantCorreos - $limCorreos;
$limActualizado = ($cantCorreosSobrantes  >= $limCorreos ? $limCorreos : $cantCorreos);

if ($cantCorreos <= 0) {
    session_write_close();
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
session_write_close();