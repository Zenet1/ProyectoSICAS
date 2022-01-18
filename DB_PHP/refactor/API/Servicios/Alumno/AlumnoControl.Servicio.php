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

    
}
