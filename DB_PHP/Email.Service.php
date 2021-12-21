<?php
    session_start();
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include 'BD_Conexion.php';
    include 'Email.Class.php';
    //include 'Qr.Class.php';
    
    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    
    switch($datos->accion){   
        case "EnviarQR":
            break;
        case "rechazado":
            Rechazo(Array($_SESSION["Correo"]=>$_SESSION["Nombre"]), "Problemas de seguridad");
            break;
    }

    function EnviarQR(array $datosDestinatario){

    }

    function Rechazo(array $datosDestinatario, string $msg){
        $correo = new CorreoManejador();
        $correo->EnviarCorreo($datosDestinatario, "Rechazado", $msg);
    }
?>