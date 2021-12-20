<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos = json_decode($json);
    $sql_verificar = "SELECT * FROM usuarios,roles WHERE Cuenta = ? AND Contraseña = ? AND usuarios.IDRol = roles.IDRol";

    $estado_obj = $DB_CONEXION->prepare($sql_verificar);
    $estado_obj->execute(array("$datos->usuario", "$datos->contrasena"));
    $datos = $estado_obj->fetch(PDO::FETCH_ASSOC);

    if($datos != null && $datos != false){
        $datos_alumnos = array("Cuenta"=>$datos["Cuenta"] , "Rol"=>$datos["Rol"]);
        echo json_encode($datos_alumnos);
    }
?>