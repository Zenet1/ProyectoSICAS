<?php
include 'BD_Conexion.php';
$tablas_respaldar = ["reservacionesalumnos", "asistencia"];

descargar("asistencia");
switch ($_POST["accion"]) {
    case "respaldar":
        foreach ($tablas_respaldar as $tabla) {
            respaldar($DB_CONEXION, $tabla);
        }
        break;
    case "eliminar":
        break;
    case "restaurar":
        break;
}

function respaldar(PDO $Conexion, string $tabla)
{
    $archivo = fopen("backups/" . $tabla . ".txt", "w");
    $obj_nombreColumnas = $Conexion->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tabla'");
    $obj_datosTabla = $Conexion->prepare("SELECT * FROM $tabla");
    $obj_nombreColumnas->execute();
    $obj_datosTabla->execute();

    $array_columnas = $obj_nombreColumnas->fetchAll(PDO::FETCH_ASSOC);
    $array_datos = $obj_datosTabla->fetchAll(PDO::FETCH_ASSOC);

    $indice_final = 0;

    foreach ($array_columnas as $columna) {
        fwrite($archivo, $columna["COLUMN_NAME"] . (++$indice_final < sizeof($array_columnas) ? "|" : ""));
    }
    fwrite($archivo, "\n");
    foreach ($array_datos as $dato) {
        $indice_final = 0;
        foreach ($array_columnas as $columna) {
            fwrite($archivo, $dato[$columna["COLUMN_NAME"]] . (++$indice_final < sizeof($dato) ? "|" : ""));
        }
        fwrite($archivo, "\n");
    }
    fclose($archivo);
}

function eliminar(PDO $Conexion)
{
}

function restaurar(PDO $Conexion)
{
}

function descargar(string $nombreArchivo)
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($nombreArchivo . ".txt").'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize("backups/". $nombreArchivo .".txt"));
    flush();
    readfile("backups/". $nombreArchivo .".txt");
    exit;
}
