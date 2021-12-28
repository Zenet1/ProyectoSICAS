<?php
include "BD_Conexion.php";
date_default_timezone_set("America/Mexico_City");
//$accion = file_get_contents('php://input');
$accion = "respaldar";

switch ($accion) {
    case "respaldar":
        respaldar($DB_CONEXION, "asistencia");
        respaldar($DB_CONEXION, "reservacionesalumnos");
        descargar();
        break;
    case "restaurar":
        restaurar();
        break;
    case "eliminar":
        eliminar($DB_CONEXION, "asistencia");
        eliminar($DB_CONEXION, "reservacionesalumnos");
        break;
    default:
        break;
}

function respaldar(PDO $Conexion, string $tablaRespaldar)
{
    $esColumnaLinea = false;
    $reservacionesArchivo = fopen("backups/" . $tablaRespaldar . ".txt", "w");
    $sql_recuperarDatos = "SELECT * FROM " . $tablaRespaldar;
    $sql_recuperarNombreColumnas = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tablaRespaldar'";

    $obj_recuperarDatos = $Conexion->prepare($sql_recuperarDatos);
    $obj_recuperarColumnas = $Conexion->prepare($sql_recuperarNombreColumnas);

    $obj_recuperarDatos->execute();
    $obj_recuperarColumnas->execute();
    $recuperaciones = $obj_recuperarDatos->fetchAll(PDO::FETCH_ASSOC);
    $NombreColumnas = $obj_recuperarColumnas->fetchAll(PDO::FETCH_ASSOC);

    $indice = 0;
    foreach ($NombreColumnas as $nombreColuma) {
        fwrite($reservacionesArchivo, $nombreColuma["COLUMN_NAME"] . (++$indice < sizeof($NombreColumnas) ? "|" : ""));
    }
    fwrite($reservacionesArchivo, "\n");

    foreach ($recuperaciones as $recuperacion) {
        $indice = 0;
        foreach ($NombreColumnas as $nombreColuma) {
            if ($esColumnaLinea) {
            }
            fwrite($reservacionesArchivo, $recuperacion[$nombreColuma["COLUMN_NAME"]] . (++$indice < sizeof($recuperacion) ? "|" : ""));
        }
        fwrite($reservacionesArchivo, "\n");
        $esColumnaLinea = false;
    }
    fclose($reservacionesArchivo);
}

function restaurar($nombreArchivo)
{
    $direccionArchivo = "backups/";
}

function eliminar(PDO $Conexion, $tablaEliminar)
{

}

function descargar()
{
    $zip = new ZipArchive();
    $NombreZip = "backups/Respaldo-" . date('Y-m-d') . ".zip";

    if ($zip->open($NombreZip, ZIPARCHIVE::CREATE) == true) {
        $zip->addFile("backups/asistencia.txt");
        $zip->addFile("backups/reservacionesalumnos.txt");
    }
    $zip->close();

    $TipoArchivo = filetype($NombreZip);
    $NombreBase = basename($NombreZip);

    header("Content-Type: " . $TipoArchivo);
    header("Content-Length: " . filesize($NombreZip));
    header("Content-Disposition: attachment; filename=" . $NombreBase);
    header("Content-Transfer-Emcoding: binary");
    readfile($NombreZip);
    unlink($NombreZip);
    unlink("backups/asistencia.txt");
    unlink("backups/reservacionesalumnos.txt");
}
