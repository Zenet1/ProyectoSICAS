<?php
include 'BD_Conexion.php';

switch ($_POST["accion"]) {
    case "eliminar":
        eliminar($DB_CONEXION);
        break;
    case "restaurar":
        restaurar($DB_CONEXION);
        break;
}

function eliminar(PDO $Conexion)
{
    
}

function restaurar(PDO $Conexion)
{
    print_r($_FILES["archivo"]["name"]);
}