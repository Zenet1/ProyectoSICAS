<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    session_start();

    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    
    $_SESSION['Nombre'] = "$datos->nombre";
    $_SESSION['Apellidos'] = "$datos->apellidos";
    $_SESSION['Empresa'] = "$datos->empresa";
    $_SESSION['Correo'] = "$datos->correo";

    $idExterno = (int) random_int(0, 99);
    $nombreExterno = $_SESSION['Nombre'];
    $apellidosExterno = $_SESSION['Apellidos'];
    $empresa = $_SESSION['Empresa'];
    $correoExterno = $_SESSION['Correo'];
?>