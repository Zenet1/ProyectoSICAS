<?php

class AlertaQuery
{
    private string $SELECTAsistencia;
    private string $SELECTCargas;

    public function __construct()
    {
        $this->SELECTAsistencia = "SELECT * FROM asistenciasalumnos WHERE FechaAl>=:fchIn AND FechaAl<=:fchFn";
    }
}
