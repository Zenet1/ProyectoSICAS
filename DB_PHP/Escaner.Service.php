<?php
date_default_timezone_set("America/Mexico_City");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";

$respuesta = array();
$respuesta["respuesta"] = "valido";
$FechaActual = date('Y-m-d');
$HoraActual = date("H:i:s");

$esValido = true;
$QRcodigo =  file_get_contents('php://input');

$sql_verificarReserva = "SELECT ALM.NombreAlumno,ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno FROM reservacionesalumnos AS RSAL
    INNER JOIN cargaacademica AS CGAC
    ON CGAC.IDCarga=RSAL.IDCarga
    INNER JOIN alumnos AS ALM
    ON CGAC.IDAlumno=ALM.IDAlumno
    WHERE CGAC.IDAlumno=? AND RSAL.IDReservaAlumno=? AND RSAL.FechaReservaAl=?";

$ArrayClaves = explode(",", $QRcodigo);
$AlumnoID = $ArrayClaves[0];
$esPrimeraLina = true;

$obj_reserva = $DB_CONEXION->prepare($sql_verificarReserva);

foreach ($ArrayClaves as $IDReserva) {
    if ($esPrimeraLina) {
        $esPrimeraLina = false;
        continue;
    }

    $obj_reserva->execute(array($AlumnoID, $IDReserva, $FechaActual));
    $datos_reserva = $obj_reserva->fetch(PDO::FETCH_ASSOC);

    if (isset($datos_reserva["NombreAlumno"]) && !isset($respuesta["NombreCompleto"])) {
        $respuesta["NombreCompleto"] = $datos_reserva["NombreAlumno"] . " " . $datos_reserva["ApellidoPaternoAlumno"] . " " . $datos_reserva["ApellidoMaternoAlumno"];
    }

    if ($datos_reserva === false || sizeof($datos_reserva)  < 1) {
        $respuesta["respuesta"] = "invalido";
        $esValido = false;
    }
}

if ($esValido) {
    $obj_asistencia = $DB_CONEXION->prepare("INSERT INTO `sicasbd`.`asistenciasalumnos` (`IDAlumno`, `Fecha`, `HoraIngreso`) VALUES (?,?,?)");
    $obj_asistencia->execute(array($ArrayClaves[0], $FechaActual, $HoraActual));
}

echo json_encode($respuesta);
