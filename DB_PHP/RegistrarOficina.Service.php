<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos = json_decode($json);

insertarOficina((array)$datos, $DB_CONEXION);

function insertarOficina(array $oficina, PDO $Conexion): void {

    $sql_recuperarIDEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio = ?";
    $obj_recuperarIDEdificio = $Conexion->prepare($sql_recuperarIDEdificio);
    $obj_recuperarIDEdificio->execute(array($oficina["edificio"]));
    $IDEdificio = $obj_recuperarIDEdificio->fetch(PDO::FETCH_ASSOC);

    if(validarOficinaRegistrada($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"], $Conexion)){

        $sql_insertarOficina = "INSERT INTO oficinas (NombreOficina, Departamento, IDEdificio) SELECT ?, ?, ? FROM DUAL
        WHERE NOT EXISTS (SELECT NombreOficina, Departamento, IDEdificio FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?) LIMIT 1";

        $obj_insertarOficina = $Conexion->prepare($sql_insertarOficina);

        if (isset($IDEdificio["IDEdificio"])) {
            $obj_insertarOficina->execute(array($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"], $oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"]));
        }
    }
}

function validarOficinaRegistrada(string $nombreOficina, string $departamento, string $IDEdificio, PDO $Conexion) : bool{
        
    $sql_validarOficina = "SELECT * FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?";

    $obj_validarOficina = $Conexion->prepare($sql_validarOficina);

    $obj_validarOficina->execute(array($nombreOficina, $departamento, $IDEdificio));
    
    $oficinaDevuelta = $obj_validarOficina->fetchAll(PDO::FETCH_ASSOC);

    if(!validarVariable($oficinaDevuelta)){
        echo "ERROR: Oficina duplicada";
        return false;
    }
    return true;
}

function validarVariable(array $variable) : bool{
    return ($variable === false || sizeof($variable) === 0);
}

?>