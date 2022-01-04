<?php
include 'BD_Conexion.php';

$json = file_get_contents('php://input');
$datos = json_decode($json);

switch ($datos->accion) {
    case "recuperar":
        RecuperarPorcentaje($DB_CONEXION);
        break;
    case "actualizar":
        ActualizarPorcentaje($DB_CONEXION, $datos->porcentaje);
        break;
}


function RecuperarPorcentaje(PDO $Conexion)
{
    $obj_recuperar = $Conexion->prepare("SELECT Porcentaje FROM porcentajecapacidad");
    $obj_recuperar->execute();
    $porcentaje = $obj_recuperar->fetch(PDO::FETCH_ASSOC);
    echo $porcentaje["Porcentaje"];
}

function ActualizarPorcentaje(PDO $Conexion, $Porcentaje)
{
    $obj_actualizar = $Conexion->prepare("UPDATE porcentajecapacidad SET Porcentaje = ? WHERE IDPorcentaje = 1");
    $obj_actualizar->execute(array($Porcentaje));
}
