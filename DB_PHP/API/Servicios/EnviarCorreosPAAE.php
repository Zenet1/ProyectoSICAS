<?php
session_start();
include_once("../Clases/Email.Class.php");
include_once("../Clases/Qr.Class.php");

$CorreoControl = new CorreoManejador();
$QrControl = new GeneradorQr();

$limCorreos = 15;
$contElimanos = 0;
$cantCorreos = sizeof($_SESSION["NombreQr"]);
$cantCorreosSobrantes = $cantCorreos - $limCorreos;
$limActualizado = ($cantCorreosSobrantes  >= $limCorreos ? $limCorreos : $cantCorreos);

if ($cantCorreos <= 0) {
    exit();
}

foreach ($_SESSION["CorreosQR"] as $datos) {
    $destinatario = array($datos["correo"] => $datos["nombre"]);
    $mensaje  = $datos["mensaje"];
    $asunto = $datos["asunto"];
    $contenidoQR = $datos["contenidoQr"];
    $direccionQr = $datos["nombreQr"];

    $QrControl->setNombrePng(basename($nombreQr, ".png"));
    $QrControl->GenerarImagen($contenidoQR);

    $CorreoControl->setArchivo(true);
    $CorreoControl->EnviarCorreo($destinatario, $asunto, $mensaje, $direccionQr);
    unlink($direccionQr);

    array_shift($_SESSION["CorreosQR"]);

    if (++$contElimanos > $limActualizado) {
        break;
    }
}
