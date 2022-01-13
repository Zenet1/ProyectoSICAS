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
        $resultado = $this->VerificarAsistenciaRango($datosAfectado);

        if ($resultado !== false) {
            $gruposUnicos = $this->ObtenerGrupos($resultado);

        }
    }

    private function ObtenerGrupos(array $datos): array
    {
        $gruposUnicos = array();

        foreach ($datos as $DATO) {
            if (!isset($gruposUnicos[$DATO["IDGrupo"]])) {
                $gruposUnicos[$DATO["IDGrupo"]] = $DATO["IDGrupo"];
            }
        }
        return $gruposUnicos;
    }

    private function VerificarAsistenciaRango(array $datos)
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

        $condAsis = array("FechaAl>=:fchIn", "FechaAl<=:fchFn");
        $caracAsis = array("ALIAS" => "ASAL", "TABLA" => "asistenciasalumnos", "DESDE" => "si");

        $condAlum = array("Matricula=:mtc");
        $unionAlum = array("UNIR" => "asistenciasalumnos", "EMIDATO" => "IDAlumno", "RECDATO" => "IDAlumno");
        $caracAlum = array("ALIAS" => "ALM", "TABLA" => "alumnos");

        $datosCar = array("IDGrupo");
        $unionCar = array("UNIR" => "reservacionesalumnos", "EMIDATO" => "IDCarga", "RECDATO" => "IDCarga");
        $caracCar = array("ALIAS" => "CGAC", "TABLA" => "cargaacademica");

        $unionRes = array("UNIR" => "asistenciasalumnos", "EMIDATO" => "FechaReservaAl", "RECDATO" => "FechaAl");
        $caracRes = array("ALIAS" => "RSAL", "TABLA" => "reservacionesalumnos");

        $this->estrucGeneral["asistenciasalumnos"] = array("CARAC" => $caracAsis, "COND" => $condAsis);
        $this->estrucGeneral["alumnos"] = array("CARAC" => $caracAlum, "COND" => $condAlum, "UNIR" => $unionAlum);
        $this->estrucGeneral["reservacionesalumnos"] = array("CARAC" => $caracRes, "UNIR" => $unionRes);
        $this->estrucGeneral["cargasacademicas"] = array("CARAC" => $caracCar, "DATOS" => $datosCar, "UNIR" => $unionCar);
    }
}
