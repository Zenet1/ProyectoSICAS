<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $json = file_get_contents('php://input');
    $datos = json_decode($json);

    eliminarOficina($datos, $DB_CONEXION);

    function eliminarOficina(string $id, PDO $Conexion) : void{
        
        $sql_eliminarOficina = "DELETE FROM oficinas WHERE IDOficina = ?";

        $obj_eliminarOficina = $Conexion->prepare($sql_eliminarOficina);
        
        $obj_eliminarOficina->execute(array($id));
    }
?>