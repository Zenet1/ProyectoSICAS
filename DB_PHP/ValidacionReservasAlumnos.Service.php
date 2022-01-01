<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include "BD_Conexion.php";

    echo json_encode(validarReservaNoExistente($DB_CONEXION));

    function validarReservaNoExistente(PDO $Conexion) : string{

        $Respuesta = "Aceptado";
        $sql_recuperarReservaciones = "SELECT CGAC.IDCarga
        FROM cargaacademica AS CGAC
        INNER JOIN reservacionesalumnos AS RSV
        WHERE CGAC.IDAlumno=? AND RSV.FechaAlumno=?";

        $obj_recuperarReservaciones = $Conexion->prepare($sql_recuperarReservaciones);
        
        $obj_recuperarReservaciones->execute(array($_SESSION["IDAlumno"], date('Y-m-d')));

        $IDReserva = $obj_recuperarReservaciones->fetchAll(PDO::FETCH_ASSOC);
        
        if(sizeof($IDReserva) > 0){
            $Respuesta = "Rechazado";
        }
        
        return $Respuesta;
    }
?>