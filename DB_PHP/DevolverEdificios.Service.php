<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $datosEdificios = array();
    obtenerEdificios($DB_CONEXION);
    echo json_encode($datosEdificios);
    
    function obtenerEdificios(PDO $Conexion){
        $sql_obtenerEdificios = "SELECT NombreEdificio FROM edificios";
        $obj_obtenerEdificios = $Conexion->prepare($sql_obtenerEdificios);
        $obj_obtenerEdificios->execute();
        $edificios = $obj_obtenerEdificios->fetchAll(PDO::FETCH_ASSOC);
        foreach ($edificios as $edificio) {
            $GLOBALS["datosEdificios"][] = $edificio;
        }
    }
?>