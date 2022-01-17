<?php

class EstadisticaQuery
{

    private array $aditamento;

    public function __construct()
    {
        $this->aditamento["Genero"] = " AND ALM.Genero=:gnr ";
        $this->aditamento["Plan"] = " AND PLE.NombrePlan=:nmp ";
    }

    public function ObtenerQuery(string $nombreTabla): string
    {
        return "SELECT PLE.NombrePlan,PLE.SiglasPlan,ALM.Genero FROM $nombreTabla AS GEN INNER JOIN alumnos AS ALM ON ALM.IDAlumno=GEN.IDAlumno INNER JOIN planesdeestudio AS PLE ON PLE.IDPlanEstudio=ALM.IDPlanEstudio WHERE GEN.FechaAl>=:fch AND GEN.FechaAl<=:fch";
    }

    public function ObtenerAditamento(string $nombreAdi): string
    {
        return $this->aditamento[$nombreAdi];
    }
}
