<?php
include 'BD_Conexion.php';
date_default_timezone_set("America/Mexico_City");

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
    $obj_borrarAsistencia = $Conexion->prepare("DELETE FROM asistencia");
    $obj_borrarReservas = $Conexion->prepare("DELETE FROM reservacionesalumnos WHERE FechaAlumno < ?");
    $obj_borrarReservas->execute(array(date("Y-m-d")));
    $obj_borrarAsistencia->execute();
}

function restaurar(PDO $Conexion)
{
    header('Content-Type: text/plain; charset=utf-8');
    move_uploaded_file($_FILES["archivo"]["tmp_name"], "backups/" . $_FILES["archivo"]["name"]);

    foreach (scandir('backups/') as $archivo) {
        if (is_file('backups/' . $archivo)) {
            switch (basename($archivo, ".txt")) {
                case "reservacionesalumnos":
                    RestaurarReservaciones($archivo, $Conexion);
                    break;
                case "asistencia":
                    RestaurarAsistencia($archivo, $Conexion);
                    break;
            }
            unlink('backups/' . $archivo);
        }
    }
}

function RestaurarReservaciones($nombreArchivo, PDO $Conexion)
{
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO reservacionesalumnos (IDCarga, FechaReservaAl,HoraInicioReservaAl, HoraFinReservaAl, FechaAlumno, HoraAlumno) SELECT ?,?,?,?,?,? FROM DUAL
    WHERE NOT EXISTS (SELECT IDCarga, FechaReservaAl FROM reservacionesalumnos WHERE IDCarga=? AND FechaReservaAl=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[1], $datos[2]));
    }
}

function RestaurarAsistencia($nombreArchivo, PDO $Conexion)
{
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO asistencia (IDAlumno, Fecha, HoraIngreso) SELECT ?,?,? FROM DUAL WHERE NOT EXISTS (SELECT IDAlumno, Fecha FROM asistencia WHERE IDAlumno=? AND Fecha=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[1], $datos[2], $datos[3], $datos[1], $datos[2]));
    }
}
