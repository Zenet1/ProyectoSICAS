<?php
class AlumnoControl
{
    private Query $objQuery;
    private Fechas $objFecha;

    public function __construct(Query $objQuery, Fechas $objFecha)
    {
        $this->objQuery = $objQuery;
        $this->objFecha = $objFecha;
    }

    public function EnviarQRCorreo(array $Materias, CorreoManejador $correo, GeneradorQr $qr)
    {
        $nombreImagen = "a" . $_SESSION["IDAlumno"];
        $contenido = $_SESSION["Conexion"] . "," . "a," . $_SESSION["IDAlumno"] . "," . $this->GenerarContenidoQR();

        $qr->setNombrePng($nombreImagen);
        $qr->GenerarImagen($contenido);

        $destinatario = array($_SESSION["Correo"] => $_SESSION["Nombre"]);
        $asunto = "Clave QR para acceso";
        $mensaje = "Estimado " .  $_SESSION["Nombre"] . " el siguiente correo contiene su clave unica QR para accerder";
        $mensaje .= " a su entidad educativa correspondiente, este codigo es unicamente valido en la fecha ";
        $mensaje .= $this->objFecha->FechaSig("d-m-Y") . ". Se le exhorta que guarde la imagen para evitar algun problema";
        $mensaje .= ". Las materias listadas son las que alcanzo un cupo disponible<ul>";
        $materiasCorreo = "";
        foreach ($Materias as $MATERIA) {
            $materiasCorreo .= "<li>" . $MATERIA->NombreAsignatura . "</li>";
        }
        $mensaje .= $materiasCorreo . "</ul>";

        $imagenCodigo = "img/" . $nombreImagen . ".png";
        $correo->setArchivo(true);

        $correo->EnviarCorreo($destinatario, $asunto, $mensaje, $imagenCodigo);
        unlink($imagenCodigo);
    }

    private function GenerarContenidoQR(): string
    {
        $qrContenido = "";

        $IDReservaciones = "SELECT RSV.IDReservaAlumno FROM reservacionesalumnos AS RSV INNER JOIN cargaacademica AS CGAC ON RSV.IDCarga=CGAC.IDCarga WHERE CGAC.IDAlumno=:ida AND RSV.FechaAlumno=:fchA";
        $incognitas = array("ida" => $_SESSION["IDAlumno"], "fchA" => $this->objFecha->FechaAct());

        $resultado = $this->objQuery->ejecutarConsulta($IDReservaciones, $incognitas);
        $contIDs = 0;

        foreach ($resultado as $IDReserva) {
            $qrContenido .= $IDReserva["IDReservaAlumno"] . (++$contIDs < sizeof($resultado) ? "," : "");
        }

        return $qrContenido;
    }
}
