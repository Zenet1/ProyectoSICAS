<?php
session_start();
date_default_timezone_set("America/Mexico_City");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include "BD_Conexion.php";

$json = file_get_contents('php://input');
$datos = json_decode($json);

$Global_datosReservaAlumno = array();
$accion = "";

switch ($accion) {
    case "ObtenerMaterias":
        ObtenerMateriasDisponibles($DB_CONEXION);
        echo $Global_datosReservaAlumno;
        break;
    default:
        break;
}

function ObtenerMateriasDisponibles(PDO $Conexion)
{
    $FechateDiaSiguiente = date('Y-m-d', strtotime('+' . obtenerDiaSiguienteHabil()[1] . ' day'));
    $sql_obtenerMateriasAlumnoPorDia = "SELECT CGAC.IDCarga, CGAC.IDGrupo,GPS.IDAsignatura,ASIG.NombreAsignatura, HRS.Dia, HRS.HoraInicioHorario, HRS.HoraFinHorario, SLS.Capacidad
    FROM cargaacademica AS CGAC
    INNER JOIN grupos AS GPS
    ON GPS.IDGrupo=CGAC.IDGrupo
    INNER JOIN asignaturas As ASIG
    ON ASIG.IDAsignatura=GPS.IDAsignatura
    INNER JOIN horarios AS HRS
    ON HRS.IDGrupo=CGAC.IDGrupo
    INNER JOIN salones AS SLS
    ON SLS.IDSalon=HRS.IDSalon
    WHERE CGAC.IDAlumno=? AND HRS.Dia=?";

    $obj_obtenerMateriasAlumnoPorDia = $Conexion->prepare($sql_obtenerMateriasAlumnoPorDia);

    $diaABuscar = obtenerDiaSiguienteHabil()[0];
    $obj_obtenerMateriasAlumnoPorDia->execute(array(1, $diaABuscar));

    $asignaturasHorario = $obj_obtenerMateriasAlumnoPorDia->fetchAll(PDO::FETCH_ASSOC);

    foreach ($asignaturasHorario as $Asignatura) {
        if (ValidadorGrupoDisponible($Asignatura, $Conexion)) {
            $GLOBALS["Global_datosReservaAlumno"][] = $Asignatura;
        }
    }
}

function InsertarNuevaReservacionAlumno(PDO $Conexion): void
{
    $FechaActual = date('Y-m-d');
    $horaAlumno = date("H:i:s");

    $sql_insertar = "INSERT INTO `sicasbd`.`reservacionesalumnos` (`IDCarga`, `FechaReservaAl`, `HoraInicioReservaAl`, `HoraFinReservaAl`, `FechaAlumno`, `HoraAlumno`) VALUES (?,?,?,?,?,?)";

    $obj_insertar = $Conexion->prepare($sql_insertar);
    $obj_insertar->execute(array());
}

function obtenerDiaSiguienteHabil(): array
{
    $datos_fecha = array();
    $dia_siguiente_nombre = "";
    $dia_siguiente_desplasamiento = 0;

    switch (date("l")) {
        case "Monday":
            $dia_siguiente_desplasamiento = 1;
            $dia_siguiente_nombre = "Martes";
            break;
        case "Tuesday":
            $dia_siguiente_desplasamiento = 1;
            $dia_siguiente_nombre = "Miercoles";
            break;
        case "Wednesday":
            $dia_siguiente_desplasamiento = 1;
            $dia_siguiente_nombre = "Jueves";
            break;
        case "Thursday":
            $dia_siguiente_desplasamiento = 1;
            $dia_siguiente_nombre = "Viernes";
            break;
        case "Friday":
            $dia_siguiente_desplasamiento = 3;
            $dia_siguiente_nombre = "Lunes";
            break;
        case "Saturday":
            $dia_siguiente_desplasamiento = 2;
            $dia_siguiente_nombre = "Lunes";
            break;
        case "Sunday":
            $dia_siguiente_desplasamiento = 1;
            $dia_siguiente_nombre = "Lunes";
            break;
    }
    $datos_fecha[0] = $dia_siguiente_nombre;
    $datos_fecha[1] =  $dia_siguiente_desplasamiento;
    return $datos_fecha;
}

function ValidadorGrupoDisponible(array $asignatura, PDO $Conexion): bool
{
    $FechateDiaSiguiente = date('Y-m-d', strtotime('+' . obtenerDiaSiguienteHabil()[1] . ' day'));
    $sql_obtenerCantidadReservacionesPorGrupo = "SELECT COUNT(RSAL.IDReservaAlumno) AS CR FROM cargaacademica AS CGAC 
    INNER JOIN reservacionesalumnos AS RSAL 
    ON RSAL.IDCarga=CGAC.IDCarga 
    WHERE CGAC.IDGrupo=? AND RSAL.FechaReservaAl=? ";

    $sql_obtenerCapacidadFacultad = "SELECT Porcentaje FROM sicasbd.porcentajecapacidad WHERE IDPorcentaje=1";

    $obj_reservacionesMateriasAlumnosDiaSiguiente = $Conexion->prepare($sql_obtenerCantidadReservacionesPorGrupo);
    $obj_PorcentajeCapacidadFacultad = $Conexion->prepare($sql_obtenerCapacidadFacultad);

    $obj_PorcentajeCapacidadFacultad->execute();
    $obj_reservacionesMateriasAlumnosDiaSiguiente->execute(array($asignatura["IDGrupo"], $FechateDiaSiguiente));

    $cantidadDeReservaciones = $obj_reservacionesMateriasAlumnosDiaSiguiente->fetch(PDO::FETCH_ASSOC);
    $porcentajeDeCapacidad = $obj_PorcentajeCapacidadFacultad->fetch(PDO::FETCH_ASSOC);

    $capasidadSalon = intval($asignatura["Capacidad"] * ($porcentajeDeCapacidad["Porcentaje"] / 100));

    if (intval($cantidadDeReservaciones["CR"]) < $capasidadSalon) {
        return true;
    }
    return false;
}
