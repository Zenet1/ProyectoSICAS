<?php
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include 'BD_Conexion.php';
    include 'Email.Service.php';
    include 'Qr.Class.php';
    
    $json = file_get_contents('php://input');
    $datos = json_decode($json);

    switch($datos["accion"]){   
        case "EnviarQR":
            break;
        case "Rechazado":+
            Rechazo(Array($_SESSION["Correo"]=>$_SESSION["Nombre"]), "Debido a las metricas que se manejan para la sanidad de la institucion, no cumples con parametros de seguridad sanitaria");
            break;
    }

    function EnviarQR(array $datosDestinatario){

    }


    function Rechazo(array $datosDestinatario, string $msg){
        $correo = new CorreoManejador();
        $correo->EnviarCorreo($datosDestinatario, "Rechazado", $msg);
    }
?>