<?php
include 'BD_Conexion.php';


respaldar($DB_CONEXION, "asistencia", "SELECT * FROM asistencia");
respaldar($DB_CONEXION, "reservacionesalumnos", "SELECT * FROM reservacionesalumnos WHERE FechaAlumno < ?", array(date('Y-m-d')));
respaldar($DB_CONEXION, "reservacionesexternos", "SELECT * FROM reservacionesexternos");
comprimir();
descargar("zipRespaldo");

function respaldar(PDO $Conexion, string $tabla, string $Query, array $variables = null)
{
    $archivo = fopen("backups/" . $tabla . ".txt", "w");
    $obj_nombreColumnas = $Conexion->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tabla'");
    $obj_datosTabla = $Conexion->prepare($Query);
    $obj_nombreColumnas->execute();
    if ($variables !== null) {
        $obj_datosTabla->execute($variables);
    }
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

function comprimir()
{
    $zip = new ZipArchive();
    $nombreZip = "backups/zipRespaldo.zip";

    if ($zip->open($nombreZip, ZipArchive::CREATE) === true) {
        $zip->addFile("backups/asistencia.txt");
        $zip->addFile("backups/reservacionesalumnos.txt");
        $zip->addFile("backups/reservacionesexternos.txt");
    }
    $zip->close();
}

function descargar(string $nombreArchivo)
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/text');
    header('Content-Disposition: attachment; filename="' . basename($nombreArchivo . ".zip") . '"');
    header('Content-Length: ' . filesize("backups/" . $nombreArchivo . ".zip"));
    readfile("backups/" . $nombreArchivo . ".zip");

    foreach (scandir('backups/') as $archivo) {
        if (is_file("backups/" . $archivo)) {
            unlink("backups/" . $archivo);
        }
    }
}
