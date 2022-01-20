<?php
class Externo{

    private Conexion $conexion;

    public function __construct()
    {
        include_once('../Clases/Conexion.Class.php');
        $this->conexion = Conexion::ConexionInstacia();
    }

    public function registroExterno($datos){
        session_start();
        $_SESSION['Nombre'] = "$datos->nombre";
        $_SESSION['apellidosExterno'] = "$datos->apellidos";
        $_SESSION['empresa'] = "$datos->empresa";
        $_SESSION['Correo'] = "$datos->correo";
    }

    public function insertarReservaExterno($datos_entrada){
        session_start();
        $externoRegistrado = $this->insertarExterno();
        if($externoRegistrado){    
            $IDExterno = $this->recuperarIDExterno();
            $ContenidoQR = $this->insertarReservacion($datos_entrada->seleccionadas, $IDExterno["IDExterno"], $datos_entrada->fechaAsistencia);
            //generarQRExterno($IDExterno["IDExterno"], $ContenidoQR);
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

        $obj_insertarExterno = $this->conexion->getConexion()->prepare($sql_insertarExterno);

        if($this->sesionActivaExterno()){
            $obj_insertarExterno->execute(array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo'], $_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));
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

        $obj_recuperarIDExterno = $this->conexion->getConexion()->prepare($sql_recuperarIDExterno);

        $obj_recuperarIDExterno->execute(array($_SESSION['Nombre'], $_SESSION['apellidosExterno'], $_SESSION['empresa'], $_SESSION['Correo']));

        $IDExternoRecuperado = $obj_recuperarIDExterno->fetch(PDO::FETCH_ASSOC);

        return $IDExternoRecuperado;
    }

    private function insertarReservacion(array $oficinas, string $IDExterno, string $fechaAsistencia) : string {
        $fechaActual = date('Y-m-d');
        $horaActual = date("H:i:s");
        
        $sql_insertarReservacion = "INSERT INTO reservacionesexternos (IDExterno, IDOficina, FechaReservaExterno, FechaExterno, HoraExterno) VALUES (?, ?, ?, ?, ?)";
        $sql_recuperarIDReserva = "SELECT IDReservaExterno FROM reservacionesexternos WHERE IDExterno = ? AND IDOficina = ? AND FechaReservaExterno = ?";
        
        $obj_insertarReservacion = $this->conexion->getConexion()->prepare($sql_insertarReservacion);
        $obj_recuperarIDReserva = $this->conexion->getConexion()->prepare($sql_recuperarIDReserva);

        $QRContenido = $IDExterno;

        foreach($oficinas as $oficina){
            $oficinaArray = (array)$oficina;
            
            $obj_insertarReservacion->execute(array($IDExterno, $oficinaArray["IDOficina"], $fechaAsistencia, $fechaActual, $horaActual));
            $obj_recuperarIDReserva->execute(array($IDExterno, $oficinaArray["IDOficina"], $fechaAsistencia));
            $IDReserva = $obj_recuperarIDReserva->fetch(PDO::FETCH_ASSOC);

            $QRContenido .= "," . $IDReserva["IDReservaExterno"];
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