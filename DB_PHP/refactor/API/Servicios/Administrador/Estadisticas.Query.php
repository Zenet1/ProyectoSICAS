<?php

class EstadisticaQuery
{
    private string $SELECTAsistencia;
    private string $SELECTincidentes;
    private string $AditamentoGenero;
    private string $AditamentoNombrePlan;



    public function __construct()
    {
        $this->SELECTAsistencia = "SELECT PLE.NombrePlan,PLE.SiglasPlan,ALM.Genero FROM asistenciaalumnos AS GEN INNER JOIN alumnos AS ALM ON ALM.IDAlumno=GEN.IDAlumno INNER JOIN planesdeestudio AS PLE ON PLE.IDPlanEstudio=ALM.IDPlanEstudio WHERE GEN.FechaAl>=:fch AND GEN.FechaAl<=:fch";

        $this->SELECTincidentes = "SELECT PLE.NombrePlan,PLE.SiglasPlan,ALM.Genero FROM incidentes AS GEN INNER JOIN alumnos AS ALM ON ALM.IDAlumno=GEN.IDAlumno INNER JOIN planesdeestudio AS PLE ON PLE.IDPlanEstudio=ALM.IDPlanEstudio WHERE GEN.FechaAl>=:fch AND GEN.FechaAl<=:fch";

        $this->AditamentoGenero = " AND ALM.Genero=:gnr ";
        
        $this->AditamentoNombrePlan = " AND PLE.NombrePlan=:nmp ";
    }
}
