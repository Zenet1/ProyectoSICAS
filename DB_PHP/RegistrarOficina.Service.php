<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos = json_decode($json);

insertarOficina((array)$datos, $DB_CONEXION);

function insertarOficina(array $oficina, PDO $Conexion): void
{
    $sql_insertarOficina = "INSERT INTO oficinas (NombreOficina, Departamento, IDEdificio) SELECT ?, ?, ? FROM DUAL
        WHERE NOT EXISTS (SELECT NombreOficina, Departamento, IDEdificio FROM oficinas WHERE NombreOficina = ? AND Departamento = ? AND IDEdificio = ?) LIMIT 1";

    $sql_recuperarIDEdificio = "SELECT IDEdificio FROM edificios WHERE NombreEdificio = ?";

    $obj_recuperarIDEdificio = $Conexion->prepare($sql_recuperarIDEdificio);
    $obj_insertarOficina = $Conexion->prepare($sql_insertarOficina);

    $obj_recuperarIDEdificio->execute(array($oficina["edificio"]));
    $IDEdificio = $obj_recuperarIDEdificio->fetch(PDO::FETCH_ASSOC);

    if (isset($IDEdificio["IDEdificio"])) {
        $obj_insertarOficina->execute(array($oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"], $oficina["oficina"], $oficina["departamento"], $IDEdificio["IDEdificio"]));
    }
}
