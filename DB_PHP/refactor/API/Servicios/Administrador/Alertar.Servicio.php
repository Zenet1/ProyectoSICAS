<?php

class Alertar
{
    private Query $objQuery;
    private array $estrucGeneral;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->ArmarEstructura();
    }

    public function Alertar(array $datos)
    {
        $matricula = $datos["matricula"];
        $fechaInicio = $datos["fechaInicio"];
        $fechaFin = $datos["fechaFin"];
        $datosAfectado = array("mtc" => $matricula, "fchIn" => $fechaInicio, "fchFn" => $fechaFin);

        if ($this->VerificarAsistenciaRango($datosAfectado) !== false) {
        }
    }

    private function VerificarAsistenciaRango(array $datos): bool
    {
        $resultado = $this->objQuery->SELECT($this->estrucGeneral, $datos);

        if (sizeof($resultado) !== 0 && $resultado !== false) {
            return $resultado;
        }
        return false;
    }

    private function ObteneFechasAsistencia(array $datos)
    {
    }

    private function ArmarEstructura()
    {
        /// ESTRUCTURA DE DATOS ///

        $datosAsis = array("IDAsistenciaAlumnos");
        $condAsis = array("FechaAl>=:fchIn", "FechaAl<=:fchFn");
        $caracAsis = array("ALIAS" => "ASAL", "TABLA" => "asistenciasalumnos", "DESDE" => "si");

        $condAlum = array("Matricula=:mtc");
        $unionAlum = array("UNIR" => "asistenciasalumnos", "CON" => "IDAlumno");
        $caracAlum = array("ALIAS" => "ALM", "TABLA" => "alumnos");

        $this->estrucGeneral["asistenciasalumnos"] = array("CARAC" => $caracAsis, "DATOS" => $datosAsis, "COND" => $condAsis);
        $this->estrucGeneral["alumnos"] = array("CARAC" => $caracAlum, "COND" => $condAlum, "UNIR" => $unionAlum);

        

        
    }
}
