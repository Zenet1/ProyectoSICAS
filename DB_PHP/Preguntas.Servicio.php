<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $sql_verificar = "SELECT * FROM preguntas";

    $estado_obj = $DB_CONEXION->prepare($sql_verificar);
    $estado_obj->execute();
    $datos = $estado_obj->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($datos);
?>