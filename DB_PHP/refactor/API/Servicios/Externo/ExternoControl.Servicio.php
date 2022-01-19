<?php
class ExternoControl{

    private Query $objQuery;
    private Fechas $fecha;

    public function __construct(Query $objQuery, Fechas $fecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $fecha;
    }

    public function registroExterno($datos){
        session_start();
        $_SESSION['Nombre'] = "$datos->nombre";
        $_SESSION['apellidosExterno'] = "$datos->apellidos";
        $_SESSION['empresa'] = "$datos->empresa";
        $_SESSION['Correo'] = "$datos->correo";
    }

    public function insertarReservaExterno($oficinas, $fechaAsistencia){
        session_start();
        $externoRegistrado = $this->insertarExterno();
        if($externoRegistrado){
            $IDExterno = $this->recuperarIDExterno();
            $ContenidoQR = $this->insertarReservacion($oficinas, $IDExterno["IDExterno"], $fechaAsistencia);
            $this->generarQRExterno($IDExterno["IDExterno"], $ContenidoQR);
        }else{
            echo "No se tiene una sesión iniciada";
        }
    }  

    private function generarQRExterno(string $IDExterno, string $ContenidoQR){
        $NombreQRExterno = "e" . $IDExterno;
        $ContenidoQRExterno = "e," . $ContenidoQR;
        $QR = new GeneradorQr();
        $QR->setNombrePng($NombreQRExterno);
        $QR->GenerarImagen($ContenidoQRExterno);
    }

    private function insertarExterno() : bool{
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

    private function sesionActivaExterno() : bool{
        return (isset($_SESSION['Nombre']) && isset($_SESSION['apellidosExterno']) && isset($_SESSION['empresa']) && isset($_SESSION['Correo']));
    }

    private function recuperarIDExterno() : array{
        $sql_recuperarIDExterno = "SELECT IDExterno FROM externos WHERE NombreExterno = ? AND ApellidosExterno = ? AND Empresa = ? AND CorreoExterno = ?";

        $IDExternoRecuperado = $this->objQuery->ejecutarConsulta($sql_recuperarIDExterno, array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));

        return $IDExternoRecuperado[0];
    }

    private function insertarReservacion(array $oficinas, string $IDExterno, string $fechaAsistencia) : string {
       
        $fechaActual =  $this->objFecha->FechaAct("d-m-Y");
        $horaActual =  $this->objFecha->HrAct("H:i:s");
        
        $sql_insertarReservacion = "INSERT INTO reservacionesexternos 
        (IDExterno, IDOficina, FechaReservaExterno, FechaExterno, HoraExterno) 
        VALUES (?, ?, ?, ?, ?)";

        $sql_recuperarIDReserva = "SELECT IDReservaExterno FROM reservacionesexternos 
        WHERE IDExterno = ? AND IDOficina = ? AND FechaReservaExterno = ?";

        $QRContenido = $IDExterno;

        foreach($oficinas as $oficina){
            $oficinaArray = (array)$oficina;
            
            $this->objQuery->ejecutarConsulta($sql_insertarReservacion, array($IDExterno, $oficinaArray["IDOficina"], $fechaAsistencia, $fechaActual, $horaActual));
            $IDReserva = $this->objQuery->ejecutarConsulta($sql_recuperarIDReserva, array($IDExterno, $oficinaArray["IDOficina"], $fechaAsistencia));

            $QRContenido .= "," . $IDReserva[0]["IDReservaExterno"];
        }
        
        $this->inicializacionVariablesSesion($IDExterno, $fechaAsistencia);
        return $QRContenido;
    }

    private function inicializacionVariablesSesion(string $IDExterno, string $fechaAsistencia) : void{
        $_SESSION["IDExterno"] = $IDExterno;
        $_SESSION["FechaReservada"] = $fechaAsistencia;
    }
}

?>