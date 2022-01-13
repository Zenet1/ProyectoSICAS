<?php

class Alertar
{
    private Query $objQuery;
    private array $estrucVerif;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->ArmarEstructura();
    }

    public function Alertar(array $datos)
    {
        $this->VerificarAsistenciaRango($datos);
    }

    private function VerificarAsistenciaRango(array $datos)
    {
        $matricula = $datos["matricula"];
        $fechaInicio = $datos["fechaInicio"];
        $fechaFin = $datos["fechaFin"];

        $datosAfectado = array("mtc" => $matricula, "fchIn" => $fechaInicio, "fchFn" => $fechaFin);
        $resultado = $this->objQuery->SELECT($this->estrucVerif, $datosAfectado);
        return (sizeof($resultado) !== 0 && $resultado !== false);
    }

    private function ArmarEstructura()
    {
        /// ESTRUCTURA DE VALIDACION ///
        $datosAsis = array("IDAsistenciaAlumnos");
        $condAsis = array("FechaAl>=:fchIn", "FechaAl<=:fchFn");
        $caracAsis = array("ALIAS" => "ASAL", "TABLA" => "asistenciasalumnos", "DESDE" => "si");

        $condAlum = array("Matricula=:mtc");
        $unionAlum = array("UNIR" => "asistenciasalumnos", "CON" => "IDAlumno");
        $caracAlum = array("ALIAS" => "ALM", "TABLA" => "alumnos");

        $this->estrucVerif["asistenciasalumnos"] = array("CARAC" => $caracAsis, "DATOS" => $datosAsis, "COND" => $condAsis);
        $this->estrucVerif["alumnos"] = array("CARAC" => $caracAlum, "COND" => $condAlum, "UNIR" => $unionAlum);
    }
}
