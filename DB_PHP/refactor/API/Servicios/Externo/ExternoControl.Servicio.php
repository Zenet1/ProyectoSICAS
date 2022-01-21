<?php
class ExternoControl{

    private Query $objQuery;
    private Fechas $fecha;

    public function __construct(Query $objQuery, Fechas $fecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $fecha;
    }

    public function enviarQRExterno(array $IDOficinas, string $fechaReservada) : void
    {
        session_start();
        if($this->sesionActivaExterno()){
            
            $objCorreo = new CorreoManejador();

            $IDExterno = $_SESSION["IDExterno"];
            $correoExterno = $_SESSION["Correo"];
            $nombreExterno = $_SESSION["Nombre"];
            $fechaReservada = $_SESSION["FechaReservada"];
            $datosDestinatario = array($correoExterno => $nombreExterno);

            $contenidoCorreo = $this->generarContenidoCorreo($nombreExterno, $IDExterno, $IDOficinas, $fechaReservada);

            $nombreQR = $this->generarQRExterno($IDExterno, $IDOficinas, $fechaReservada);
            $ubicacionQR = "img/" . $nombreQR .".png";

            $objCorreo->setArchivo(true);
            $objCorreo->EnviarCorreo($datosDestinatario, $contenidoCorreo[0], $contenidoCorreo[1], $ubicacionQR);

            //unlink($ubicacionQR);
        }else{
            echo "ERROR: Sesión no activa";
        }
    }

    private function generarContenidoCorreo(string $nombreExterno, string $IDExterno, array $listaOficinas, string $fechaReservada) : array
    {
        $asunto = "Clave QR para acceso";
        $mensaje = "Estimado " .  $nombreExterno . " el siguiente correo contiene su clave unica QR para acceder";
        $mensaje .= " a su entidad educativa correspondiente, este codigo es unicamente valido en la fecha " . $fechaReservada . ".\n";
        
        $mensaje = "Usted ha podido realizar reservaciones con éxito a las siguientes oficinas:<br>";
        $oficinasRecuperadas = $this->recuperarOficinasReservadas($IDExterno, $listaOficinas, $fechaReservada);
        $mensaje .= $oficinasRecuperadas;

        $mensaje .= "Se le exhorta que guarde la imagen para evitar algun problema.";

        return array($asunto, $mensaje);
    }

    private function recuperarOficinasReservadas(string $IDExterno, array $listaOficinas, string $fechaReservada) : string
    {
        $mensaje = "";
        
        foreach($listaOficinas as $IDOficina){
            $nombreOficina = $this->recuperarNombreOficina($IDExterno, $IDOficina, $fechaReservada);
            $mensaje .= "<li>" . $nombreOficina . "</li>";
        }
        return $mensaje;
    }

    private function recuperarNombreOficina(string $IDExterno, $IDOficina, string $fechaReservada) : string
    {

        $sql_recuperarOficina = "SELECT OFC.NombreOficina FROM oficinas AS OFC 
        INNER JOIN reservacionesexternos AS RSEX 
        ON RSEX.IDOficina=OFC.IDOficina 
        WHERE RSEX.IDExterno=? AND RSEX.IDOficina=? AND RSEX.FechaReservaExterno=?";

        $nombreOficina = $this->objQuery->ejecutarConsulta($sql_recuperarOficina, array($IDExterno, $IDOficina, $fechaReservada));

        return $nombreOficina[0]["NombreOficina"];
    }

    private function generarQRExterno(string $IDExterno, array $listaIDOficinas, string $fechaReservada) : string
    {
        $nombreQRExterno = "e" . $IDExterno;
        $contenidoQRExterno = $this->generarContenidoQR($IDExterno, $listaIDOficinas, $fechaReservada);

        $QR = new GeneradorQr();
        $QR->setNombrePng($nombreQRExterno);
        $QR->GenerarImagen($contenidoQRExterno);

        return $nombreQRExterno;
    }

    private function generarContenidoQR(string $IDExterno, array $listaIDOficinas, string $fechaReservada) : string
    {
        $ContenidoQR = "e," . $IDExterno;

        foreach($listaIDOficinas as $IDOficina){
            $sql_recuperarIDReserva = "SELECT IDReservaExterno FROM reservacionesexternos 
            WHERE IDExterno = ? AND IDOficina = ? AND FechaReservaExterno = ?";
            
            $IDReserva = $this->objQuery->ejecutarConsulta($sql_recuperarIDReserva, array($IDExterno, $IDOficina, $fechaReservada));
            $ContenidoQR .= "," . $IDReserva[0]["IDReservaExterno"];
        }

        return $ContenidoQR;
    }

    private function sesionActivaExterno() : bool
    {
        return (isset($_SESSION['Nombre']) && isset($_SESSION['apellidosExterno']) && isset($_SESSION['empresa']) && isset($_SESSION['Correo']));
    }
}

?>