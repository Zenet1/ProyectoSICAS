<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    session_start();

    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    
    $_SESSION['nombreExterno'] = "$datos->nombre";
    $_SESSION['apellidosExterno'] = "$datos->apellidos";
    $_SESSION['empresa'] = "$datos->empresa";
    $_SESSION['correoExterno'] = "$datos->correo";
?>