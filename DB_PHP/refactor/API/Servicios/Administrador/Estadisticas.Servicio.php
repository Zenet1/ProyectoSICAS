<?php
include_once("Estadisticas.Query.php");

class EstadisticaControl
{
    private Query $objQuery;
    private EstadisticaQuery $objEstic;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->objEstic = new EstadisticaQuery();
    }

    public function EstadisticasAlumno(array $contenido)
    {

    }

    public function EstadisticasPersonal(array $contenido)
    {

    }
}
