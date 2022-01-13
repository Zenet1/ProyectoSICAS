<?php
class Alertar
{
    private Query $objQuery;
    private array $estrucFechas;
    private array $estrucGrupos;
    private array $estrucInvol;

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
        $fechasAsis = $this->VerificarAsistenciaRango($datosAfectado);

        if ($fechasAsis !== false) {
            $gruposCrudos = $this->ObtenerGrupos($fechasAsis, $matricula);
            $gruposUncios = $this->FiltrarGrupos($gruposCrudos);
            foreach ($fechasAsis as $FECHA) {
                $this->ObtenerInvolucrados($gruposUncios, $datosAfectado, $FECHA);
            }
        }
    }

    private function ObtenerGrupos(array $fechas, string $matricula)
    {
        $gruposCrudos = array();

        foreach ($fechas as $FECHA) {
            $datos = array("fch" => $FECHA["FechaAl"], "mtc" => $matricula);
            $gruposCrudos[] = $this->objQuery->SELECT($this->estrucGrupos, $datos);
        }
        return $gruposCrudos;
    }

    private function FiltrarGrupos(array $arrayGrupos): array
    {
        $gruposUnicos = array();
        foreach ($arrayGrupos as $GRUPOS) {
            foreach ($GRUPOS as $Clave => $Valor) {
                if (!isset($gruposUnicos[$Valor["IDGrupo"]])) {
                    $gruposUnicos[$Valor["IDGrupo"]] = $Valor["IDGrupo"];
                }
            }
        }
        return $gruposUnicos;
    }

    private function VerificarAsistenciaRango(array $datos)
    {
        $resultado = $this->objQuery->SELECT($this->estrucFechas, $datos);
        if (sizeof($resultado) !== 0 && $resultado !== false) {
            return $resultado;
        }
        return false;
    }

    private function ObtenerInvolucrados(array $grupos, array $datosAfectado, $fecha)
    {
        $resultado = array();
        foreach ($grupos as $IDGrupo) {
            $datosInvolucrados = array("mtc" => $datosAfectado["mtc"], "fch" => $fecha["FechaAl"], "idg" => $IDGrupo);
            $resultado = $this->objQuery->SELECT($this->estrucInvol, $datosInvolucrados);
        }
        return $resultado;
    }

    private function ArmarEstructura()
    {
        /// ESTRUCTURA DE FECHAS ///
        $datosAsis = array("FechaAl");
        $condAsis = array("FechaAl>=:fchIn", "FechaAl<=:fchFn");
        $caracAsis = array("ALIAS" =>  "ASAL", "TABLA" => "asistenciasalumnos", "DESDE" => "si");

        $condAlm = array("Matricula=:mtc");
        $unionAlm = array("UNIR" => "asistenciasalumnos", "EMIDATO" => "IDAlumno", "RECDATO" => "IDAlumno");
        $caracAlm = array("ALIAS" => "ALM", "TABLA" => "alumnos");

        $this->estrucFechas["alumnos"] = array("CARAC" => $caracAlm, "COND" => $condAlm, "UNIR" => $unionAlm);
        $this->estrucFechas["asistenciasalumnos"] = array("CARAC" => $caracAsis, "COND" => $condAsis, "DATOS" => $datosAsis);

        /// ESTRUCTURA DE Grupos ///

        $datosCGAC = array("IDGrupo");
        $unionCGAC = array("UNIR" => "reservacionesalumnos", "EMIDATO" => "IDCarga", "RECDATO" => "IDCarga");
        $caracCGAC = array("ALIAS" => "CGAC", "TABLA" => "cargaacademica");

        $condRes = array("FechaReservaAl=:fch");
        $unionAlmG = array("UNIR" => "cargaacademica", "EMIDATO" => "IDAlumno", "RECDATO" => "IDAlumno");
        $caracRes = array("ALIAS" => "RSAL", "TABLA" => "reservacionesalumnos", "DESDE" => "SI");

        $this->estrucGrupos["reservacionesalumnos"] = array("CARAC" => $caracRes, "COND" => $condRes);
        $this->estrucGrupos["cargaacademica"] = array("CARAC" => $caracCGAC, "DATOS" => $datosCGAC, "UNIR" => $unionCGAC);
        $this->estrucGrupos["alumnos"] = array("CARAC" => $caracAlm, "COND" => $condAlm, "UNIR" => $unionAlmG);

        /// ESTRUCTURA DE Involucrados ///

        $condAsisInv = array("FechaAl=:fch");
        $condAlmInv = array("Matricula!=:mtc");
        $condCGACInv = array("IDGrupo=:idg");
        $unionCGACInv = array("UNIR" => "alumnos", "EMIDATO" => "IDAlumno", "RECDATO" => "IDAlumno");
        $datosInv = array("NombreAlumno", "ApellidoPaternoAlumno", "ApellidoMaternoAlumno", "CorreoAlumno");

        $this->estrucInvol["asistenciasalumnos"] = array("CARAC" => $caracAsis, "COND" => $condAsisInv);
        $this->estrucInvol["alumnos"] = array("CARAC" => $caracAlm, "DATOS" => $datosInv, "COND" => $condAlmInv, "UNIR" => $unionAlm);
        $this->estrucInvol["cargaacademica"] = array("CARAC" => $caracCGAC, "COND" => $condCGACInv, "UNIR" => $unionCGACInv);
    }
}
