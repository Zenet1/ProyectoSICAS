<?php
class ReservacionExterno{

    private Query $objQuery;
    private Fechas $fecha;

    public function __construct(Query $objQuery, Fechas $fecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $fecha;
    }

    public function registroExterno($datos)
    {
        session_start();
        $_SESSION['Nombre'] = "$datos->nombre";
        $_SESSION['apellidosExterno'] = "$datos->apellidos";
        $_SESSION['empresa'] = "$datos->empresa";
        $_SESSION['Correo'] = "$datos->correo";
    }

    public function insertarReservaExterno($oficinas, $fechaAsistencia)
    {
        session_start();
        $externoRegistrado = $this->insertarExterno();
        if($externoRegistrado){
            $IDExterno = $this->recuperarIDExterno();
            $this->insertarReservacion($oficinas, $IDExterno["IDExterno"], $fechaAsistencia);
        }else{
            echo "No se tiene una sesión iniciada";
        }
    }

    private function insertarExterno() : bool
    {
        $operacionRealizada = true;

        $sql_insertarExterno = "INSERT INTO externos (NombreExterno, ApellidosExterno, Empresa, CorreoExterno) SELECT ?,?,?,? FROM DUAL
        WHERE NOT EXISTS (SELECT IDExterno FROM externos WHERE NombreExterno = ? AND ApellidosExterno = ? AND Empresa = ? AND CorreoExterno = ?) LIMIT 1";

        if($this->sesionActivaExterno()){
            $this->objQuery->ejecutarConsulta($sql_insertarExterno, array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo'], $_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));
        }else{
            $operacionRealizada = false;
        }
        return $operacionRealizada;
    }

    private function sesionActivaExterno() : bool
    {
        return (isset($_SESSION['Nombre']) && isset($_SESSION['apellidosExterno']) && isset($_SESSION['empresa']) && isset($_SESSION['Correo']));
    }

    private function recuperarIDExterno() : array
    {
        $sql_recuperarIDExterno = "SELECT IDExterno FROM externos WHERE NombreExterno = ? AND ApellidosExterno = ? AND Empresa = ? AND CorreoExterno = ?";

        $IDExternoRecuperado = $this->objQuery->ejecutarConsulta($sql_recuperarIDExterno, array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));

        return $IDExternoRecuperado[0];
    }

    private function insertarReservacion(array $oficinas, string $IDExterno, string $fechaAsistencia)
    {
       
        $fechaActual =  $this->objFecha->FechaAct("Y-m-d");
        $horaActual =  $this->objFecha->HrAct("H:i:s");
        
        $sql_insertarReservacion = "INSERT INTO reservacionesexternos 
        (IDExterno, IDOficina, FechaReservaExterno, FechaExterno, HoraExterno) 
        VALUES (?, ?, ?, ?, ?)";

        $QRContenido = $IDExterno;

        foreach($oficinas as $oficina){
            $oficinaArray = (array)$oficina;

            $this->objQuery->ejecutarConsulta($sql_insertarReservacion, array($IDExterno, $oficinaArray[0], $fechaAsistencia, $fechaActual, $horaActual));
        }
        
        $this->inicializacionVariablesSesion($IDExterno, $fechaAsistencia);
    }

    private function inicializacionVariablesSesion(string $IDExterno, string $fechaAsistencia) : void
    {
        $_SESSION["IDExterno"] = $IDExterno;
        $_SESSION["FechaReservada"] = $fechaAsistencia;
    }
}

?>