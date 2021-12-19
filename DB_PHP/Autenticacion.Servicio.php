<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    $sql_verificar = "SELECT * FROM usuarios WHERE Cuenta = ? AND Contraseña = ?";

    $estado_obj = $DB_CONEXION->prepare($sql_verificar);
    $estado_obj->execute(array($datos->usuario, $datos->contrasena));
    
    if(!$estado_obj){
        //echo "Cuenta invalida";
        //exit(0);
    }

    $cuenta = $estado_obj->fetch(PDO::FETCH_ASSOC);
    //echo $cuenta["Cuenta"] . " " . $cuenta["Contraseña"];
    //echo "Cuenta valida";
    
?>