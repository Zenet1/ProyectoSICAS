<?php

include 'BD_Conexion.php';

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "recuperar":
        RecuperarSalones($DB_CONEXION);
        break;
    case "actualizar":
        ActualizarSalones($DB_CONEXION, (array) $datos->salon);
        break;
}

function RecuperarSalones(PDO $Conexion)
{
    $obj_recuperar = $Conexion->prepare("SELECT SAL.IDSalon, SAL.NombreSalon, SAL.Capacidad,EDI.NombreEdificio FROM salones AS SAL INNER JOIN edificios AS EDI ON EDI.IDEdificio=SAL.IDEdificio ORDER BY EDI.NombreEdificio");
    $obj_recuperar->execute();
    $salones = $obj_recuperar->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($salones);
}

function ActualizarSalones(PDO $Conexion, array $Salones)
{
    $obj_actualizar = $Conexion->prepare("UPDATE salones SET Capacidad = ? WHERE IDSalon = ?");
    $obj_actualizar->execute(array($Salones["capacidad"], $Salones["aula"]));
}
