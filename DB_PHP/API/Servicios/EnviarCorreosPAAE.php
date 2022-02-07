<?php
session_start();
$EmailPath = realpath(dirname(__FILE__, 3) . "/Clases/Email.Class.php");
$QrPath = realpath(dirname(__FILE__, 3) . "/Clases/Qr.Class.php");
include_once($EmailPath);
include_once($QrPath);

$CorreoControl = new CorreoManejador();
$QrControl = new GeneradorQr();

function EnviarCorreos(CorreoManejador $CorreoControl, GeneradorQr $QrControl)
{
    $limCorreos = 10;
    $contElimanos = 0;
    $cantCorreos = sizeof($_SESSION["CorreosQR"]);
    $cantCorreosSobrantes = $cantCorreos - $limCorreos;
    $limActualizado = ($cantCorreosSobrantes >= $limCorreos ? $limCorreos : $cantCorreos);

    if ($cantCorreos <= 0) {
        session_write_close();
        exit();
    }

    foreach ($_SESSION["CorreosQR"] as $datos) {
        $destinatario = array($datos["correo"] => $datos["nombre"]);
        $mensaje  = $datos["mensaje"];
        $asunto = $datos["asunto"];
        $contenidoQR = $datos["contenidoQr"];
        $direccionQr = $datos["nombreQr"];

        $QrControl->setNombrePng(basename($direccionQr, ".png"));
        $QrControl->GenerarImagen($contenidoQR);

        $CorreoControl->setArchivo(true);
        $CorreoControl->EnviarCorreo($destinatario, $asunto, $mensaje, $direccionQr);
        //unlink($direccionQr);

        array_shift($_SESSION["CorreosQR"]);

        if (++$contElimanos > $limActualizado) {
            break;
        }
    }
}

EnviarCorreos($CorreoControl, $QrControl);

session_write_close();
