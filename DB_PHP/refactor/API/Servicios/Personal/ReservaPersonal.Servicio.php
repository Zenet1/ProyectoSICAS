<?php
include_once("ReservaPersonal.Query.php");

class ReservaPersonal
{
    private Query $objQuery;
    private ReservaQuery $objRes;
    private Fechas $fecha;
    private CorreoManejador $correo;
    private GeneradorQr $qr;

    public function __construct(Query $objQuery, Fechas $fecha, CorreoManejador $correo, GeneradorQr $qr)
    {
        $this->objQuery = $objQuery;
        $this->fecha = $fecha;
        $this->correo = $correo;
        $this->qr = $qr;
        $this->objRes = new ReservaQuery();
    }

    public function InsertarReserva(array $contenido)
    {

        $incogInser = array("idp" => $_SESSION["ID"], "fchA" => $this->fecha->FechaAct(), "hrA" => $this->fecha->HrAct(), "fchR" => $this->fecha->FechaSig());

        $incogSelect = array("idp" => $_SESSION["ID"], "fchR" => $this->fecha->FechaAct());

        $resultado = "";

        $NombreImagen = "";
        $contenidoQr = "";

        if ($contenido["rol"] === "Personal") {
            $this->objQuery->ejecutarConsulta($this->objRes->InsertarReservaPer(), $incogInser);
            $resultado = $this->objQuery->ejecutarConsulta($this->objRes->RecuperarID("reservacionespersonal"), $incogSelect);

            $NombreImagen = "per" . $_SESSION["ID"];
            $contenidoQr = $_SESSION["Conexion"] . "," . "per" . "," . $_SESSION["ID"] . "," . $resultado[0]["IDReserva"];
        }

        if ($contenido["rol"] === "Profesor") {
            $this->objQuery->ejecutarConsulta($this->objRes->InsertarReservaPro(), $incogInser);
            $resultado = $this->objQuery->ejecutarConsulta($this->objRes->RecuperarID("reservacionesacademicos"), $incogSelect);

            $NombreImagen = "pro" . $_SESSION["ID"];
            $contenidoQr = $_SESSION["Conexion"] . "," . "pro" . "," . $_SESSION["ID"] . "," . $resultado[0]["IDReserva"];
        }

        $this->qr->setNombrePng($NombreImagen);
        $this->qr->GenerarImagen($contenidoQr);
        $this->correo->setArchivo(true);

        $asunto = "Codigo QR Asistencia";
        $mensaje = "A continuacion se le envia el codigo QR valido unicamente en fecha ";
        $mensaje .= $this->fecha->FechaSig() . " en su correspondiente facultad, se le exhorta a guardar la imagen";
        $mensaje .= "para evitar cualquier contratiempo";

        $destinatario = array($_SESSION["Correo"] => $_SESSION["Nombre"]);

        $this->correo->EnviarCorreo($destinatario, $asunto, $mensaje, "img/" . $NombreImagen . ".png");
        unlink("img/" . $NombreImagen . ".png");
    }

    public function validarReservaNoExistente(array $contenido)
    {
        $Respuesta = "Aceptado";
        $incognitas = array("idp" => $_SESSION["ID"], "fchR" => $this->objFecha->FechaAct());
        $sql = "";

        if ($contenido["rol"] === "Personal") {
            $sql = $this->objRes->RecuperarID("reservacionespersonal");
        }

        if ($contenido["rol"] === "Profesor") {
            $sql = $this->objRes->RecuperarID("reservacionesacademicos");
        }

        $Reservaciones = $this->objQuery->ejecutarConsulta($sql, $incognitas);

        if (sizeof($Reservaciones) > 0) {
            $Respuesta = "Rechazado";
        }
        echo json_encode($Respuesta);
    }
}
