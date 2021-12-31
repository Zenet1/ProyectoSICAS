<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    $datosOficinas = array();
    obtenerOficinas($DB_CONEXION);
    echo json_encode($datosOficinas);
    
    function obtenerOficinas(PDO $Conexion){
        $sql_obtenerOficinas = "SELECT OFC.NombreOficina, OFC.Departamento, EDF.NombreEdificio, OFC.IDOficina
        FROM oficinas AS OFC
        INNER JOIN edificios AS EDF
        ON EDF.IDEdificio=OFC.IDEdificio";

        $obj_obtenerOficinas = $Conexion->prepare($sql_obtenerOficinas);
        $obj_obtenerOficinas->execute();
        $oficinas = $obj_obtenerOficinas->fetchAll(PDO::FETCH_ASSOC);

        foreach ($oficinas as $oficina) {
            $GLOBALS["datosOficinas"][] = $oficina;
        }
    }
?>