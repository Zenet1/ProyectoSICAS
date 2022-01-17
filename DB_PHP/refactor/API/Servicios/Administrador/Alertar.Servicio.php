<?php
include_once("Alertar.Query.php");

class Alertar
{
    private Query $objQuery;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
    }

    public function Alertar(array $datos)
    {
    }

    private function ValidarAsistencia() : bool
    {
        
    }
}
