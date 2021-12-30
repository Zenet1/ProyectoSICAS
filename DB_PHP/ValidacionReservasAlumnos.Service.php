<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    $ReservaAlumno = array();
    $dia_siguiente = date('Y-m-d', strtotime('+1 day'));
    $_SESSION["FechaSig"] = $dia_siguiente;

    obtenerMateriasDisponibles($DB_CONEXION);
    echo json_encode(validarReservaNoExistente($ReservaAlumno, $DB_CONEXION));

    function obtenerMateriasDisponibles(PDO $Conexion) {
        
        $diaABuscar = obtenerDiaSiguienteHabil()[0];
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
        $obj_obtenerMateriasAlumnoPorDia->execute(array($_SESSION["IDAlumno"], $diaABuscar));
        $asignaturas = $obj_obtenerMateriasAlumnoPorDia->fetchAll(PDO::FETCH_ASSOC);

        foreach ($asignaturas as $asignatura) {
            $GLOBALS["ReservaAlumno"][] = $asignatura;
        }
    }
    function validarReservaNoExistente(array $cargas, PDO $Conexion) : string{

        $diaSiguiente = $GLOBALS["dia_siguiente"];
        $sql_recuperarReservaciones = "SELECT IDReservaAlumno FROM reservacionesalumnos WHERE IDCarga = ? AND FechaReservaAl = ?";
        $obj_recuperarReservaciones = $Conexion->prepare($sql_recuperarReservaciones);
        
        foreach($cargas as $carga){

            $obj_recuperarReservaciones->execute(array($carga["IDCarga"], $diaSiguiente));
            $IDReserva = $obj_recuperarReservaciones->fetch(PDO::FETCH_ASSOC);

            if(!isset($IDReserva["IDReservaAlumno"])){
                $Respuesta = "Aceptado";
            }else{
                $Respuesta = "Rechazado";
                break;
            }
        }
        
        return $Respuesta;
    }

    function obtenerDiaSiguienteHabil(): array {

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
                $dia_siguiente_desplasamiento = 1;
                $dia_siguiente_nombre = "Sabado";
                break;
            case "Saturday":
                $dia_siguiente_desplasamiento = 1;
                $dia_siguiente_nombre = "Domingo";
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
?>