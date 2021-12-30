<?php
include 'BD_Conexion.php';
$tablas_respaldar = ["reservacionesalumnos", "asistencia"];


switch ($_POST["accion"]) {
    case "eliminar":
        break;
    case "restaurar":
        break;
}

function eliminar(PDO $Conexion)
{
}

function restaurar(PDO $Conexion)
{
}