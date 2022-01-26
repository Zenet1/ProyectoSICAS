<?php
include_once("ReservaPersonal.Query.php");

class ReservaPersonal
{
    private Query $objQuery;
    private Fechas $fecha;
    private CorreoManejador $correo;
    private GeneradorQr $qr;

    public function __construct(Query $objQuery, Fechas $fecha, CorreoManejador $correo, GeneradorQr $qr)
    {
        $this->objQuery = $objQuery;
        $this->fecha = $fecha;
        $this->correo = $correo;
        $this->qr = $qr;
    }

    public function InsertarReserva(array $contenido)
    {
        $Queries = new ReservaQuery();

        $incogInser = array("idp" => $_SESSION["ID"], "fchA" => $this->fecha->FechaAct(), "hrA" => $this->fecha->HrAct(), "fchR" => $this->fecha->FechaSig());

        $incogSelect = array("idp" => $_SESSION["ID"], "fchR" => $this->fecha->FechaSig());

        $this->objQuery->ejecutarConsulta($Queries->InsertarReserva(), $incogInser);

        $resultado = $this->objQuery->ejecutarConsulta($Queries->RecuperarID(), $incogSelect);

        $NombreImagen = "";
        $contenidoQr = "";

        if ($contenido["rol"] === "Personal") {
            $NombreImagen = "per" . $_SESSION["ID"];
            $contenidoQr = $_SESSION["Conexion"] . "," . "per" . "," . $_SESSION["ID"] . "," . $resultado[0]["IDReservaPersonal"];
        }

        if ($contenido["rol"] === "Profesor") {
            $NombreImagen = "pro" . $_SESSION["ID"];
            $contenidoQr = $_SESSION["Conexion"] . "," . "pro" . "," . $_SESSION["ID"] . "," . $resultado[0]["IDReservaPersonal"];
        }

        $this->qr->setNombrePng($NombreImagen);
        $this->qr->GenerarImagen($contenidoQr);
        $this->correo->setArchivo(true);

        $asunto = "Codigo QR Asistencia";
        $mensaje = "A continuacion se le envia el codigo QR valido unicamente en fecha ";
        $mensaje .= $this->fecha->FechaSig() . " en su correspondiente facultad, se le exhorta a guardar la imagen";
        $mensaje .= "para evitar cualquier contratiempo";

        $destinatario = array($_SESSION["Correo"] => $_SESSION["NombrePersonal"]);

        $this->correo->EnviarCorreo($destinatario, $asunto, $mensaje, "img/" . $NombreImagen . ".png");
        unlink("img/" . $NombreImagen . ".png");
    }
}
