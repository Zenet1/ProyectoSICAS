<?php
class Salones
{

    private Query $objQuery;
    private string $UPDATESalon;
    private string $SELECTSalon;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->UPDATESalon = "UPDATE salones SET Capacidad=:cpd WHERE IDSalon=:ids";
        $this->SELECTSalon = "SELECT SAL.IDSalon,SAL.NombreSalon,SAL.Capacidad,EDI.NombreEdificio FROM salones AS SAL INNER JOIN edificios AS EDI ON EDI.IDEdificio=SAL.IDEdificio ORDER BY EDI.NombreEdificio";
    }

    public function ObtenerSalones()
    {
        $resultado = $this->objQuery->ejecutarConsula($this->SELECTSalon, array());
        echo json_encode($resultado);
    }

    public function ActualizarSalon(array $datosSalon)
    {
        $this->objQuery->ejecutarConsula($this->UPDATESalon, $datosSalon);
    }

    public function EliminarSalon(array $datosSalon)
    {
        
    }
}
