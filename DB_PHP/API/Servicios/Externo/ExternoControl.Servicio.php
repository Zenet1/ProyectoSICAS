<?php
class ExternoControl
{

    private Query $objQuery;
    private Fechas $fecha;

    public function __construct(Query $objQuery, Fechas $fecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $fecha;
    }

    public function enviarQRExterno(array $IDOficinas, string $fechaReservada): void
    {
        if ($this->sesionActivaExterno()) {
            $objCorreo = new CorreoManejador();
            $datosSesion = $this->recuperarVariablesSesion();
            $datosDestinatario = array($datosSesion["correoExterno"] => $datosSesion["nombreExterno"]);

            $contenidoCorreo = $this->generarContenidoCorreo($datosSesion["nombreExterno"], $datosSesion["IDExterno"], $IDOficinas, $datosSesion["fechaReservada"]);

            $nombreQR = $this->generarQRExterno($datosSesion["IDExterno"], $datosSesion["siglasFacultad"], $IDOficinas, $datosSesion["fechaReservada"], $datosSesion["fechaCuandoSeReservo"], $datosSesion["horaCuandoSeReservo"]);
            $ubicacionQR = "img/" . $nombreQR[0] . ".png";

            $datosQr = array("nombreQr" => $ubicacionQR, "contenidoQr" => $nombreQR[1], "mensaje" => $contenidoCorreo[1], "correo" => $_SESSION["Correo"], "nombre" => $_SESSION["Nombre"], "asunto" => $contenidoCorreo[0]);

            array_push($_SESSION["CorreosQR"], $datosQr);

            //$objCorreo->setArchivo(true);
            //$objCorreo->EnviarCorreo($datosDestinatario, $contenidoCorreo[0], $contenidoCorreo[1], $ubicacionQR);

            //unlink($ubicacionQR);
        } else {
            echo "ERROR: Sesión no activa";
        }
    }

    private function generarContenidoCorreo(string $nombreExterno, string $IDExterno, array $listaOficinas, string $fechaReservada): array
    {
        $asunto = "Clave QR para acceso";
        $mensaje = "Estimado " .  $nombreExterno . ", el siguiente correo electrónico contiene su clave única (QR) para acceder";
        $mensaje .= " a su entidad educativa correspondiente, este código es únicamente válido en la fecha " . $fechaReservada . ".\n";

        $mensaje .= "<br>Usted ha podido realizar reservaciones con éxito a las siguientes oficinas:<br><br>";
        $oficinasRecuperadas = $this->recuperarOficinasReservadas($listaOficinas);
        $mensaje .= $oficinasRecuperadas . "<br><br>";

        $mensaje .= "Se le exhorta que guarde la imagen QR para el registro de su asistencia.";

        return array($asunto, $mensaje);
    }

    private function recuperarOficinasReservadas(array $listaOficinas): string
    {
        $mensaje = "";

        foreach ($listaOficinas as $IDOficina) {
            $nombreOficina = $this->recuperarNombreOficina($IDOficina);
            $mensaje .= "<li>" . $nombreOficina . "</li>";
        }
        return $mensaje;
    }

    private function recuperarNombreOficina($IDOficina): string
    {

        $sql_recuperarOficina = "SELECT NombreOficina FROM oficinas WHERE IDOficina=?";

        $nombreOficina = $this->objQuery->ejecutarConsulta($sql_recuperarOficina, array($IDOficina));

        return $nombreOficina[0]["NombreOficina"];
    }

    private function generarQRExterno(string $IDExterno, string $siglasFacultad, array $listaIDOficinas, string $fechaReservada, string $fechaExterno, string $horaExterno): array
    {
        $nombreQRExterno = "e" . $IDExterno;
        $contenidoQRExterno = $this->generarContenidoQR($IDExterno, $siglasFacultad, $listaIDOficinas, $fechaReservada, $fechaExterno, $horaExterno,);

        //$QR = new GeneradorQr();
        //$QR->setNombrePng($nombreQRExterno);
        //$QR->GenerarImagen($contenidoQRExterno);

        return array($nombreQRExterno, $contenidoQRExterno);
    }

    private function generarContenidoQR(string $IDExterno, string $siglasFacultad, array $listaIDOficinas, string $fechaReservada, string $fechaExterno, string $horaExterno): string
    {
        $ContenidoQR = $siglasFacultad;
        $ContenidoQR .= ",e," . $IDExterno;

        foreach ($listaIDOficinas as $IDOficina) {
            $sql_recuperarIDReserva = "SELECT IDReservaExterno FROM reservacionesexternos 
            WHERE IDExterno = ? AND IDOficina = ? AND FechaReservaExterno = ? AND FechaExterno = ? AND HoraExterno = ?";
            $IDReserva = $this->objQuery->ejecutarConsulta($sql_recuperarIDReserva, array($IDExterno, $IDOficina, $fechaReservada, $fechaExterno, $horaExterno));
            $ContenidoQR .= "," . $IDReserva[0]["IDReservaExterno"];
        }

        return $ContenidoQR;
    }

    private function recuperarVariablesSesion()
    {
        $IDExterno = $_SESSION["IDExterno"];
        $correoExterno = $_SESSION["Correo"];
        $nombreExterno = $_SESSION["Nombre"] . " " . $_SESSION["ApellidosExterno"];
        $fechaCuandoSeReservo = $_SESSION['FechaActual'];
        $horaCuandoSeReservo = $_SESSION['HoraActual'];
        $fechaReservada = $_SESSION["FechaReservada"];
        $siglasFacultad = $_SESSION["Conexion"];

        return (array("IDExterno" => $IDExterno, "correoExterno" => $correoExterno, "nombreExterno" => $nombreExterno, "fechaReservada" => $fechaReservada, "fechaCuandoSeReservo" => $fechaCuandoSeReservo, "horaCuandoSeReservo" => $horaCuandoSeReservo, "siglasFacultad" => $siglasFacultad));
    }

    private function sesionActivaExterno(): bool
    {
        return (isset($_SESSION["IDExterno"]) && isset($_SESSION["Nombre"]) && isset($_SESSION["ApellidosExterno"]) && isset($_SESSION["Empresa"]) && isset($_SESSION["Correo"]) && isset($_SESSION["FechaActual"]) && isset($_SESSION["HoraActual"]) && isset($_SESSION["Conexion"]));
    }
}
