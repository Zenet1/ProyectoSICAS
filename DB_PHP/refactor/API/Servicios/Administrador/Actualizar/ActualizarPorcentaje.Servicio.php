<?php

class Porcentaje
{
    private Query $objQuery;
    private array $estrucRecuperar;
    private array $estrucActualizar;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->ArmarEstructura();
    }


    public function RecuperarPorcentaje()
    {
        $resultado = $this->objQuery->SELECT($this->estrucRecuperar, array());
        print_r($resultado[0]["Porcentaje"]);
    }

    public function ActualizarPorcentaje(array $datosActualizar)
    {
        $this->objQuery->UPDATE($this->estrucActualizar, $datosActualizar);
    }

    private function ArmarEstructura()
    {
        /* Estructura de recuperar */

        $datosPor = array("Porcentaje");
        $caracPor = array("ALIAS" => "POR", "TABLA" => "porcentajecapacidad", "DESDE" => "si");
        $this->estrucRecuperar["porcentajecapacidad"] = array("CARAC" => $caracPor, "DATOS" => $datosPor);

        /* Estructura de Actualizar */

        $condPor = array("IDPorcentaje=");
        $this->estrucActualizar["porcentajecapacidad"] = array("CARAC" => $caracPor, "DATOS" => $datosPor, "COND" => $condPor);
    }
}
