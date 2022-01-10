<?php

class ControlBD
{
    private Query $objQuery;
    private array $estrucRestau;
    private array $estrucElimin;

    public function __construct(Query $objQuery)
    {
        $this->objQuery = $objQuery;
        $this->ArmarEstruc();
    }

    public function EliminarBD()
    {
        foreach ($this->estrucElimin as $TABLAINDIVIDUAL) {
            $this->objQuery->DELETE($TABLAINDIVIDUAL, array());
        }
    }

    public function Respaldar()
    {
        foreach ($this->estrucElimin as $TABLAINDIVIDUAL) {
            $this->objQuery->SELECT($TABLAINDIVIDUAL, array());
        }
    }

    public function Restaurar()
    {

    }

    private function ArmarEstruc()
    {
        $caracExt = array("ALIAS" => "EX", "TABLA" => "externos", "DESDE" => "si");
        $condResAl = array("FechaAlumno <");
        $caracResAl = array("ALIAS" => "RSAL", "TABLA" => "reservacionesalumnos", "DESDE" => "si");
        $condResEx = array("FechaExterno <");
        $caracResEx = array("ALIAS" => "RSEX", "TABLA" => "reservacionesexternos", "DESDE" => "si");
        $condInciden = array("FechaLimiteSuspencio <");
        $caracInciden = array("ALIAS" => "INC", "TABLA" => "incidentes", "DESDE" => "si");
        $caracAsisAl = array("ALIAS" => "ASAL", "TABLA" => "asistenciasalumnos", "DESDE" => "si");
        $caracAsisEx = array("ALIAS" => "ASEX", "TABLA" => "asistenciasexternos", "DESDE" => "si");

        $this->estrucElimin["externos"][] = array("CARAC" => $caracExt);
        $this->estrucElimin["reservacionesalumnos"][] = array("CARAC" => $caracResAl, "COND" => $condResAl);
        $this->estrucElimin["reservacionesexternos"][] = array("CARAC" => $caracResEx, "COND" => $condResEx);
        $this->estrucElimin["incidentes"][] = array("CARAC" => $caracInciden, "COND" => $condInciden);
        $this->estrucElimin["asistenciasalumnos"][] = array("CARAC" => $caracAsisAl);
        $this->estrucElimin["asistenciasexternos"][] = array("CARAC" => $caracAsisEx);

        // ESTRUCTA DE RESTAURACION
        $datosExt = array("*");
    }
}
