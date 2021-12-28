<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";
    $ReservaAlumno = array();
    $dia_siguiente = date('Y-m-d', strtotime('+1 day'));
    ObtenerMateriasDisponibles($DB_CONEXION);
    validarReservasExistentes($DB_CONEXION);
    
    function ObtenerMateriasDisponibles(PDO $Conexion) : void
    {
        $diaSiguiente = $GLOBALS["dia_siguiente"];
        $sql_obtenerMateriasAlumnoPorDia = "SELECT CGAC.IDCarga
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
    
        $obj_obtenerMateriasAlumnoPorDia->execute(array($_SESSION["IDAlumno"], $diaSiguiente));
    
        $asignaturas = $obj_obtenerMateriasAlumnoPorDia->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($asignaturas as $asignatura) {
            $GLOBALS["ReservaAlumno"][] = $asignatura;
        }
    }

    function validarReservaNoExistente(PDO $Conexion) : void
    {
        $diaSiguiente = $GLOBALS["dia_siguiente"];
        $sql_recuperarReservaciones = "SELECT IDReservaAlumno FROM reservacionesalumnos WHERE IDCarga = ? AND FechaReservaAl = ?";
        $obj_recuperarReservaciones = $Conexion->prepare($sql_recuperarReservaciones);
        $obj_recuperarReservacionesIguales->execute(array($GLOBALS["ReservaAlumno"]["IDCarga"], $diaSiguiente));
        $IDReserva = $obj_recuperarReservaciones->fetch(PDO::FETCH_ASSOC);

        if(!isset($IDReserva["IDReservaAlumno"])){
            $Respuesta = "Aceptado";
        }else{
            $Respuesta = "Rechazado";
        }
        echo $Respuesta;
    }
?>