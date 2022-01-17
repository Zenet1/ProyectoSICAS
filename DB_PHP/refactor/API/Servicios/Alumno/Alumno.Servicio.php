<?php
class Alumno{

    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
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

    public function obtenerMateriasDisponibles(){
        
    }

    public function insertarReservasAlumno(){
        //
    }

    private function ValidarCupo(){
        
    }
    
}
