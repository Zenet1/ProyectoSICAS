<?php
date_default_timezone_set("America/Mexico_City");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";

$fechaActual = date('Y-m-d');
$horaActual = date("H:i:s");
$respuesta = array();

$QRCodigo =  file_get_contents('php://input');
validarUsuario($QRCodigo, $DB_CONEXION);

function validarUsuario($QRCodigo, PDO $Conexion){
    $elementosCodigoQR = explode(",", $QRCodigo);
    switch($elementosCodigoQR[0]){
        case "a":
            $respuesta = escaneoAlumno($elementosCodigoQR, $Conexion);
            break;
        case "e":
            $respuesta = escaneoExterno($elementosCodigoQR, $Conexion);
            break;
        default:
            echo "Error: Tipo de usuario no detectado";
            break;
    }
    echo json_encode($respuesta);
}
function escaneoAlumno(array $elementosAlumno, PDO $Conexion){
    
    $IDAlumno = $elementosAlumno[1];
    $esPrimeraLinea = true;
    $esSegundaLinea = true;
    $esValido = true;

    $respuesta = array();
    $respuesta["respuesta"] = "valido";
    
    $sql_verificarReservaAlumno = "SELECT ALM.NombreAlumno,ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno FROM reservacionesalumnos AS RSAL
        INNER JOIN cargaacademica AS CGAC
        ON CGAC.IDCarga=RSAL.IDCarga
        INNER JOIN alumnos AS ALM
        ON CGAC.IDAlumno=ALM.IDAlumno
        WHERE CGAC.IDAlumno=? AND RSAL.IDReservaAlumno=? AND RSAL.FechaReservaAl=?";

    $obj_verificarReservaAlumno = $Conexion->prepare($sql_verificarReservaAlumno);

    foreach ($elementosAlumno as $IDReserva) {
        if ($esPrimeraLinea) {
            $esPrimeraLinea = false;
            continue;
        }
        if($esSegundaLinea){
            $esSegundaLinea = false;
            continue;
        }

        $obj_verificarReservaAlumno->execute(array($IDAlumno, $IDReserva, $GLOBALS["fechaActual"]));
        $datos_reserva = $obj_verificarReservaAlumno->fetch(PDO::FETCH_ASSOC);

        if (isset($datos_reserva["NombreAlumno"]) && !isset($respuesta["NombreCompleto"])) {
            $respuesta["NombreCompleto"] = $datos_reserva["NombreAlumno"] . " " . $datos_reserva["ApellidoPaternoAlumno"] . " " . $datos_reserva["ApellidoMaternoAlumno"];
        }

        if ($datos_reserva === false || sizeof($datos_reserva)  < 1) {
            $respuesta["respuesta"] = "invalido";
            $esValido = false;
        }
    }

    if ($esValido) {
        $obj_asistencia = $Conexion->prepare("INSERT INTO asistenciasalumnos (`IDAlumno`, `FechaAl`, `HoraIngresoAl`) SELECT ?,?,? FROM DUAL WHERE NOT EXISTS (SELECT IDAlumno,FechaAl FROM asistenciasalumnos WHERE IDAlumno = ? AND FechaAl = ?)");
        $obj_asistencia->execute(array($elementosAlumno[1], $GLOBALS["fechaActual"], $GLOBALS["horaActual"], $elementosAlumno[1], $GLOBALS["fechaActual"]));
    }

    return $respuesta;
}

function escaneoExterno(array $elementosExterno, PDO $Conexion){
    
}

