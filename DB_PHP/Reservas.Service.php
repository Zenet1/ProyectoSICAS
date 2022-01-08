<?php
session_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";
include "Qr.Class.php";
include 'Fechas.Class.php';

$json = file_get_contents('php://input');
$datos = json_decode($json);
$QR = new GeneradorQr();
$QR->setNombrePng($_SESSION["IDAlumno"]);

switch ($datos->accion) {
    case "obtenerMaterias":
        ObtenerMateriasDisponibles($DB_CONEXION, Fechas::ObtenerInstanciaFecha());
        break;
    case "asignarReservaAlumno":
        InsertarNuevaReservacionAlumno($datos->carga, $DB_CONEXION);
        $NombreQRAlumno = "a" . $_SESSION["IDAlumno"];
        $ContenidoQRAlumno = "a," . $ContenidoQR;
        $QR = new GeneradorQr();
        $QR->setNombrePng($NombreQRAlumno);
        $QR->Generar($ContenidoQRAlumno);
        break;
    default:
        break;
}

function ObtenerMateriasDisponibles(PDO $Conexion, Fechas $fecha)
{
    $datosReservaAlumno = array();
    $sql_obtenerMateriasAlumnoPorDia = "SELECT CGAC.IDCarga, CGAC.IDGrupo,GPS.IDAsignatura,ASIG.NombreAsignatura, HRS.Dia, HRS.HoraInicioHorario, HRS.HoraFinHorario, SLS.Capacidad,SLS.NombreSalon FROM cargaacademica AS CGAC INNER JOIN grupos AS GPS ON GPS.IDGrupo=CGAC.IDGrupo INNER JOIN asignaturas As ASIG ON ASIG.IDAsignatura=GPS.IDAsignatura INNER JOIN horarios AS HRS ON HRS.IDGrupo=CGAC.IDGrupo INNER JOIN salones AS SLS ON SLS.IDSalon=HRS.IDSalon WHERE CGAC.IDAlumno=? AND HRS.Dia=?";

    $obj_obtenerMateriasAlumnoPorDia = $Conexion->prepare($sql_obtenerMateriasAlumnoPorDia);
    $obj_obtenerMateriasAlumnoPorDia->execute(array($_SESSION["IDAlumno"],  $fecha->DiaSig()));
    $asignaturasHorario = $obj_obtenerMateriasAlumnoPorDia->fetchAll(PDO::FETCH_ASSOC);

    foreach ($asignaturasHorario as $asignatura) {
        if (ValidadorGrupoDisponible($asignatura, $Conexion, $fecha)) {
            $datosReservaAlumno[] = $asignatura;
        }
    }
    echo json_encode($datosReservaAlumno);
}

function InsertarNuevaReservacionAlumno(array $asignaturas, PDO $Conexion, Fechas $fecha, GeneradorQr $qr): void
{
    $sql_insertar = "INSERT INTO reservacionesalumnos (IDCarga, FechaReservaAl, HoraInicioReservaAl, HoraFinReservaAl, FechaAlumno, HoraAlumno) SELECT :id,:fcal,?,?,?,? FROM DUAL WHERE NOT EXISTS (SELECT IDCarga, FechaReservaAl FROM reservacionesalumnos WHERE IDCarga = :id AND FechaReservaAl = :fcal) LIMIT 1";

    $sql_recuperarIDCarga = "SELECT IDReservaAlumno FROM reservacionesalumnos WHERE IDCarga=? AND FechaReservaAl=?";

    $obj_insertar = $Conexion->prepare($sql_insertar);
    $obj_recuperarID = $Conexion->prepare($sql_recuperarIDCarga);

    $QRContenido = $_SESSION["IDAlumno"];

    foreach ($asignaturas as $asignatura) {
        $asignaturaArray = (array)$asignatura;
        if (ValidadorGrupoDisponible($asignaturaArray, $Conexion, $fecha)) {
            $incognitas = array("id" => $asignaturaArray["IDCarga"], "fcal" => $fecha->FechaSig(), $asignaturaArray["HoraInicioHorario"], $asignaturaArray["HoraFinHorario"], $fecha->FechaAct(), $fecha->HrAct());
            $obj_insertar->execute($incognitas);

            $obj_recuperarID->execute(array($asignaturaArray["IDCarga"], $fecha->FechaSig()));
            $IDReserva = $obj_recuperarID->fetch(PDO::FETCH_ASSOC);

            $QRContenido .= "," . $IDReserva["IDReservaAlumno"];
        }
    }
    $qr->Generar($QRContenido);
}

function ValidadorGrupoDisponible(array $asignatura, PDO $Conexion, Fechas $fecha): bool
{
    $FechaSig = $fecha->FechaSig();
    $sql_obtenerCantidadReservacionesPorGrupo = "SELECT COUNT(RSAL.IDReservaAlumno) AS CR FROM cargaacademica AS CGAC 
    INNER JOIN reservacionesalumnos AS RSAL 
    ON RSAL.IDCarga=CGAC.IDCarga 
    WHERE CGAC.IDGrupo=? AND RSAL.FechaReservaAl=? ";

    $sql_obtenerCapacidadFacultad = "SELECT Porcentaje FROM sicasbd.porcentajecapacidad WHERE IDPorcentaje=1";

    $obj_reservacionesMateriasAlumnosDiaSiguiente = $Conexion->prepare($sql_obtenerCantidadReservacionesPorGrupo);
    $obj_PorcentajeCapacidadFacultad = $Conexion->prepare($sql_obtenerCapacidadFacultad);

    $obj_PorcentajeCapacidadFacultad->execute();
    $obj_reservacionesMateriasAlumnosDiaSiguiente->execute(array($asignatura["IDGrupo"], $FechaSig));

    $cantidadDeReservaciones = $obj_reservacionesMateriasAlumnosDiaSiguiente->fetch(PDO::FETCH_ASSOC);
    $porcCapacidad = $obj_PorcentajeCapacidadFacultad->fetch(PDO::FETCH_ASSOC);

    $capasidadSalon = intval($asignatura["Capacidad"] * ($porcCapacidad["Porcentaje"] / 100));

    if ($cantidadDeReservaciones["CR"] < $capasidadSalon) {
        return true;
    }
    return false;
}