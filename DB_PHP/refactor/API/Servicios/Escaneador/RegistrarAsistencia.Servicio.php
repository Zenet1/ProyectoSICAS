<?php
include_once("RegistrarAsistencia.Query.php");

class RegistrarAsistencia
{
    private Query $objQuery;
    private RegistrarQuery $regQuery;
    private Fechas $fecha;
    private array $respuesta;

    public function __construct(Query $objQuery, Fechas $fecha)
    {
        $this->objQuery = $objQuery;
        $this->regQuery = new RegistrarQuery();
        $this->respuesta["respuesta"] = "invalido";
        $this->fecha = $fecha;
    }

    public function Asistencias(string $contenido)
    {
        $codigoQr = explode(",", $contenido);
        $tipo = array_shift($codigoQr);
        $id = array_shift($codigoQr);

        if ($this->TipoValido($tipo)) {
            $operaciones = $this->TipoOperacion($tipo);
            $this->respuesta["respuesta"] = $this->ValidarReservaciones($operaciones[0], $id, $codigoQr);
            $this->InsertarAsistencia($operaciones[1], $id);
        }
        echo json_encode($this->respuesta);
    }

    private function ValidarReservaciones(string $operacion, int $id, array $codigoQr): string
    {
        $resultado = array();
        foreach ($codigoQr as $IDRESERVA) {
            $incognitas = array("id" => $id, "idr" => $IDRESERVA, "fch" => $this->fecha->FechaAct());
            $resultado = $this->objQuery->ejecutarConsula($operacion, $incognitas);
            if ($resultado === false || sizeof($resultado) === 0) {
                return "invalido";
            }
        }
        $this->respuesta["NombreCompleto"] = $this->AsignarNombre($resultado[0]);
        return "valido";
    }

    private function InsertarAsistencia(String $operacion, int $id)
    {
        $incognitas = array("id" => $id, "fch" => $this->fecha->FechaAct(), "hri" => $this->fecha->HrAct());
        $this->objQuery->ejecutarConsula($operacion, $incognitas);
    }

    private function TipoValido(string $tipo): bool
    {
        $esValido = false;
        switch ($tipo) {
            case "a":
                $esValido =  true;
                break;
            case "e":
                $esValido = true;
                break;
        }
        return $esValido;
    }

    private function TipoOperacion(string $tipo): array
    {
        switch ($tipo) {
            case "a":
                return array($this->regQuery->recuperarQuery("SELECTResAl"), $this->regQuery->recuperarQuery("INSERTAsisAl"));
                break;
            case "e":
                return array($this->regQuery->recuperarQuery("SELECTResEx"), $this->regQuery->recuperarQuery("INSERTAsisEx"));
        }
    }

    private function AsignarNombre(array $nombre)
    {
        $nombreCompleto = "";
        $contPartes = 0;
        foreach ($nombre as $Clave => $Valor) {
            $nombreCompleto .= $Valor . (++$contPartes < sizeof($nombre) ? " " : "");
        }
        return $nombreCompleto;
    }
}
