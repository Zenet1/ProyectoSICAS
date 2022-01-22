<?php
include_once("Autenticacion.Query.php");

class Autenticar
{
    private Query $objQuery;
    private AutentcacionQuery $objAunQ;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->objAunQ = new AutentcacionQuery();
    }

    public function ValidarCuenta(array $contenido)
    {
        print_r($contenido);
        $this->objQuery->ejecutarConsulta($this->objAunQ->VerificarLocal(), array());
    }
}
