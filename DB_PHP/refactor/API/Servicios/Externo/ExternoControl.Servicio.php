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
            $datosSesion = $this->recuperarVariablesSesion();
            $datosDestinatario = array($datosSesion["correoExterno"] => $datosSesion["nombreExterno"]);

            $contenidoCorreo = $this->generarContenidoCorreo($datosSesion["nombreExterno"], $datosSesion["IDExterno"], $IDOficinas, $datosSesion["fechaReservada"]);

            $nombreQR = $this->generarQRExterno($datosSesion["IDExterno"], $IDOficinas, $datosSesion["fechaReservada"], $datosSesion["fechaCuandoSeReservo"], $datosSesion["horaCuandoSeReservo"]);
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
        $oficinasRecuperadas = $this->recuperarOficinasReservadas($listaOficinas);
        $mensaje .= $oficinasRecuperadas;

        $mensaje .= "Se le exhorta que guarde la imagen para evitar algun problema.";

        return array($asunto, $mensaje);
    }

    private function recuperarOficinasReservadas(array $listaOficinas) : string
    {
        $mensaje = "";
        
        foreach($listaOficinas as $IDOficina){
            $nombreOficina = $this->recuperarNombreOficina($IDOficina);
            $mensaje .= "<li>" . $nombreOficina . "</li>";
        }
        return $mensaje;
    }

    private function recuperarNombreOficina($IDOficina) : string
    {

        $sql_recuperarOficina = "SELECT NombreOficina FROM oficinas WHERE IDOficina=?";

        $nombreOficina = $this->objQuery->ejecutarConsulta($sql_recuperarOficina, array($IDOficina));

        return $nombreOficina[0]["NombreOficina"];
    }

    private function generarQRExterno(string $IDExterno, array $listaIDOficinas, string $fechaReservada, string $fechaExterno, string $horaExterno) : string
    {
        $nombreQRExterno = "e" . $IDExterno;
        $contenidoQRExterno = $this->generarContenidoQR($IDExterno, $listaIDOficinas, $fechaReservada, $fechaExterno, $horaExterno,);

        $QR = new GeneradorQr();
        $QR->setNombrePng($nombreQRExterno);
        $QR->GenerarImagen($contenidoQRExterno);

        return $nombreQRExterno;
    }

    private function generarContenidoQR(string $IDExterno, array $listaIDOficinas, string $fechaReservada, string $fechaExterno, string $horaExterno) : string
    {
        $ContenidoQR = "e," . $IDExterno;

        foreach($listaIDOficinas as $IDOficina){
            $sql_recuperarIDReserva = "SELECT IDReservaExterno FROM reservacionesexternos 
            WHERE IDExterno = ? AND IDOficina = ? AND FechaReservaExterno = ? AND FechaExterno = ? AND HoraExterno = ?";
            $IDReserva = $this->objQuery->ejecutarConsulta($sql_recuperarIDReserva, array($IDExterno, $IDOficina, $fechaReservada, $fechaExterno, $horaExterno));
            $ContenidoQR .= "," . $IDReserva[0]["IDReservaExterno"];
        }

        return $ContenidoQR;
    }

    private function recuperarVariablesSesion(){
        $IDExterno = $_SESSION["IDExterno"];
        $correoExterno = $_SESSION["Correo"];
        $nombreExterno = $_SESSION["Nombre"] . " " . $_SESSION["ApellidosExterno"];
        $fechaCuandoSeReservo = $_SESSION['FechaActual'];
        $horaCuandoSeReservo = $_SESSION['HoraActual'];
        $fechaReservada = $_SESSION["FechaReservada"];

        return (array("IDExterno" => $IDExterno, "correoExterno" => $correoExterno, "nombreExterno" => $nombreExterno, "fechaReservada" => $fechaReservada, "fechaCuandoSeReservo" => $fechaCuandoSeReservo, "horaCuandoSeReservo" => $horaCuandoSeReservo));
    }

    private function sesionActivaExterno() : bool
    {
        return (isset($_SESSION["IDExterno"]) && isset($_SESSION['Nombre']) && isset($_SESSION['ApellidosExterno']) && isset($_SESSION['Empresa']) && isset($_SESSION['Correo']) && isset($_SESSION['FechaActual']) && isset($_SESSION['HoraActual']));
    }
}

?>