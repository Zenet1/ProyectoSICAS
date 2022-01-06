<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";
include 'Fechas.Class.php';

$respuesta = array("respuesta" => "valido");
$fechas = Fechas::ObtenerInstanciaFecha();
$CadenaQR =  file_get_contents('php://input');

$sql_verificarReserva = "SELECT ALM.NombreAlumno,ALM.ApellidoPaternoAlumno,ALM.ApellidoMaternoAlumno FROM reservacionesalumnos AS RSAL
    INNER JOIN cargaacademica AS CGAC
    ON CGAC.IDCarga=RSAL.IDCarga
    INNER JOIN alumnos AS ALM
    ON CGAC.IDAlumno=ALM.IDAlumno
    WHERE CGAC.IDAlumno=? AND RSAL.IDReservaAlumno=? AND RSAL.FechaReservaAl=?";
$objVerificaReserva = $DB_CONEXION->prepare($sql_verificarReserva);

$indentificadoresReserva = explode(",", $CadenaQR);
$idAlumno = $indentificadoresReserva[0];
unset($indentificadoresReserva[0]);

foreach ($indentificadoresReserva as $IDReserva) {
    $objVerificaReserva->execute(array($idAlumno, $IDReserva, $fechas->FechaAct()));
    $datosRes = $objVerificaReserva->fetch(PDO::FETCH_ASSOC);

    if ($datosRes === false || sizeof($datosRes) === 0) {
        $respuesta["respuesta"] = "invalido";
        break;
    }

    if (!isset($respuesta["NombreCompleto"])) {
        $respuesta["NombreCompleto"] = $datosRes["NombreAlumno"] . " " . $datosRes["ApellidoPaternoAlumno"] . " " . $datosRes["ApellidoMaternoAlumno"];
    }
}

if ($respuesta["respuesta"] === "valido") {
    $obj_asistencia = $DB_CONEXION->prepare("INSERT INTO asistenciasalumnos (IDAlumno,FechaAl,HoraIngresoAl) SELECT :idAL,:fcAct,:hrAct FROM DUAL WHERE NOT EXISTS (SELECT IDAlumno,FechaAl FROM asistenciasalumnos WHERE IDAlumno=:idAL AND FechaAl=:fcAct) LIMIT 1");
    $incognitas = array("idAL" => $idAlumno, "fcAct" => $fechas->FechaAct(), "hrAct" => $fechas->HrAct());
    $obj_asistencia->execute($incognitas);
}

echo json_encode($respuesta);