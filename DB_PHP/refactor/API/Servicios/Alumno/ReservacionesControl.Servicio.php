<?php
include_once("Reservaciones.Query.php");

class ReservaControl
{
    private Query $objQuery;
    private Fechas $objFecha;
    private ReservaQuery $objResQuery;
    public function __construct(Query $objQuery, Fechas $objFecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $objFecha;
        $this->objResQuery = new ReservaQuery();
    }

    public function validarReservaNoExistente()
    {
        $Respuesta = "Aceptado";
        
        $sql_recuperarReservaciones = "SELECT RSV.IDCarga FROM reservacionesalumnos AS RSV 
        INNER JOIN cargaacademica AS CGAC ON RSV.IDCarga=CGAC.IDCarga 
        WHERE CGAC.IDAlumno=? AND RSV.FechaAlumno=?";

        $obj_recuperarReservaciones = $this->conexion->getConexion()->prepare($sql_recuperarReservaciones);
        
        $obj_recuperarReservaciones->execute(array($_SESSION["IDAlumno"], date('Y-m-d')));

        $IDReserva = $obj_recuperarReservaciones->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($IDReserva) > 0) {
            $Respuesta = "Rechazado";
        }
        echo json_encode($Respuesta);
    }

    public function obtenerMateriasDisponibles()
    {
    }

    public function insertarReservasAlumno()
    {
        //
    }

    private function ValidarCupo()
    {
        $FechateDiaSiguiente = $_SESSION["FechaSig"];
/*
        $obj_reservacionesMateriasAlumnosDiaSiguiente = $Conexion->prepare($sql_obtenerCantidadReservacionesPorGrupo);
        $obj_PorcentajeCapacidadFacultad = $Conexion->prepare($sql_obtenerCapacidadFacultad);

        $this->objQuery->ejecutarConsulta($this->objResQuery->CuposDisconibles(), array());
        $obj_PorcentajeCapacidadFacultad->execute();
        $obj_reservacionesMateriasAlumnosDiaSiguiente->execute(array($asignatura["IDGrupo"], $FechateDiaSiguiente));

        $cantidadDeReservaciones = $obj_reservacionesMateriasAlumnosDiaSiguiente->fetch(PDO::FETCH_ASSOC);
        $porcentajeDeCapacidad = $obj_PorcentajeCapacidadFacultad->fetch(PDO::FETCH_ASSOC);

        $capasidadSalon = intval($asignatura["Capacidad"] * ($porcentajeDeCapacidad["Porcentaje"] / 100));

        if (intval($cantidadDeReservaciones["CR"]) < $capasidadSalon) {
            return true;
        }
        return false;
        */
    }
}
