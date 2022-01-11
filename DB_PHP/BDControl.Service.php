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
    $obj_borrarExternos = $Conexion->prepare("DELETE FROM externos");
    $obj_borrarAsistenciasAlumnos = $Conexion->prepare("DELETE FROM asistenciasalumnos");
    $obj_borrarAsistenciasExternos = $Conexion->prepare("DELETE FROM asistenciasexternos");
    $obj_borrarReservasAlumnos = $Conexion->prepare("DELETE FROM reservacionesalumnos WHERE FechaAlumno < ?");
    $obj_borrarReservasExternos = $Conexion->prepare("DELETE FROM reservacionesexternos WHERE FechaExterno < ?");
    $obj_borrarIncidentes = $Conexion->prepare("DELETE FROM incidentes WHERE FechaAl < ?");

    $obj_borrarExternos->execute();
    $obj_borrarReservasAlumnos->execute(array(date("Y-m-d")));
    $obj_borrarReservasExternos->execute(array(date("Y-m-d")));
    $obj_borrarAsistenciasAlumnos->execute();
    $obj_borrarAsistenciasExternos->execute();
    $obj_borrarIncidentes->execute(array(date("Y-m-d")));

}

function restaurar(PDO $Conexion)
{
    header('Content-Type: text/plain; charset=utf-8');
    move_uploaded_file($_FILES["archivo"]["tmp_name"], "backups/" . $_FILES["archivo"]["name"]);

    foreach (scandir('backups/') as $archivo) {
        if (is_file('backups/' . $archivo)) {
            switch (basename($archivo, ".txt")) {
                case "externos":
                    RestaurarExternos($archivo, $Conexion);
                    break;
                case "reservacionesalumnos":
                    RestaurarReservacionesAlumnos($archivo, $Conexion);
                    break;
                case "reservacionesexternos":
                    RestaurarReservacionesExternos($archivo, $Conexion);
                    break;
                case "asistenciasalumnos":
                    RestaurarAsistenciasAlumnos($archivo, $Conexion);
                    break;
                case "asistenciasexternos":
                    RestaurarAsistenciasExternos($archivo, $Conexion);
                    break;
                case "incidentes":
                    RestaurarIncidentes($archivo, $Conexion);
                    break;
            }
            unlink('backups/' . $archivo);
        }
    }
}

function RestaurarExternos($nombreArchivo, PDO $Conexion){
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO externos (IDExterno, NombreExterno, ApellidosExterno, Empresa, CorreoExterno) SELECT ?,?,?,?,? FROM DUAL
    WHERE NOT EXISTS (SELECT IDExterno FROM externos WHERE IDExterno=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[0]));
    }
}

function RestaurarReservacionesAlumnos($nombreArchivo, PDO $Conexion)
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

function RestaurarReservacionesExternos($nombreArchivo, PDO $Conexion)
{
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO reservacionesexternos (IDExterno, IDOficina, FechaReservaExterno, FechaExterno, HoraExterno) SELECT ?,?,?,?,? FROM DUAL
    WHERE NOT EXISTS (SELECT IDExterno, FechaReservaExterno FROM reservacionesexternos WHERE IDExterno=? AND FechaReservaExterno=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[1], $datos[2]));
    }
}

function RestaurarAsistenciasAlumnos($nombreArchivo, PDO $Conexion)
{
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO asistenciasalumnos (IDAlumno, FechaAl, HoraIngresoAl) SELECT ?,?,? FROM DUAL 
    WHERE NOT EXISTS (SELECT IDAlumno, FechaAl FROM asistenciasalumnos WHERE IDAlumno=? AND FechaAl=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[1], $datos[2], $datos[3], $datos[1], $datos[2]));
    }
}

function RestaurarAsistenciasExternos($nombreArchivo, PDO $Conexion)
{
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO asistenciasexternos (IDExterno, FechaExterno, HoraIngresoEx, HoraSalidaEx, LugarEntradaEx) SELECT ?,?,?,?,? FROM DUAL 
    WHERE NOT EXISTS (SELECT IDExterno, FechaExterno FROM asistenciasexternos WHERE IDExterno=? AND FechaExterno=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[1], $datos[2]));
    }
}

function RestaurarIncidentes($nombreArchivo, PDO $Conexion)
{
    $esPrimeraLinea = true;
    $archivoLeer = file('backups/' . $nombreArchivo);
    $obj_restaurarTabla = $Conexion->prepare("INSERT INTO incidentes (IDAlumno, FechaAl, FechaLimiteSuspension) SELECT ?,?,? FROM DUAL 
    WHERE NOT EXISTS (SELECT IDAlumno, FechaAl, FechaLimiteSuspension FROM incidentes WHERE IDAlumno=? AND FechaAl=? AND FechaLimiteSuspension=?) LIMIT 1");

    foreach ($archivoLeer as $linea) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        $datos = explode("|", $linea);
        $obj_restaurarTabla->execute(array($datos[1], $datos[2], $datos[3], $datos[1], $datos[2], $datos[3]));
    }
}