<?php
class Salones
{

    private Query $objQuery;
    private array $estrucObtener;
    private array $estrucActualizar;
    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->ArmarEstruct();
    }

    public function ObtenerSalones()
    {
        $resultado = $this->objQuery->SELECT($this->estrucObtener, array());
        echo json_encode($resultado);
    }

    public function ActualizarSalon(array $datosSalon)
    {
        $this->objQuery->UPDATE($this->estrucActualizar, $datosSalon);
    }

    private function ArmarEstruct()
    {
        /* Estructura SELECT */

        $datosSal = array("IDSalon", "NombreSalon", "Capacidad");
        $caracSal = array("ALIAS" => "SAL", "TABLA" => "salones", "DESDE" => "si");
        $datosEdi = array("NombreEdificio");
        $unirEdi = array("UNIR" => "salones", "CON" => "IDEdificio");
        $caracEdi = array("ALIAS" => "EDI", "TABLA" => "edificios");
        $this->estrucObtener["salones"] = array("CARAC" => $caracSal, "DATOS" => $datosSal);
        $this->estrucObtener["edificios"] = array("CARAC" => $caracEdi, "DATOS" => $datosEdi, "UNIR" => $unirEdi);

        /* Estructura UPDATE */
        $datosUP = array("Capacidad");
        $condUp = array("IDSalon=");
        $caracUP = array("ALIAS" => "SAL", "TABLA" => "salones", "DESDE" => "si");
        $this->estrucActualizar["salones"] = array("CARAC" => $caracUP, "COND" => $condUp, "DATOS" => $datosUP);
    }

    /*

    UPDATE salones SET Capacidad = ? WHERE IDSalon = ?
    SELECT SAL.IDSalon, SAL."NombreSalon", SAL.Capacidad,EDI.NombreEdificio FROM salones AS SAL INNER JOIN edificios AS EDI ON EDI.IDEdificio=SAL.IDEdificio ORDER BY EDI.NombreEdificio

    */
}
