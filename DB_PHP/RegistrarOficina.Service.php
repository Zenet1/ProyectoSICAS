<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    $json = file_get_contents('php://input');
    $datos = json_decode($json);

    insertarOficina((array)$datos, $DB_CONEXION);

    function insertarOficina(array $oficina, PDO $Conexion) : void{
        print_r($oficina);
        echo "<br><br>";
        $sql_insertarOficina = "INSERT INTO oficinas (NombreOficina, Departamento, IDEdificio) VALUES (?, ?, ?)";
        $sql_recuperarIDEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio = ?";

        $obj_recuperarIDEdificio = $Conexion->prepare($sql_recuperarIDEdificio);
        $obj_insertarOficina = $Conexion->prepare($sql_insertarOficina);

        $obj_recuperarIDEdificio->execute(array($oficina["edificio"]));
        $IDEdificio = $obj_recuperarIDEdificio->fetchAll(PDO::FETCH_ASSOC);
        if(isset($IDEdificio[0]["IDEdificio"])){
            echo "Se ha registrado la oficina satisfactoriamente";
            $obj_insertarOficina->execute(array($oficina["oficina"], $oficina["departamento"], $IDEdificio[0]["IDEdificio"]));
        }
    }
?>