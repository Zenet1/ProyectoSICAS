<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    session_start();

    $sql_verificar = "SELECT * FROM preguntas";

    $estado_obj = $DB_CONEXION->prepare($sql_verificar);
    $estado_obj->execute();
    $datos = $estado_obj->fetchAll(PDO::FETCH_ASSOC);

    var_dump(json_encode($datos));

?>